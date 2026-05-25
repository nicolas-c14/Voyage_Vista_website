<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - VoyageVista</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">

    <!-- CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body class="login-body">

    <!-- CONNEXION CARD -->
    <div class="login-container">

        <div class="login-card">

            <h2 class="text-center mb-4">
                Connexion
            </h2>

            <?php require_once 'includes/csrf.php'; ?>
            <form id="loginForm" action="auth/login.php" method="POST">

                <?php echo csrf_input_field(); ?>

                <div class="mb-3">

                    <label>Email</label>

                    <input type="email"
                        class="form-control"
                        placeholder="Entrez votre email"
                        name="email"
                        required>

                </div>

                <div class="mb-3">

                    <label>Mot de passe</label>

                    <input type="password"
                        class="form-control"
                        placeholder="Entrez votre mot de passe"
                        name="password"
                        required>

                </div>

                <button class="btn btn-primary w-100">
                    Se connecter
                </button>

            </form>

            <p class="text-center mt-3">
                Pas encore inscrit ?
                <a href="register.php">Créer un compte</a>
            </p>

        </div>

    </div>

</body>

</html>