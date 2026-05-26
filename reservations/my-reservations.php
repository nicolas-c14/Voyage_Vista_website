<?php

session_start();

require_once "../models/reservationModel.php";

/* =========================
   LOGIN CHECK
========================= */

if (!isset($_SESSION["user_id"])) {

    header("Location: ../login.php");

    exit;

}

/* =========================
   GET RESERVATIONS
========================= */

$reservations =
    getReservationsByUser(
        $_SESSION["user_id"]
    );

?>

<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">

    <title>
        Mes réservations
    </title>
    <link rel="icon" href="assets/images/VoyageVistaLogo.png" type="image/png">


    <link rel="stylesheet"
          href="../assets/css/bootstrap.min.css">

</head>

<body>

<div class="container py-5">

    <h1 class="mb-5">

        Mes réservations

    </h1>

    <div class="row g-4">

        <?php foreach($reservations as $reservation): ?>

            <div class="col-md-4">

                <div class="card h-100 shadow-sm">

                    <img src="../assets/images/<?= $reservation["image"]; ?>"
                         class="card-img-top">

                    <div class="card-body">

                        <h5>

                            <?= $reservation["name"]; ?>

                        </h5>

                        <p>

                            <?= $reservation["country"]; ?>

                        </p>

                        <p>

                            📅
                            <?= $reservation["travel_date"]; ?>

                        </p>

                        <p>

                            👥
                            <?= $reservation["persons"]; ?>
                            personne(s)

                        </p>

                    </div>

                </div>

            </div>

        <?php endforeach; ?>

    </div>

</div>

</body>

</html>