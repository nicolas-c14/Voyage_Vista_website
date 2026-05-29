<?php

session_start();

require_once "../config/database.php";

/* =========================
   LOGIN CHECK
========================= */

if (!isset($_SESSION["user_id"])) {

    header("Location: ../login.php");
    exit;

}

/* =========================
   CHECK ID
========================= */

if (!isset($_GET["id"])) {

    die("Réservation invalide.");

}

$reservationId =
    intval($_GET["id"]);

/* =========================
   DELETE
========================= */

$stmt = $pdo->prepare(

    "DELETE FROM reservations
     WHERE id = ?
     AND user_id = ?"

);

$stmt->execute([
    $reservationId,
    $_SESSION["user_id"]
]);

/* =========================
   REDIRECT
========================= */

header(
    "Location: my-reservations.php"
);

exit;