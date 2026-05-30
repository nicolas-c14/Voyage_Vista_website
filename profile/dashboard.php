<?php

require_once __DIR__ . "/../models/userModel.php";

session_start();

if(!isset($_SESSION["user_id"])) {

    header("Location: ../login.php");
    exit;

}

$user =
    getUserById(
        $_SESSION["user_id"]
    );

?>

<!DOCTYPE html>
<html lang="fr">

<head>

<meta charset="UTF-8">

<title>
    Mon compte
</title>

<link rel="stylesheet"
href="../assets/css/bootstrap.min.css">

<link rel="stylesheet"
href="../assets/css/style.css">

</head>

<body>

    <?php include __DIR__ . '/../includes/navbar.php'; ?>

    <div class="container py-5">

        <h1 class="mb-5">

            Bienvenue
            <?= $_SESSION["user_name"]; ?>

        </h1>

        <div class="card shadow-sm mb-5">

            <div class="card-body">

                <h4>

                    <?= $user["first_name"]; ?>
                    <?= $user["last_name"]; ?>

                </h4>

                <p class="mb-0">

                    <?= $user["email"]; ?>

                </p>

            </div>

        </div>

        <div class="row g-4">

            <div class="col-md-4">

                <div class="card text-center">

                    <div class="card-body">

                        <h4>
                            Profil
                        </h4>

                        <p>
                            Consulter et modifier vos informations.
                        </p>

                        <a href="edit-profile.php"
                        class="btn btn-primary">

                            Modifier mon profil

                        </a>

                    </div>

                </div>

            </div>

            <div class="col-md-4">

                <div class="card text-center">

                    <div class="card-body">

                        <h4>
                            Réservations
                        </h4>

                        <p>
                            Consulter vos séjours.
                        </p>

                        <a href="../reservations/my-reservations.php"
                        class="btn btn-primary">

                            Voir

                        </a>

                    </div>

                </div>

            </div>

            <div class="col-md-4">

                <div class="card text-center">

                    <div class="card-body">

                        <h4>
                            Notifications
                        </h4>

                        <p>
                            Consulter vos alertes.
                        </p>

                        <a href="../notifications/index.php"
                        class="btn btn-primary">

                            Voir

                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

</body>
</html>