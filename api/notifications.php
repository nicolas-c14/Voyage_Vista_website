<?php
require_once __DIR__ . '/../includes/auth_middleware.php';
require_once __DIR__ . '/../config/database.php';

header('Content-Type: application/json; charset=utf-8');

// A FAIRE: ajouter pagination par curseur/offset pour les comptes avec beaucoup de notifications.
// A FAIRE: ajouter filtrage par type (reservation, trajet, promotion, systeme).

require_role(['client', 'agency', 'admin'], '../login.php');

$userId = (int)($_SESSION['user_id'] ?? 0);
if ($userId <= 0) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

$action = $_GET['action'] ?? 'list';

try {
    $db = get_database_connection();

    if ($action === 'count') {
        $stmt = $db->prepare('SELECT COUNT(*) AS unread_count FROM notifications WHERE user_id = ? AND is_read = 0');
        $stmt->execute([$userId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC) ?: ['unread_count' => 0];
        echo json_encode(['success' => true, 'unread_count' => (int)$row['unread_count']]);
        exit;
    }

    if ($action === 'mark_read') {
        $notificationId = (int)($_POST['id'] ?? 0);
        if ($notificationId <= 0) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid notification id']);
            exit;
        }

        $stmt = $db->prepare('UPDATE notifications SET is_read = 1, read_at = NOW() WHERE id = ? AND user_id = ?');
        $stmt->execute([$notificationId, $userId]);
        echo json_encode(['success' => true]);
        exit;
    }

    // A FAIRE: ajouter action mark_all_read pour marquer toutes les notifications en une fois.

    // default: list
    $limit = (int)($_GET['limit'] ?? 20);
    if ($limit <= 0 || $limit > 100) {
        $limit = 20;
    }

    $stmt = $db->prepare('SELECT id, type, title, content, is_read, created_at FROM notifications WHERE user_id = ? ORDER BY created_at DESC LIMIT ' . $limit);
    $stmt->execute([$userId]);
    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(['success' => true, 'items' => $items]);
    exit;

} catch (Throwable $e) {
    error_log('Notifications API error: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Server error']);
    exit;
}
