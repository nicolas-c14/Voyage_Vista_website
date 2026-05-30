<?php
session_start();
require_once __DIR__ . "/../models/cartModel.php";

/* =========================
   LOGIN CHECK
========================= */
if (!isset($_SESSION["user_id"])) {
    header("Location: ../login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../destinations.php");
    exit;
}

$accommodationId = intval($_POST["accommodation_id"] ?? 0);
$checkIn         = $_POST["check_in"] ?? "";
$checkOut        = $_POST["check_out"] ?? "";
$persons         = intval($_POST["persons"] ?? 1);

/* =========================
   VALIDATION
========================= */
if ($accommodationId <= 0 || empty($checkIn) || empty($checkOut) || $persons <= 0) {
    die("Données invalides.");
}
if ($checkOut <= $checkIn) {
    die("La date de départ doit être après la date d'arrivée.");
}
if ($checkIn < date("Y-m-d")) {
    die("La date d'arrivée est invalide.");
}

addToCart(
    $_SESSION["user_id"],
    $accommodationId,
    $checkIn,
    $checkOut,
    $persons
);

header("Location: index.php?added=1");
exit;
?>