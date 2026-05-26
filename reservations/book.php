<?php

session_start();

require_once "../models/destinationModel.php";
require_once "../models/reservationModel.php";

/* =========================
   LOGIN CHECK
========================= */

if (!isset($_SESSION["user_id"])) {

    header("Location: ../login.php");

    exit;

}

/* =========================
   GET DESTINATION
========================= */

if (!isset($_GET["id"])) {

    die("Destination invalide.");

}

$destinationId =
    intval($_GET["id"]);

$destination =
    getDestinationById($destinationId);

if (!$destination) {

    die("Destination introuvable.");

}

/* =========================
   SUBMIT
========================= */

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $travelDate =
        $_POST["travel_date"];

    $persons =
        intval($_POST["persons"]);

    addReservation(

        $_SESSION["user_id"],

        $destinationId,

        $travelDate,

        $persons

    );

    header(
        "Location: my-reservations.php"
    );

    exit;

}

?>

<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">

    <title>
        Réserver
    </title>
    <link rel="icon" href="assets/images/VoyageVistaLogo.png" type="image/png">


    <link rel="stylesheet"
          href="../assets/css/bootstrap.min.css">

</head>

<body>

<div class="container py-5">

    <h1 class="mb-5">

        Réserver :
        <?= $destination["name"]; ?>

    </h1>

    <form method="POST">

        <!-- DATE -->
        <div class="mb-3">

            <label class="form-label">

                Date du voyage

            </label>

            <input type="date"
                   name="travel_date"
                   class="form-control"
                   required>

        </div>

        <!-- PERSONS -->
        <div class="mb-4">

            <label class="form-label">

                Nombre de personnes

            </label>

            <input type="number"
                   name="persons"
                   class="form-control"
                   min="1"
                   required>

        </div>

        <!-- BUTTON -->
        <button type="submit"
                class="btn btn-primary">

            Confirmer réservation

        </button>

    </form>

</div>

</body>

</html>