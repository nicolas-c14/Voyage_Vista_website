<?php
require_once __DIR__ . '/../includes/auth_middleware.php';
require_once __DIR__ . '/../includes/csrf.php';
require_once __DIR__ . '/../config/database.php';

header('Content-Type: application/json; charset=utf-8');

// A FAIRE: valider les donnees de paiement simulees (date d'expiration/CVV) sans stockage sensible.
// A FAIRE: ajouter une verification de conflits de dates par hebergement (anti double-reservation).

require_role(['client', 'agency', 'admin'], '../login.php');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

$token = $_POST['csrf_token'] ?? '';
if (!csrf_validate($token)) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid CSRF token']);
    exit;
}

$userId = (int)($_SESSION['user_id'] ?? 0);
$destinationId = (int)($_POST['destination_id'] ?? 0);
$checkIn = $_POST['check_in'] ?? '';
$checkOut = $_POST['check_out'] ?? '';
$travelers = (int)($_POST['travelers'] ?? 1);
$transportId = (int)($_POST['transport_id'] ?? 0);
$hebergementId = (int)($_POST['hebergement_id'] ?? 0);
$activityId = (int)($_POST['activity_id'] ?? 0);
$paymentNumber = preg_replace('/\D+/', '', $_POST['payment_number'] ?? '');

if ($userId <= 0 || $destinationId <= 0 || empty($checkIn) || empty($checkOut)) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing required fields']);
    exit;
}

if ($travelers <= 0) {
    http_response_code(400);
    echo json_encode(['error' => 'Travelers must be greater than 0']);
    exit;
}

if (strtotime($checkIn) === false || strtotime($checkOut) === false || strtotime($checkIn) >= strtotime($checkOut)) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid dates']);
    exit;
}

// A FAIRE: bloquer les reservations sur des dates passees selon les regles metier.

if (strlen($paymentNumber) < 12 || strlen($paymentNumber) > 19) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid payment number']);
    exit;
}

$nights = (int)((strtotime($checkOut) - strtotime($checkIn)) / 86400);
if ($nights <= 0) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid stay duration']);
    exit;
}

try {
    $db = get_database_connection();
    $db->beginTransaction();

    // Destination exists check
    $stmt = $db->prepare('SELECT id FROM destinations WHERE id = ? LIMIT 1');
    $stmt->execute([$destinationId]);
    if (!$stmt->fetch(PDO::FETCH_ASSOC)) {
        throw new RuntimeException('Destination not found');
    }

    $total = 0.0;
    $transportPriceTotal = 0.0;
    $hebergementPriceTotal = 0.0;
    $activityPriceTotal = 0.0;

    if ($transportId > 0) {
        $stmt = $db->prepare('SELECT id, price, available FROM transports WHERE id = ? FOR UPDATE');
        $stmt->execute([$transportId]);
        $transport = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$transport) {
            throw new RuntimeException('Transport not found');
        }
        if ((int)$transport['available'] < $travelers) {
            throw new RuntimeException('Transport not available for requested travelers');
        }
        $transportPriceTotal = (float)$transport['price'] * $travelers;

        $stmt = $db->prepare('UPDATE transports SET available = available - ? WHERE id = ?');
        $stmt->execute([$travelers, $transportId]);

        // A FAIRE: enregistrer un journal d'inventaire (avant/apres) pour audit en cas de litige.
    }

    if ($hebergementId > 0) {
        $stmt = $db->prepare('SELECT id, price_night FROM hebergements WHERE id = ? FOR UPDATE');
        $stmt->execute([$hebergementId]);
        $hebergement = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$hebergement) {
            throw new RuntimeException('Accommodation not found');
        }
        $hebergementPriceTotal = (float)$hebergement['price_night'] * $nights;
    }

    if ($activityId > 0) {
        $stmt = $db->prepare('SELECT id, price_person, capacity_max FROM activites WHERE id = ? FOR UPDATE');
        $stmt->execute([$activityId]);
        $activity = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$activity) {
            throw new RuntimeException('Activity not found');
        }
        if (!is_null($activity['capacity_max']) && (int)$activity['capacity_max'] < $travelers) {
            throw new RuntimeException('Activity capacity exceeded');
        }
        $activityPriceTotal = (float)$activity['price_person'] * $travelers;
    }

    $total = $transportPriceTotal + $hebergementPriceTotal + $activityPriceTotal;
    $reference = 'VV-' . date('YmdHis') . '-' . random_int(1000, 9999);
    $paymentLast4 = substr($paymentNumber, -4);

    $stmt = $db->prepare('INSERT INTO reservations (user_id, destination_id, check_in, check_out, travelers, total, reference, status, payment_last4) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)');
    $stmt->execute([$userId, $destinationId, $checkIn, $checkOut, $travelers, $total, $reference, 'confirmed', $paymentLast4]);
    $reservationId = (int)$db->lastInsertId();

    if ($transportId > 0) {
        $stmt = $db->prepare('INSERT INTO reservation_transports (reservation_id, transport_id, nb_voyageurs, price_total) VALUES (?, ?, ?, ?)');
        $stmt->execute([$reservationId, $transportId, $travelers, $transportPriceTotal]);
    }

    if ($hebergementId > 0) {
        $stmt = $db->prepare('INSERT INTO reservation_hebergements (reservation_id, hebergement_id, nights, price_total) VALUES (?, ?, ?, ?)');
        $stmt->execute([$reservationId, $hebergementId, $nights, $hebergementPriceTotal]);
    }

    if ($activityId > 0) {
        $stmt = $db->prepare('INSERT INTO reservation_activites (reservation_id, activite_id, activity_date, nb_participants, price_total) VALUES (?, ?, ?, ?, ?)');
        $stmt->execute([$reservationId, $activityId, $checkIn, $travelers, $activityPriceTotal]);
    }

    $notificationTitle = 'Reservation confirmed';
    $notificationContent = 'Your reservation ' . $reference . ' has been confirmed.';
    $stmt = $db->prepare('INSERT INTO notifications (user_id, type, title, content, is_read) VALUES (?, ?, ?, ?, 0)');
    $stmt->execute([$userId, 'reservation', $notificationTitle, $notificationContent]);

    // A FAIRE: declencher des rappels J-7/J-2 via un cron qui lit les reservations confirmees.

    $db->commit();

    echo json_encode([
        'success' => true,
        'reservation_id' => $reservationId,
        'reference' => $reference,
        'total' => number_format($total, 2, '.', ''),
        'payment_last4' => $paymentLast4
    ]);
    exit;

} catch (Throwable $e) {
    if (isset($db) && $db instanceof PDO && $db->inTransaction()) {
        $db->rollBack();
    }
    error_log('Reservation confirm error: ' . $e->getMessage());
    http_response_code(400);
    $payload = ['error' => 'Reservation failed'];
    if (getenv('APP_ENV') !== 'production') {
        $payload['details'] = $e->getMessage();
    }
    echo json_encode($payload);
    exit;
}
