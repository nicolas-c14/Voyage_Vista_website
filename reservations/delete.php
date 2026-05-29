<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

require_once __DIR__ . "/../models/reservationModel.php";

if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_POST['id'])) {
    header('Location: ./my-reservations.php');
    exit;
}

$id = (int)$_POST['id'];
$userId = $_SESSION['user_id'];

try {
    $ok = deleteReservation($id, $userId);

    if ($ok) {
        header('Location: ./my-reservations.php?deleted=1');
    } else {
        header('Location: ./my-reservations.php?error=1');
    }

} catch (Exception $e) {
    $logDir = __DIR__ . '/../logs';
    if (!is_dir($logDir)) {
        @mkdir($logDir, 0755, true);
    }
    $logFile = $logDir . '/error.log';
    $msg = date('c') . ' - delete.php error: ' . $e->getMessage() . PHP_EOL;
    @file_put_contents($logFile, $msg, FILE_APPEND);
    header('Location: ./my-reservations.php?error=1');
}

exit;
