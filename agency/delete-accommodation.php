<?php

session_start();

require_once __DIR__ . "/../models/accommodationModel.php";

/* =========================
   SECURITY
========================= */

if (
    !isset($_SESSION["user_role"]) ||
    $_SESSION["user_role"] !== "agency"
) {

    die("Accès interdit.");

}

/* =========================
   DELETE
========================= */

if (!isset($_GET["id"])) {

    die("ID manquant.");

}

$id = intval($_GET["id"]);

deleteAccommodation($id);

header("Location: dashboard.php");

exit;