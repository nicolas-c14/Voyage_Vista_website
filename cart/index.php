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
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mon panier</title>
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
        🛒 Mon panier
    </h1>

    <?php if (isset($_GET["added"])): ?>
        <div class="alert alert-success">
            Hébergement ajouté au panier !
        </div>
    <?php endif; ?>
    <?php if (isset($_GET["removed"])): ?>
        <div class="alert alert-info">
            Élément supprimé du panier.
        </div>
    <?php endif; ?>
    <?php if (isset($_GET["updated"])): ?>
        <div class="alert alert-info">
            Panier mis à jour.
        </div>
    <?php endif; ?>

    <?php if (empty($items)): ?>
        <div class="alert alert-warning">
            Votre panier est vide.
            <a href="../destinations.php" class="alert-link">
                Découvrir les destinations
            </a>
        </div>
    <?php else: ?>

        <div class="row">
            <!-- LISTE DES ITEMS -->
            <div class="col-lg-8">
                <?php foreach ($items as $item): ?>
                    <div class="card mb-3 shadow-sm">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <img src="../assets/images/<?= htmlspecialchars($item["image"]); ?>"
                                     alt="<?= htmlspecialchars($item["accommodation_name"]); ?>"
                                     class="img-fluid rounded-start"
                                     style="height: 100%; object-fit: cover;">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <?= htmlspecialchars($item["accommodation_name"]); ?>
                                    </h5>
                                    <p class="text-muted small mb-2">
                                        <?= htmlspecialchars($item["type"]); ?>
                                        ·
                                        <?= htmlspecialchars($item["destination_name"]); ?>,
                                        <?= htmlspecialchars($item["country"]); ?>
                                    </p>

                                    <!-- FORM MODIFIER -->
                                    <form method="POST"
                                          action="update.php"
                                          class="row g-2 mb-3">
                                        <input type="hidden"
                                               name="item_id"
                                               value="<?= $item["id"]; ?>">

                                        <div class="col-md-4">
                                            <label class="form-label small">
                                                Arrivée
                                            </label>
                                            <input type="date"
                                                   name="check_in"
                                                   value="<?= htmlspecialchars($item["check_in"]); ?>"
                                                   class="form-control form-control-sm"
                                                   required>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label small">
                                                Départ
                                            </label>
                                            <input type="date"
                                                   name="check_out"
                                                   value="<?= htmlspecialchars($item["check_out"]); ?>"
                                                   class="form-control form-control-sm"
                                                   required>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="form-label small">
                                                Personnes
                                            </label>
                                            <input type="number"
                                                   name="persons"
                                                   min="1"
                                                   value="<?= (int) $item["persons"]; ?>"
                                                   class="form-control form-control-sm"
                                                   required>
                                        </div>
                                        <div class="col-md-2 d-flex align-items-end">
                                            <button type="submit"
                                                    class="btn btn-sm btn-outline-primary w-100">
                                                Modifier
                                            </button>
                                        </div>
                                    </form>

                                    <!-- INFOS PRIX + SUPPRIMER -->
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <span class="text-muted small">
                                                <?= number_format($item["price_per_night"], 2, ",", " "); ?> €
                                                / nuit ×
                                                <?= (int) $item["nights"]; ?> nuits ×
                                                <?= (int) $item["persons"]; ?> pers.
                                            </span>
                                            <br>
                                            <strong class="text-primary fs-5">
                                                <?= number_format($item["subtotal"], 2, ",", " "); ?> €
                                            </strong>
                                        </div>
                                        <!-- BOUTON QUI OUVRE LE MODAL -->
                                        <button type="button"
                                                class="btn btn-sm btn-outline-danger"
                                                data-bs-toggle="modal"
                                                data-bs-target="#deleteModal"
                                                data-item-id="<?= $item["id"]; ?>"
                                                data-item-name="<?= htmlspecialchars($item["accommodation_name"]); ?>">
                                            🗑 Supprimer
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- RÉCAP -->
            <div class="col-lg-4">
                <div class="card shadow-sm sticky-top"
                     style="top: 90px;">
                    <div class="card-body">
                        <h5 class="card-title mb-3">
                            Récapitulatif
                        </h5>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Nombre d'articles</span>
                            <strong><?= count($items); ?></strong>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="h5">Total</span>
                            <span class="h5 text-primary">
                                <?= number_format($total, 2, ",", " "); ?> €
                            </span>
                        </div>
                        <a href="checkout.php"
                           class="btn btn-primary w-100">
                            Passer au paiement →
                        </a>
                        <a href="../destinations.php"
                           class="btn btn-link w-100 mt-2">
                            ← Continuer mes recherches
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- =========================
             MODAL BOOTSTRAP : confirmation suppression
             ========================= -->
        <div class="modal fade"
             id="deleteModal"
             tabindex="-1"
             aria-labelledby="deleteModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"
                            id="deleteModalLabel">
                            Confirmer la suppression
                        </h5>
                        <button type="button"
                                class="btn-close"
                                data-bs-dismiss="modal"
                                aria-label="Fermer"></button>
                    </div>
                    <div class="modal-body">
                        Êtes-vous sûr de vouloir retirer
                        <strong id="modalItemName"></strong>
                        de votre panier ?
                    </div>
                    <div class="modal-footer">
                        <button type="button"
                                class="btn btn-secondary"
                                data-bs-dismiss="modal">
                            Annuler
                        </button>
                        <form method="POST"
                              action="remove.php"
                              class="d-inline">
                            <input type="hidden"
                                   name="item_id"
                                   id="modalItemId">
                            <button type="submit"
                                    class="btn btn-danger">
                                Oui, supprimer
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    <?php endif; ?>
</div>

<!-- BOOTSTRAP JS + script du modal -->
<script src="../assets/js/bootstrap.bundle.min.js"></script>
<script>
    const deleteModal = document.getElementById("deleteModal");
    if (deleteModal) {
        deleteModal.addEventListener("show.bs.modal", function (event) {
            const button   = event.relatedTarget;
            const itemId   = button.getAttribute("data-item-id");
            const itemName = button.getAttribute("data-item-name");
            document.getElementById("modalItemId").value = itemId;
            document.getElementById("modalItemName").textContent = itemName;
        });
    }
</script>

</body>
</html>