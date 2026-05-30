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
    <link rel="icon" href="../assets/images/VoyageVistaLogo.png" type="image/png">


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

                /* Calcul d'une nouvelle date si la résa est passée
                   (pour permettre la re-réservation au panier) */
                $today = new DateTime("today");
                $cartCheckIn  = $reservation["check_in"];
                $cartCheckOut = $reservation["check_out"];
                if ($checkIn < $today) {
                    $newCheckIn  = (clone $today)->modify("+1 day");
                    $newCheckOut = (clone $newCheckIn)->modify("+{$nights} day");
                    $cartCheckIn  = $newCheckIn->format("Y-m-d");
                    $cartCheckOut = $newCheckOut->format("Y-m-d");
                }

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

                            <?php if($reservation["transport_type"]): ?>

                            <p class="mt-2">

                                ✈ Transport :

                                <?= $reservation["transport_type"]; ?>

                                <br>

                                <?= $reservation["departure_city"]; ?>

                                →

                                <?= $reservation["arrival_city"]; ?>

                            </p>

                            <?php endif; ?>

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
                                
                                <?php

                                $statusClass = "bg-secondary";

                                if ($reservation["status"] === "confirmed") {

                                    $statusClass = "bg-success";

                                }

                                elseif ($reservation["status"] === "pending") {

                                    $statusClass = "bg-warning";

                                }

                                elseif ($reservation["status"] === "cancelled") {

                                    $statusClass = "bg-danger";

                                }

                                elseif ($reservation["status"] === "completed") {

                                    $statusClass = "bg-primary";

                                }

                                ?>

                                <span class="badge <?= $statusClass; ?>">

                                    <?= ucfirst($reservation["status"]); ?>

                                </span>

                            </p>

                        </div>

                        <div class="card-footer bg-white border-0">

                            <a href="edit-reservation.php?id=<?= $reservation["id"]; ?>"
                            class="btn btn-outline-primary w-100 mb-2">

                                Modifier

                            </a>

                            <!-- BOUTON AJOUTER AU PANIER -->
                            <form method="POST"
                                  action="../cart/add.php">
                                <input type="hidden"
                                       name="accommodation_id"
                                       value="<?= $reservation["accommodation_id"]; ?>">
                                <input type="hidden"
                                       name="check_in"
                                       value="<?= $cartCheckIn; ?>">
                                <input type="hidden"
                                       name="check_out"
                                       value="<?= $cartCheckOut; ?>">
                                <input type="hidden"
                                       name="persons"
                                       value="<?= $reservation["persons"]; ?>">
                                <button type="submit"
                                        class="btn btn-outline-primary w-100">
                                    🛒 Ajouter au panier
                                </button>
                            </form>

                            <!-- BOUTON ANNULER -->
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