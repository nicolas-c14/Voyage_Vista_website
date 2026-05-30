<?php
session_start();
require_once __DIR__ . "/../models/cartModel.php";

if (!isset($_SESSION["user_id"]) || $_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: index.php");
    exit;
}

$itemId = intval($_POST["item_id"] ?? 0);
if ($itemId > 0) {
    removeFromCart($itemId, $_SESSION["user_id"]);
}

header("Location: index.php?removed=1");
exit;
?>