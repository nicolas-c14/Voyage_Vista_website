<?php
session_start();
require_once __DIR__ . "/../models/cartModel.php";

/* =========================
   LOGIN CHECK
========================= */
if (!isset($_SESSION["user_id"])) {
    header("Location: ../login.php");
    exit;
}

$items = getCartItems($_SESSION["user_id"]);
$total = getCartTotal($_SESSION["user_id"]);

if (empty($items)) {
    header("Location: index.php");
    exit;
}

/* =========================
   TRAITEMENT PAIEMENT SIMULÉ
========================= */
$error = null;
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $cardNumber = preg_replace("/\s+/", "", $_POST["card_number"] ?? "");
    $cardName   = trim($_POST["card_name"] ?? "");
    $cardExpiry = trim($_POST["card_expiry"] ?? "");
    $cardCvc    = trim($_POST["card_cvc"] ?? "");

    if (!preg_match("/^\d{16}$/", $cardNumber)) {
        $error = "Le numéro de carte doit contenir 16 chiffres.";
    } elseif (empty($cardName)) {
        $error = "Veuillez renseigner le nom du titulaire.";
    } elseif (!preg_match("#^\d{2}/\d{2}$#", $cardExpiry)) {
        $error = "Date d'expiration au format MM/AA attendu.";
    } elseif (!preg_match("/^\d{3,4}$/", $cardCvc)) {
        $error = "Code CVC invalide (3 ou 4 chiffres).";
    } else {
        $ok = checkoutCart($_SESSION["user_id"]);
        if ($ok) {
            header("Location: success.php");
            exit;
        } else {
            $error = "Une erreur est survenue. Veuillez réessayer.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Paiement</title>
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

<div class="container py-5">
    <h1 class="mb-4">
        🔒 Paiement sécurisé
    </h1>

    <?php if ($error): ?>
        <div class="alert alert-danger">
            <?= htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>

    <div class="row">
        <!-- FORMULAIRE CB -->
        <div class="col-lg-7">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <h5 class="mb-3">Informations de paiement</h5>
                    <form method="POST" action="checkout.php">

                        <div class="mb-3">
                            <label class="form-label">
                                Numéro de carte
                            </label>
                            <input type="text"
                                   name="card_number"
                                   class="form-control"
                                   placeholder="4242 4242 4242 4242"
                                   maxlength="19"
                                   required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                Nom du titulaire
                            </label>
                            <input type="text"
                                   name="card_name"
                                   class="form-control"
                                   placeholder="JEAN DUPONT"
                                   required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">
                                    Date d'expiration
                                </label>
                                <input type="text"
                                       name="card_expiry"
                                       class="form-control"
                                       placeholder="MM/AA"
                                       maxlength="5"
                                       required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">
                                    CVC
                                </label>
                                <input type="text"
                                       name="card_cvc"
                                       class="form-control"
                                       placeholder="123"
                                       maxlength="4"
                                       required>
                            </div>
                        </div>

                        <button type="submit"
                                class="btn btn-primary w-100 btn-lg">
                            Payer
                            <?= number_format($total, 2, ",", " "); ?> €
                        </button>

                        <p class="text-center small text-muted mt-3">
                            Paiement 100% sécurisé
                        </p>
                    </form>
                </div>
            </div>
        </div>

        <!-- RÉCAP COMMANDE -->
        <div class="col-lg-5">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-3">
                        Votre commande
                    </h5>
                    <?php foreach ($items as $item): ?>
                        <div class="d-flex mb-3">
                            <img src="../assets/images/<?= htmlspecialchars($item["image"]); ?>"
                                 alt=""
                                 style="width:60px;height:60px;object-fit:cover;border-radius:6px;">
                            <div class="ms-3 flex-grow-1">
                                <strong><?= htmlspecialchars($item["accommodation_name"]); ?></strong>
                                <br>
                                <small class="text-muted">
                                    Du <?= date("d/m/Y", strtotime($item["check_in"])); ?>
                                    au <?= date("d/m/Y", strtotime($item["check_out"])); ?>
                                    ·
                                    <?= (int) $item["persons"]; ?> pers.
                                </small>
                            </div>
                            <div class="text-end">
                                <strong>
                                    <?= number_format($item["subtotal"], 2, ",", " "); ?> €
                                </strong>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <span class="h5">Total à payer</span>
                        <span class="h5 text-primary">
                            <?= number_format($total, 2, ",", " "); ?> €
                        </span>
                    </div>
                </div>
            </div>
            <div class="mt-2">
                <a href="index.php" class="btn btn-link btn-sm">
                    ← Modifier mon panier
                </a>
            </div>
        </div>
    </div>
</div>

<script src="../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>