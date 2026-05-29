<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();

require_once __DIR__ . "/../models/accommodationModel.php";
require_once __DIR__ . "/../models/reservationModel.php";

/* =========================
   LOGIN CHECK
========================= */

if (!isset($_SESSION["user_id"])) {

    header("Location: ../login.php");

    exit;

}

/* =========================
   GET ACCOMMODATION
========================= */

if (!isset($_GET["accommodation_id"])) {

    die("Hébergement invalide.");

}

$accommodationId =
    intval($_GET["accommodation_id"]);

$accommodation =
    getAccommodationById(
        $accommodationId
    );

if (!$accommodation) {

    die("Hébergement introuvable.");

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

        $accommodationId,

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

    <link rel="stylesheet"
          href="../assets/css/style.css">

</head>

<body>

<?php include __DIR__ . '/../includes/navbar.php'; ?>

<div class="container py-5">

    <h1 class="mb-5">

        Réserver :
        <?= $accommodation["name"]; ?>

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