<?php
require_once __DIR__ . '/../includes/auth_middleware.php';
require_role(['agency', 'admin'], '../index.php');
require_once __DIR__ . '/../includes/security_headers.php';
require_once __DIR__ . '/../includes/csrf.php';

// A FAIRE: afficher ici la liste des destinations du prestataire avec actions edit/delete.
// A FAIRE: ajouter workflow de moderation admin (statut en attente/valide/refuse).
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Provider Dashboard - VoyageVista</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="login-body">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm p-4">
                    <h1 class="h4 mb-3">Provider Dashboard</h1>
                    <p class="text-muted">Create a destination using the existing API and Europe validation.</p>
                    <!-- A FAIRE: remplacer le champ pays texte par un select ISO Europe charge depuis la table countries. -->

                    <form action="../api/destination_create.php" method="POST">
                        <?php echo csrf_input_field(); ?>

                        <div class="mb-3">
                            <label for="name" class="form-label">Destination name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>

                        <div class="mb-3">
                            <label for="country" class="form-label">Country ISO code</label>
                            <input type="text" class="form-control" id="country" name="country" maxlength="2" placeholder="FR" required>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="4"></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Image path</label>
                            <input type="text" class="form-control" id="image" name="image" placeholder="assets/images/paris.jpg">
                        </div>

                        <button type="submit" class="btn btn-primary">Create destination</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
