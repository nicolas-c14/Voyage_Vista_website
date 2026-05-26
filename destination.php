<?php

session_start();

require_once "models/destinationModel.php";

/* =========================
   CHECK ID
========================= */

if (!isset($_GET["id"])) {

    die("Destination introuvable.");

}

/* =========================
   GET DESTINATION
========================= */

$id = intval($_GET["id"]);

$destination = getDestinationById($id);

/* =========================
   CHECK DESTINATION
========================= */

if (!$destination) {

    die("Destination inexistante.");

}

?>

<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>

        <?= $destination["name"]; ?>

        - VoyageVista

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
    <?php include 'includes/navbar.php'; ?>

    <!-- DESTINATION -->
    <section class="container my-5">

        <div class="row g-5 align-items-center">

            <!-- IMAGE -->
            <div class="col-md-6">

                <img src="assets/images/<?= $destination["image"]; ?>"
                     class="img-fluid rounded shadow"
                     alt="<?= $destination["name"]; ?>">

            </div>

            <!-- CONTENT -->
            <div class="col-md-6">

                <h1 class="fw-bold mb-3">

                    <?= $destination["name"]; ?>

                </h1>

                <h4 class="text-muted mb-4">

                    <?= $destination["country"]; ?>

                </h4>

                <p class="lead">

                    <?= $destination["description"]; ?>

                </p>

                <h3 class="text-primary mt-4">

                    À partir de
                    <?= $destination["price"]; ?> €
                    
                    <?php if(isset($_SESSION["user_id"])): ?>

                        <a href="reservations/book.php?id=<?= $destination["id"]; ?>"
                        class="btn btn-primary mt-4">

                            Réserver

                        </a>

                    <?php else: ?>

                        <a href="login.php"
                        class="btn btn-primary mt-4">

                            Connectez-vous pour réserver

                        </a>

                    <?php endif; ?>

                </h3>

                <a href="destinations.php"
                   class="btn btn-outline-secondary mt-4">

                    Retour aux destinations

                </a>

            </div>

        </div>

    </section>

    <!-- FOOTER -->
    <?php include 'includes/footer.php'; ?>

</body>

</html>