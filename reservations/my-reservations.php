<?php

session_start();

require_once __DIR__ . "/../models/reservationModel.php";

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

$hasReservations = !empty($reservations);

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

    <link rel="stylesheet"
          href="../assets/css/style.css">

</head>

<body>

<?php include __DIR__ . '/../includes/navbar.php'; ?>

    <h1 class="mb-5">

        Mes réservations

    </h1>

    <div class="row g-4">

        <?php if(!$hasReservations): ?>

            <div class="col-12">

                <div class="alert alert-info mb-0">

                    Vous n'avez pas encore de réservation.

                </div>

            </div>

        <?php endif; ?>

        <?php foreach($reservations as $reservation): ?>

            <div class="col-md-4">

                <div class="card h-100 shadow-sm">

                    <img src="../assets/images/<?= $reservation["image"]; ?>"
                         class="card-img-top">

                    <div class="card-body">

                        <h5>

                            <?= $reservation["accommodation_name"]; ?>

                        </h5>

                        <p>

                            <?= $reservation["destination_name"]; ?>    

                        </p>

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

                    <a href="delete-reservation.php?id=<?= $reservation["id"]; ?>"
                    class="btn btn-danger">

                        Annuler

                    </a>

                </div>

            </div>

        <?php endforeach; ?>

    </div>

</div>

</body>

</html>