<?php
require_once __DIR__ . '/includes/auth_middleware.php';
require_role(['client', 'agency', 'admin'], 'login.php');
require_once __DIR__ . '/config/database.php';

// A FAIRE: migrer ce marquage "lu" vers un appel AJAX (sans rechargement complet de page).

$items = [];
$dbError = '';

try {
    $db = get_database_connection();
    $userId = (int)($_SESSION['user_id'] ?? 0);
    $stmt = $db->prepare('SELECT id, type, title, content, is_read, created_at FROM notifications WHERE user_id = ? ORDER BY created_at DESC LIMIT 50');
    $stmt->execute([$userId]);
    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['mark_read_id'])) {
        $markReadId = (int)$_POST['mark_read_id'];
        $stmt = $db->prepare('UPDATE notifications SET is_read = 1, read_at = NOW() WHERE id = ? AND user_id = ?');
        $stmt->execute([$markReadId, $userId]);
        header('Location: notifications.php');
        exit;
    }
} catch (Throwable $e) {
    $dbError = 'Impossible de charger les notifications pour le moment.';
    error_log('notifications.php error: ' . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications - VoyageVista</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php include 'includes/navbar.php'; ?>

    <main class="container py-5">
        <h1 class="h3 mb-4">Mes notifications</h1>
        <!-- A FAIRE: ajouter des filtres UI par categorie et par statut (lu/non lu). -->

        <?php if ($dbError !== ''): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($dbError, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></div>
        <?php endif; ?>

        <?php if (empty($items)): ?>
            <div class="alert alert-info">Aucune notification pour le moment.</div>
        <?php else: ?>
            <div class="list-group">
                <?php foreach ($items as $item): ?>
                    <div class="list-group-item <?php echo ((int)$item['is_read'] === 0) ? 'list-group-item-warning' : ''; ?>">
                        <div class="d-flex w-100 justify-content-between align-items-center">
                            <h5 class="mb-1"><?php echo htmlspecialchars($item['title'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></h5>
                            <small><?php echo htmlspecialchars($item['created_at'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></small>
                        </div>
                        <p class="mb-1"><?php echo htmlspecialchars($item['content'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></p>
                        <small class="text-muted">Type: <?php echo htmlspecialchars($item['type'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></small>

                        <?php if ((int)$item['is_read'] === 0): ?>
                            <form method="POST" class="mt-2">
                                <input type="hidden" name="mark_read_id" value="<?php echo (int)$item['id']; ?>">
                                <button type="submit" class="btn btn-sm btn-outline-secondary">Marquer comme lu</button>
                            </form>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </main>
</body>
</html>
