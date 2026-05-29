<?php

session_start();

require_once "../models/reservationModel.php";

if(
    !isset($_SESSION["user_role"])
    || $_SESSION["user_role"] !== "agency"
){
    die("Accès refusé");
}

$id = intval($_GET["id"]);

updateReservationStatus(
    $id,
    "confirmed"
);

header(
    "Location: manage-reservations.php"
);

exit;