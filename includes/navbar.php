<?php
require_once __DIR__ . '/session.php';
require_once __DIR__ . '/security_headers.php';

// A FAIRE: centraliser le chargement du compteur notifications via endpoint/API cache pour eviter une requete SQL par page.

$unreadNotifications = 0;
if (!empty($_SESSION['user_id'])) {
    require_once __DIR__ . '/../config/database.php';
    try {
        $db = get_database_connection();
        $stmt = $db->prepare('SELECT COUNT(*) AS unread_count FROM notifications WHERE user_id = ? AND is_read = 0');
        $stmt->execute([(int)$_SESSION['user_id']]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $unreadNotifications = (int)($row['unread_count'] ?? 0);
    } catch (Throwable $e) {
        // Keep navbar working even if notifications are unavailable.
        $unreadNotifications = 0;
    }
}
?>

<nav class="navbar navbar-expand-lg navbar-dark custom-navbar">
        <div class="container">

            <a class="navbar-brand fw-bold" href="index.php">
                <img src="assets/images/VoyageVistaLogo.png" alt="VoyageVista logo" class="brand-logo-img">
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

                    <?php if (!empty($_SESSION['user_id'])): ?>
                    <?php // A FAIRE: afficher des liens contextuels selon le role (admin/agency/client). ?>
                    <li class="nav-item ms-lg-3">
                        <a class="nav-link position-relative" href="notifications.php">
                            Notifications
                            <?php if ($unreadNotifications > 0): ?>
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    <?php echo (int)$unreadNotifications; ?>
                                </span>
                            <?php endif; ?>
                        </a>
                    </li>
                    <li class="nav-item dropdown ms-lg-3">
                        <a class="nav-link dropdown-toggle text-white" href="#" id="userMenu" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <?php echo htmlspecialchars($_SESSION['user_name'] ?? ($_SESSION['user_email'] ?? 'Utilisateur'), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenu">
                            <li><a class="dropdown-item" href="profile.php">Mon profil</a></li>
                            <li><a class="dropdown-item" href="auth/logout.php">Se déconnecter</a></li>
                        </ul>
                    </li>
                    <?php else: ?>
                    <li class="nav-item ms-lg-3">
                        <a class="btn btn-light" href="login.php">
                            Se connecter
                        </a>
                    </li>
                    <?php endif; ?>

                </ul>

            </div>

        </div>
    </nav>