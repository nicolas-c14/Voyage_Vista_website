<nav class="navbar navbar-expand-lg navbar-dark custom-navbar">

    <div class="container">

        <a class="navbar-brand fw-bold"
           href="/VoyageVista/index.php">

            VoyageVista

        </a>

        <button class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarContent">

            <span class="navbar-toggler-icon"></span>

        </button>

        <div class="collapse navbar-collapse"
             id="navbarContent">

            <ul class="navbar-nav ms-auto align-items-lg-center">

                <!-- HOME -->
                <li class="nav-item">

                    <a class="nav-link"
                       href="/VoyageVista/index.php">

                        Accueil

                    </a>

                </li>

                <!-- DESTINATIONS -->
                <li class="nav-item">

                    <a class="nav-link"
                       href="/VoyageVista/destinations.php">

                        Destinations

                    </a>

                </li>

                <!-- RESERVATIONS -->
                <?php if(isset($_SESSION["user_id"])): ?>

                    <li class="nav-item">

                        <a class="nav-link"
                           href="/VoyageVista/reservations/my-reservations.php">

                            Mes réservations

                        </a>

                    </li>

                <?php endif; ?>

                <!-- ADMIN -->
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

                <!-- LOGIN / LOGOUT -->
                <?php if(isset($_SESSION["user_id"])): ?>

                    <li class="nav-item d-flex align-items-center">

                        <span class="text-white me-3">

                            Bonjour
                            <?= $_SESSION["user_name"]; ?>

                        </span>

                        <a class="btn btn-danger"
                           href="/VoyageVista/auth/logout.php">

                            Déconnexion

                        </a>

                    </li>

                <?php else: ?>

                    <li class="nav-item">

                        <a class="btn btn-light"
                           href="/VoyageVista/login.php">

                            Se connecter

                        </a>

                    </li>

                <?php endif; ?>

            </ul>

        </div>

    </div>

</nav>