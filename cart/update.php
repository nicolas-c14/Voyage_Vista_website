<?php
session_start();
require_once __DIR__ . "/../models/cartModel.php";

if (!isset($_SESSION["user_id"]) || $_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: index.php");
    exit;
}

$itemId   = intval($_POST["item_id"] ?? 0);
$checkIn  = $_POST["check_in"] ?? "";
$checkOut = $_POST["check_out"] ?? "";
$persons  = intval($_POST["persons"] ?? 1);

if ($itemId <= 0 || empty($checkIn) || empty($checkOut) || $persons <= 0) {
    header("Location: index.php?error=invalid");
    exit;
}
if ($checkOut <= $checkIn) {
    header("Location: index.php?error=dates");
    exit;
}

updateCartItem(
    $itemId,
    $_SESSION["user_id"],
    $checkIn,
    $checkOut,
    $persons
);

header("Location: index.php?updated=1");
exit;
?>