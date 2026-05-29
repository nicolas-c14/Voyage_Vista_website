<?php

session_start();

require_once __DIR__ . "/../models/accommodationModel.php";

/* =========================
   SECURITY
========================= */

if (
    !isset($_SESSION["user_role"]) ||
    $_SESSION["user_role"] !== "agency"
) {

    die("Accès interdit.");

}

/* =========================
   GET ACCOMMODATIONS
========================= */

$accommodations =
    getAllAccommodations();

?>

<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">

    <title>
        Dashboard Agency
    </title>

    <link rel="stylesheet"
          href="../assets/css/bootstrap.min.css">

    <link rel="stylesheet"
          href="../assets/css/style.css">

</head>

<body>

<?php include __DIR__ . '/../includes/navbar.php'; ?>

    <div class="container py-5">

        <div class="d-flex justify-content-between align-items-center mb-5">

            <h1>
                Gestion des hébergements
            </h1>

            <a href="add-accommodation.php"
            class="btn btn-primary">

                Ajouter un hébergement

            </a>

            <a href="manage-reservations.php"
            class="btn btn-outline-primary">

                Gérer les réservations

            </a>

        </div>

        <div class="row g-4">

            <?php foreach($accommodations as $accommodation): ?>

                <div class="col-md-4">

                    <div class="card h-100 shadow-sm">

                        <img src="../assets/images/<?= $accommodation["image"]; ?>"
                            class="card-img-top">

                        <div class="card-body">

                            <h5>

                                <?= $accommodation["name"]; ?>

                            </h5>

                            <p>

                                <?= $accommodation["type"]; ?>

                            </p>

                            <p>

                                <?= $accommodation["price_per_night"]; ?> €
                                / nuit

                            </p>

                        </div>

                        <div class="d-flex gap-2 mt-3">

                            <a href="edit-accommodation.php?id=<?= $accommodation["id"]; ?>"
                            class="btn btn-warning w-100">

                                Modifier

                            </a>

                            <a href="delete-accommodation.php?id=<?= $accommodation["id"]; ?>"
                            class="btn btn-danger w-100"
                            onclick="return confirm('Supprimer cet hébergement ?')">

                                Supprimer

                            </a>

                        </div>
                    
                    </div>

                </div>

            <?php endforeach; ?>

        </div>

    </div>

</body>

</html>

