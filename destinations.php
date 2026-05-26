<?php

session_start();

require_once "models/destinationModel.php";

/* =========================
   GET DESTINATIONS
========================= */

$destinations = getAllDestinations();

?>

<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>
        Destinations - VoyageVista
    </title>

    <!-- Bootstrap -->
    <link rel="stylesheet"
          href="assets/css/bootstrap.min.css">

    <!-- CSS -->
    <link rel="stylesheet"
          href="assets/css/style.css">

</head>

<body>

    <!-- NAVBAR -->
    <?php include 'includes/navbar.php'; ?>

    <!-- DESTINATIONS -->
    <section class="container py-5">

        <div class="text-center mb-5">

            <h1 class="fw-bold">
                Choisissez votre destination
            </h1>

            <p>
                Explorez les meilleures destinations disponibles.
            </p>

        </div>

        <!-- DESTINATIONS GRID -->
        <div class="row g-4">

            <?php foreach($destinations as $destination): ?>

                <div class="col-md-3">

                    <div class="card destination-card h-100 shadow-sm">

                        <!-- IMAGE -->
                        <img src="assets/images/<?= $destination["image"]; ?>"
                             class="card-img-top"
                             alt="<?= $destination["name"]; ?>">

                        <!-- BODY -->
                        <div class="card-body d-flex flex-column">

                            <h5 class="card-title">

                                <?= $destination["name"]; ?>

                            </h5>

                            <p class="text-muted">

                                <?= $destination["country"]; ?>

                            </p>

                            <p class="small flex-grow-1">

                                <?= substr(
                                    $destination["description"],
                                    0,
                                    80
                                ); ?>...

                            </p>

                            <h6 class="text-primary fw-bold">

                                <?= $destination["price"]; ?> €

                            </h6>

                            <!-- BUTTON -->
                            <a href="destination.php?id=<?= $destination["id"]; ?>"
                               class="btn btn-outline-primary mt-3">

                                Découvrir

                            </a>

                        </div>

                    </div>

                </div>

            <?php endforeach; ?>

        </div>

    </section>

    <!-- FOOTER -->
    <?php include 'includes/footer.php'; ?>

</body>

</html>