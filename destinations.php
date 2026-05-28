<?php

session_start();

require_once __DIR__ . "/models/destinationModel.php";

/* =========================
   GET DESTINATIONS
========================= */

$search = trim($_GET['q'] ?? '');

$destinations = getAllDestinations($search);

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
    <link rel="icon" href="assets/images/VoyageVistaLogo.png" type="image/png">


    <!-- Bootstrap -->
    <link rel="stylesheet"
          href="assets/css/bootstrap.min.css">

    <!-- CSS -->
    <link rel="stylesheet"
          href="assets/css/style.css">

</head>

<body>

    <!-- NAVBAR -->
    <?php include __DIR__ . '/includes/navbar.php'; ?>

    <!-- DESTINATIONS -->
    <section class="container py-5">

        <div class="text-center mb-5">

            <h1 class="fw-bold">
                Choisissez votre destination
            </h1>

            <p>
                Explorez les meilleures destinations disponibles.
            </p>

            <form class="row g-2 justify-content-center mt-4"
                  action="destinations.php"
                  method="GET">

                <div class="col-md-6">

                    <input type="text"
                           name="q"
                           class="form-control form-control-lg"
                           placeholder="Rechercher par nom, pays ou description"
                           value="<?= htmlspecialchars($search); ?>">

                </div>

                <div class="col-md-auto">

                    <button type="submit"
                            class="btn btn-primary btn-lg">

                        Rechercher

                    </button>

                </div>

            </form>

            <?php if ($search !== ''): ?>

                <div class="alert alert-info mt-4 mb-0 d-inline-block">

                    Résultats pour : <strong><?= htmlspecialchars($search); ?></strong>

                </div>

            <?php endif; ?>

        </div>

        <!-- DESTINATIONS GRID -->
        <div class="row g-4">

            <?php if (empty($destinations)): ?>

                <div class="col-12">

                    <div class="alert alert-warning mb-0">

                        Aucune destination ne correspond à votre recherche.

                    </div>

                </div>

            <?php endif; ?>

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
    <?php include __DIR__ . '/includes/footer.php'; ?>

</body>

</html>