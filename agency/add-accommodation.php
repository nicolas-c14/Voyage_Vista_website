<?php

session_start();

require_once __DIR__ . "/../models/accommodationModel.php";
require_once __DIR__ . "/../models/destinationModel.php";

/* =========================
   SECURITY
========================= */

if (
    !isset($_SESSION["user_role"]) ||
    $_SESSION["user_role"] !== "agency"
) {

    die("Accès interdit.");

}

/* =========================
   GET DESTINATIONS
========================= */

$destinations =
    getAllDestinations();

/* =========================
   SUBMIT
========================= */

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $destinationId =
        intval($_POST["destination_id"]);

    $name =
        trim($_POST["name"]);

    $type =
        trim($_POST["type"]);

    $description =
        trim($_POST["description"]);

    $price =
        floatval($_POST["price"]);

    /* =========================
       IMAGE UPLOAD
    ========================= */

    $imageName =
        time() . "_" .
        $_FILES["image"]["name"];

    $tmpName =
        $_FILES["image"]["tmp_name"];

    move_uploaded_file(
        $tmpName,
        __DIR__ .
        "/../assets/images/" .
        $imageName
    );

    /* =========================
       INSERT SQL
    ========================= */

    addAccommodation(
        $destinationId,
        $name,
        $type,
        $description,
        $price,
        $imageName
    );

    header(
        "Location: dashboard.php"
    );

    exit;

}

?>

<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">

    <title>
        Ajouter un hébergement
    </title>

    <link rel="stylesheet"
          href="../assets/css/bootstrap.min.css">

    <link rel="stylesheet"
          href="../assets/css/style.css">

</head>

<body>

<?php include __DIR__ . '/../includes/navbar.php'; ?>

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-lg-8">

            <div class="card shadow-lg border-0">

                <div class="card-body p-5">

                    <h1 class="mb-5 text-center">

                        Ajouter un hébergement

                    </h1>

                    <form method="POST"
                          enctype="multipart/form-data">

                        <!-- DESTINATION -->
                        <div class="mb-3">

                            <label class="form-label">

                                Destination

                            </label>

                            <select name="destination_id"
                                    class="form-select"
                                    required>

                                <?php foreach($destinations as $destination): ?>

                                    <option value="<?= $destination["id"]; ?>">

                                        <?= $destination["name"]; ?>

                                    </option>

                                <?php endforeach; ?>

                            </select>

                        </div>

                        <!-- NAME -->
                        <div class="mb-3">

                            <label class="form-label">

                                Nom

                            </label>

                            <input type="text"
                                   name="name"
                                   class="form-control"
                                   required>

                        </div>

                        <!-- TYPE -->
                        <div class="mb-3">

                            <label class="form-label">

                                Type

                            </label>

                            <input type="text"
                                   name="type"
                                   class="form-control"
                                   placeholder="Hôtel, Villa, Appartement..."
                                   required>

                        </div>

                        <!-- DESCRIPTION -->
                        <div class="mb-3">

                            <label class="form-label">

                                Description

                            </label>

                            <textarea name="description"
                                      class="form-control"
                                      rows="5"
                                      required></textarea>

                        </div>

                        <!-- PRICE -->
                        <div class="mb-3">

                            <label class="form-label">

                                Prix / nuit

                            </label>

                            <input type="number"
                                   step="0.01"
                                   name="price"
                                   class="form-control"
                                   required>

                        </div>

                        <!-- IMAGE -->
                        <div class="mb-4">

                            <label class="form-label">

                                Image

                            </label>

                            <input type="file"
                                   name="image"
                                   class="form-control"
                                   accept="image/*"
                                   required>

                        </div>

                        <!-- BUTTON -->
                        <button type="submit"
                                class="btn btn-primary w-100">

                            Ajouter l'hébergement

                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

</body>

</html>
