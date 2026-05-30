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
   GET ID
========================= */

if (!isset($_GET["id"])) {

    die("Hébergement introuvable.");

}

$id = intval($_GET["id"]);

$accommodation =
    getAccommodationById($id);

if (!$accommodation) {

    die("Hébergement inexistant.");

}

/* =========================
   DESTINATIONS
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

    $image =
        $accommodation["image"];

    /* =========================
       NEW IMAGE
    ========================= */

    if (!empty($_FILES["image"]["name"])) {

        $image =
            time() . "_" .
            $_FILES["image"]["name"];

        move_uploaded_file(
            $_FILES["image"]["tmp_name"],
            __DIR__ .
            "/../assets/images/" .
            $image
        );

    }

    updateAccommodation(
        $id,
        $destinationId,
        $name,
        $type,
        $description,
        $price,
        $image
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
        Modifier hébergement
    </title>

    <link rel="stylesheet"
          href="../assets/css/bootstrap.min.css">

</head>

<body>

<div class="container py-5">

    <h1 class="mb-5">

        Modifier hébergement

    </h1>

    <form method="POST"
          enctype="multipart/form-data">

        <!-- DESTINATION -->
        <div class="mb-3">

            <label class="form-label">

                Destination

            </label>

            <select name="destination_id"
                    class="form-select">

                <?php foreach($destinations as $destination): ?>

                    <option value="<?= $destination["id"]; ?>"
                        <?= $destination["id"] ==
                            $accommodation["destination_id"]
                            ? "selected" : ""; ?>>

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
                   value="<?= $accommodation["name"]; ?>">

        </div>

        <!-- TYPE -->
        <div class="mb-3">

            <label class="form-label">

                Type

            </label>

            <input type="text"
                   name="type"
                   class="form-control"
                   value="<?= $accommodation["type"]; ?>">

        </div>

        <!-- DESCRIPTION -->
        <div class="mb-3">

            <label class="form-label">

                Description

            </label>

            <textarea name="description"
                      class="form-control"
                      rows="5"><?= $accommodation["description"]; ?></textarea>

        </div>

        <!-- PRICE -->
        <div class="mb-3">

            <label class="form-label">

                Prix

            </label>

            <input type="number"
                   step="0.01"
                   name="price"
                   class="form-control"
                   value="<?= $accommodation["price_per_night"]; ?>">

        </div>

        <!-- IMAGE -->
        <div class="mb-4">

            <label class="form-label">

                Nouvelle image

            </label>

            <input type="file"
                   name="image"
                   class="form-control">

        </div>

        <button type="submit"
                class="btn btn-primary">

            Sauvegarder

        </button>

    </form>

</div>

</body>

</html>
