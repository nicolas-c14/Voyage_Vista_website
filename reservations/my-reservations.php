<?php

session_start();

require_once __DIR__ . "/../config/app.php";
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
        <link rel="icon" href="<?= APP_URL ?>/assets/images/VoyageVistaLogo.png" type="image/png">


        <link rel="stylesheet"
            href="<?= APP_URL ?>/assets/css/bootstrap.min.css">

        <link rel="stylesheet"
            href="<?= APP_URL ?>/assets/css/style.css">

</head>

<body>

<?php include __DIR__ . '/../includes/navbar.php'; ?>

<div class="container my-5">

    <h1 class="mb-4">Mes réservations</h1>

    <?php if(isset($_GET['deleted'])): ?>
        <div class="alert alert-success">Réservation supprimée.</div>
    <?php elseif(isset($_GET['error'])): ?>
        <div class="alert alert-danger">Impossible de supprimer la réservation.</div>
    <?php endif; ?>

    <?php if(!$hasReservations): ?>

        <div class="alert alert-info">Vous n'avez pas encore de réservation.</div>

    <?php else: ?>

        <div class="row g-4">

            <?php foreach($reservations as $reservation): ?>

                <div class="col-md-4">

                    <div class="card h-100 shadow-sm">

                            <img src="<?= APP_URL ?>/assets/images/<?= htmlspecialchars($reservation["image"]) ?>"
                             class="card-img-top" style="height:200px;object-fit:cover;">

                        <div class="card-body d-flex flex-column">

                            <h5 class="card-title mb-1">
                                <?= htmlspecialchars($reservation["name"]) ?>
                            </h5>

                            <p class="text-muted mb-2"><?= htmlspecialchars($reservation["country"]) ?></p>

                            <p class="mb-2">Date du voyage :<strong></strong> <?= htmlspecialchars($reservation["travel_date"]) ?></p>

                            <p class="mb-3">Nombre de personne(s) :<strong></strong> <?= htmlspecialchars($reservation["persons"]) ?> personne(s)</p>

                            <div class="mt-auto d-flex justify-content-between align-items-center">
                                <a href="<?= APP_URL ?>/destination.php?id=<?= $reservation['destination_id'] ?>" class="btn btn-outline-primary btn-sm">Voir la destination</a>
                                <form method="post" action="delete.php" onsubmit="return confirm('Supprimer cette réservation ?');">
                                    <input type="hidden" name="id" value="<?= $reservation['id'] ?>">
                                    <button class="btn btn-danger btn-sm">Supprimer</button>
                                </form>
                            </div>

                        </div>

                    </div>

                </div>

            <?php endforeach; ?>

        </div>

    <?php endif; ?>

</div>

</body>

</html>
