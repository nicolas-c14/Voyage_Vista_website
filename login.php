<?php session_start(); ?>

<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Connexion - VoyageVista</title>
    <link rel="icon" href="assets/images/VoyageVistaLogo.png" type="image/png">
    

    <!-- Bootstrap -->
    <link rel="stylesheet"
          href="assets/css/bootstrap.min.css">

    <!-- CSS -->
    <link rel="stylesheet"
          href="assets/css/style.css">

</head>

<body class="login-body">

    <!-- NAVBAR -->
    <?php include 'includes/navbar.php'; ?>

    <div class="login-container">

        <div class="login-card">

            <h2 class="text-center mb-4">
                Connexion
            </h2>

            <!-- LOGIN FORM -->
            <form action="auth/login.php"
                  method="POST"
                  id="loginForm">

                <!-- EMAIL -->
                <div class="mb-3">

                    <label for="email"
                           class="form-label">

                        Email

                    </label>

                    <input type="email"
                           class="form-control"
                           id="email"
                           name="email"
                           required>

                </div>

                <!-- PASSWORD -->
                <div class="mb-3">

                    <label for="password"
                           class="form-label">

                        Mot de passe

                    </label>

                    <input type="password"
                           class="form-control"
                           id="password"
                           name="password"
                           required>

                </div>

                <!-- BUTTON -->
                <button type="submit"
                        class="btn btn-primary w-100">

                    Se connecter

                </button>

            </form>

            <p class="text-center mt-3">

                Pas encore de compte ?

                <a href="register.php">
                    S'inscrire
                </a>

            </p>

        </div>

    </div>

</body>

</html>