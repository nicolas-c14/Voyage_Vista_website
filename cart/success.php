<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: ../login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Paiement réussi</title>
    <link rel="icon"
          href="../assets/images/VoyageVistaLogo.png"
          type="image/png">
    <link rel="stylesheet"
          href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet"
          href="../assets/css/style.css">
</head>
<body>

<?php include __DIR__ . "/../includes/navbar.php"; ?>

<div class="container py-5 text-center">
    <div class="card shadow-sm mx-auto"
         style="max-width: 600px;">
        <div class="card-body p-5">
            <div style="font-size: 80px;">✅</div>
            <h1 class="mt-3">
                Paiement confirmé !
            </h1>
            <p class="lead text-muted mt-3">
                Vos réservations ont bien été enregistrées.
                Vous recevrez prochainement un récapitulatif
                de votre voyage par email.
            </p>
            <div class="mt-4">
                <a href="../reservations/my-reservations.php"
                   class="btn btn-primary">
                    Voir mes réservations
                </a>
                <a href="../destinations.php"
                   class="btn btn-outline-secondary ms-2">
                    Découvrir d'autres destinations
                </a>
            </div>
        </div>
    </div>
</div>

</body>
</html>