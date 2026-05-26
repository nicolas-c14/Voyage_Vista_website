<nav class="navbar navbar-expand-lg navbar-dark custom-navbar">
    <div class="container">

        <a class="navbar-brand fw-bold" href="index.php">
            VoyageVista
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarContent">

            <ul class="navbar-nav ms-auto align-items-lg-center">

                <li class="nav-item">
                    <a class="nav-link" href="index.php">Accueil</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="destinations.php">Destinations</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#">Offres</a>
                </li>

                <!-- RESERVATIONS LINK -->
                <?php if(isset($_SESSION["user_id"])): ?>

                <li class="nav-item">

                    <a class="nav-link"
                    href="/VoyageVista/reservations/my-reservations.php">

                        Mes réservations

                    </a>

                </li>

                <?php endif; ?>

                <!-- ADMIN LINK -->
                <?php if(
                    isset($_SESSION["user_role"]) &&
                    $_SESSION["user_role"] === "admin"
                ): ?>

                    <li class="nav-item">

                        <a class="nav-link"
                        href="/VoyageVista/admin/dashboard.php">

                            Admin

                        </a>

                    </li>

                <?php endif; ?>

                <!-- CONNEXION / DÉCONNEXION -->
                <?php if(isset($_SESSION["user_id"])): ?>

                    <span class="text-white me-3">

                        Bonjour
                        <?= $_SESSION["user_name"]; ?>

                    </span>

                    <a class="btn btn-danger"
                    href="/VoyageVista/auth/logout.php">

                        Déconnexion

                    </a>

                <?php else: ?>

                    <a class="btn btn-light"
                    href="login.php">

                        Se connecter

                    </a>

                <?php endif; ?>
               
            </ul>

        </div>

    </div>
</nav>
