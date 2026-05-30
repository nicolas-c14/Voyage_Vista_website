<?php

session_start();

require_once __DIR__ . "/../models/reservationModel.php";
require_once __DIR__ . "/../models/notificationModel.php";

if(
    !isset($_SESSION["user_role"])
    || $_SESSION["user_role"] !== "agency"
){
    die("Accès refusé");
}

$id = intval($_GET["id"]);

$reservation =
    getReservationByIdAgency($id);

updateReservationStatus(
    $id,
    "cancelled"
);

createNotification(

    $reservation["user_id"],

    "Réservation annulée",

    "Votre réservation pour "
    . $reservation["accommodation_name"]
    . " a été annulée."

);

header(
    "Location: manage-reservations.php"
);

exit;