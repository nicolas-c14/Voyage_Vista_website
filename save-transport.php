<?php

session_start();

require_once __DIR__ . '/config/app.php';
require_once __DIR__ . '/config/database.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ' . APP_URL . '/login.php');
    exit;
}

if (!isset($_GET['reservation_id'], $_GET['transport_id'])) {
    die('Paramètres de transport invalides.');
}

$reservationId = intval($_GET['reservation_id']);
$transportId = intval($_GET['transport_id']);

$stmt = $pdo->prepare("
SELECT id, persons
FROM reservations
WHERE id = ?
AND user_id = ?
");
$stmt->execute([$reservationId, $_SESSION['user_id']]);
$reservation = $stmt->fetch();

if (!$reservation) {
    die('Réservation introuvable.');
}

$sql = "
UPDATE reservations
SET transport_id = ?
WHERE id = ?
";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    $transportId,
    $reservationId
]);

$sql = "
UPDATE transports
SET available_seats = available_seats - (
    SELECT persons
    FROM reservations
    WHERE id = ?
)
WHERE id = ?
";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    $reservationId,
    $transportId
]);

header(
    "Location: choose-activity.php?reservation_id=" . $reservationId
);

exit;