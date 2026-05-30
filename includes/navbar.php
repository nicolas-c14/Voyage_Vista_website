<?php 
require_once __DIR__ . '/../config/app.php';
require_once __DIR__ . '/../models/cartModel.php';
require_once __DIR__ . "/../models/notificationModel.php"; 
$notificationCount = 0;

if(isset($_SESSION["user_id"])) {

    $notificationCount =
        countUnreadNotifications(
            $_SESSION["user_id"]
        );

}

$cartCount = 0;
if (isset($_SESSION["user_id"])) {
    $cartCount = getCartCount($_SESSION["user_id"]);
}
?>
<nav class="navbar navbar-expand-lg navbar-dark custom-navbar">
    <div class="container">
        <!-- LOGO -->
        <img src="<?= APP_URL ?>/assets/images/VoyageVistaLogo.png"
             width="40"
             class="me-2">
        <a class="navbar-brand fw-bold"
           href="<?= APP_URL ?>/index.php">
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
                       href="<?= APP_URL ?>/index.php">
                        Accueil
                    </a>
                </li>
                <!-- DESTINATIONS -->
                <li class="nav-item">
                    <a class="nav-link"
                       href="<?= APP_URL ?>/destinations.php">
                        Destinations
                    </a>
                </li>
                <!-- RESERVATIONS -->
                <?php if(isset($_SESSION["user_id"])): ?>
                    <li class="nav-item">
                        <a class="nav-link"
                           href="<?= APP_URL ?>/reservations/my-reservations.php">
                            Mes réservations
                        </a>
                    </li>
                <?php endif; ?>
                <!-- PANIER -->
                <?php if(isset($_SESSION["user_id"])): ?>
                    <li class="nav-item">
                        <a class="nav-link position-relative"
                           href="<?= APP_URL ?>/cart/index.php">
                            Panier
                            <?php if ($cartCount > 0): ?>
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    <?= $cartCount; ?>
                                </span>
                            <?php endif; ?>
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
                           href="<?= APP_URL ?>/admin/dashboard.php">
                            Admin
                        </a>
                    </li>
                <?php endif; ?>

<!-- AGENCY -->
                <?php if(
                    isset($_SESSION["user_role"]) &&
                    $_SESSION["user_role"] === "agency"
                ): ?>
                    <li class="nav-item">
                        <a class="nav-link"
                           href="<?= APP_URL ?>/agency/dashboard.php">
                            Agency
                        </a>
                    </li>
                <?php endif; ?>
                <!-- LOGIN / LOGOUT -->
                <?php if(isset($_SESSION["user_id"])): ?>
                    <li class="nav-item d-flex align-items-center">
                        <span class="text-white me-3">

                            <a href="/VoyageVista/profile/dashboard.php"
                            class="text-white text-decoration-none me-3">

                                Bonjour
                                <?= $_SESSION["user_name"]; ?>

                            </a>

                        </span>
                        <a class="btn btn-danger"
                           href="<?= APP_URL ?>/auth/logout.php">
                            Déconnexion
                        </a>

                        <a class="nav-link"
                        href="/VoyageVista/notifications/index.php">

                            Notifications

                            <?php if($notificationCount > 0): ?>

                                <span class="badge bg-danger">

                                    <?= $notificationCount; ?>

                                </span>

                            <?php endif; ?>

                        </a>

                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="btn btn-light"
                           href="<?= APP_URL ?>/login.php">
                            Se connecter
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>