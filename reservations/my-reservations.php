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

    <div class="container py-5">

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

            <!-- LOOP RESERVATIONS -->
            <?php foreach($reservations as $reservation): ?>

                <?php

                $checkIn =
                    new DateTime(
                        $reservation["check_in"]
                    );

                $checkOut =
                    new DateTime(
                        $reservation["check_out"]
                    );

                $nights =
                    $checkIn->diff($checkOut)->days;

                ?>

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

                                📅 Arrivée :
                                <?= $reservation["check_in"]; ?>

                            </p>

                            <p>

                                📅 Départ :
                                <?= $reservation["check_out"]; ?>

                            </p>

                            <p>

                                👥
                                <?= $reservation["persons"]; ?>
                                personne(s)

                            </p>

                            <p>

                                🌙
                                <?= $nights; ?>
                                nuit(s) 

                            </p>

                            <p class="fw-bold text-primary">

                                💰
                                <?= $reservation["total_price"]; ?> €

                            </p>

                            <p>

                                📌 Statut :
                                
                                <span class="badge bg-success">

                                    <?= $reservation["status"]; ?>

                                </span>

                            </p>

                        </div>

                        <div class="card-footer bg-white border-0">

                            <a href="delete-reservation.php?id=<?= $reservation["id"]; ?>"
                            class="btn btn-outline-danger w-100">

                                Annuler la réservation

                            </a>

                        </div>

                    </div>

                </div>

            <?php endforeach; ?>

        </div>

    </div>

</body>

</html>