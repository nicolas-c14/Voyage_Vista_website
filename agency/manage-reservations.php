<?php

session_start();

require_once __DIR__ . "/../models/reservationModel.php";

if(
    !isset($_SESSION["user_role"])
    || $_SESSION["user_role"] !== "agency"
){
    die("Accès interdit.");
}

$reservations =
    getAllReservations();

?>

<!DOCTYPE html>
<html lang="fr">

<head>

<meta charset="UTF-8">

<title>
    Gestion des réservations
</title>

<link rel="stylesheet" href="../assets/css/bootstrap.min.css">
<link rel="stylesheet" href="../assets/css/style.css">

</head>

<body>

<?php include __DIR__ . '/../includes/navbar.php'; ?>

    <div class="container py-5">

        <h1 class="mb-5">
            Réservations clients
        </h1>

        <table class="table table-bordered table-striped">

            <thead>

                <tr>

                    <th>Client</th>
                    <th>Destination</th>
                    <th>Hébergement</th>
                    <th>Dates</th>
                    <th>Statut</th>
                    <th>Actions</th>

                </tr>

            </thead>

            <tbody>

                <?php foreach($reservations as $reservation): ?>

                    <tr>

                        <td>

                            <?= $reservation["first_name"]; ?>
                            <?= $reservation["last_name"]; ?>

                        </td>

                        <td>

                            <?= $reservation["destination_name"]; ?>

                        </td>

                        <td>

                            <?= $reservation["accommodation_name"]; ?>

                        </td>

                        <td>

                            <?= $reservation["check_in"]; ?>
                                →
                            <?= $reservation["check_out"]; ?>

                        </td>

                        <td>

                            <span class="badge bg-secondary">

                                <?= $reservation["status"]; ?>

                            </span>

                        </td>

                        <td>

                            <a
                            href="confirm-reservation.php?id=<?= $reservation["id"]; ?>"
                            class="btn btn-success btn-sm">

                                Confirmer

                            </a>

                            <a
                            href="cancel-reservation.php?id=<?= $reservation["id"]; ?>"
                            class="btn btn-danger btn-sm">

                                Annuler

                            </a>

                        </td>

                    </tr>

                <?php endforeach; ?>

            </tbody>

        </table>

    </div>

    </body>
</html>