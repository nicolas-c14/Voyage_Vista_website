<?php

session_start();

require_once __DIR__ . "/../models/destinationModel.php";

/* =========================
   ADMIN CHECK
========================= */

if (
    !isset($_SESSION["user_id"]) ||
    $_SESSION["user_role"] !== "admin"
) {

    die("Accès interdit.");

}

/* =========================
   CHECK ID
========================= */

if (!isset($_GET["id"])) {

    die("ID invalide.");

}

$id = intval($_GET["id"]);

/* =========================
   DELETE
========================= */

deleteDestination($id);

/* =========================
   REDIRECT
========================= */

header("Location: dashboard.php");

exit;