<?php session_start(); ?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - VoyageVista</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">

    <!-- CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body class="login-body">

    <div class="login-container">

        <div class="login-card">

            <h2 class="text-center mb-4">
                Créer un compte
            </h2>

            <!-- REGISTER FORM -->
            <form action="auth/register.php"
                  method="POST"
                  id="registerForm">

                <!-- NOM / PRENOM -->
                <div class="row g-3">

                    <div class="col-md-6">

                        <label for="firstName" class="form-label">
                            Prénom
                        </label>

                        <input type="text"
                               class="form-control"
                               id="firstName"
                               name="firstName"
                               required>

                    </div>

                    <div class="col-md-6">

                        <label for="lastName" class="form-label">
                            Nom
                        </label>

                        <input type="text"
                               class="form-control"
                               id="lastName"
                               name="lastName"
                               required>

                    </div>

                </div>

                <!-- EMAIL -->
                <div class="mt-3">

                    <label for="email" class="form-label">
                        Email
                    </label>

                    <input type="email"
                           class="form-control"
                           id="email"
                           name="email"
                           required>

                </div>

                <!-- PASSWORD -->
                <div class="mt-3">

                    <label for="password" class="form-label">
                        Mot de passe
                    </label>

                    <input type="password"
                           class="form-control"
                           id="password"
                           name="password"
                           required>

                    <div class="form-text">

                        Le mot de passe doit contenir uniquement :
                        <ul class="small">
                            <li>8 caractères minimum</li>
                            <li>1 majuscule</li>
                            <li>1 minuscule</li>
                            <li>1 chiffre</li>
                            <li>1 caractère spécial</li>
                        </ul>

                    </div>

                </div>

                <!-- CONFIRM PASSWORD -->
                <div class="mt-3">

                    <label for="confirmPassword" class="form-label">
                        Confirmer le mot de passe
                    </label>

                    <input type="password"
                           class="form-control"
                           id="confirmPassword"
                           name="confirmPassword"
                           required>

                </div>

                <!-- BUTTON -->
                <button type="submit"
                        class="btn btn-primary w-100 mt-4">

                    S'inscrire

                </button>

            </form>

            <p class="text-center mt-3">

                Déjà un compte ?

                <a href="login.php">
                    Se connecter
                </a>

            </p>

        </div>

    </div>

    <!-- JS -->
    <script src="assets/js/script.js"></script>

</body>

</html>