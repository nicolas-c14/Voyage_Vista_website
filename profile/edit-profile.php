<?php

session_start();

require_once __DIR__ . "/../models/userModel.php";

/* =========================
   LOGIN CHECK
========================= */

if(!isset($_SESSION["user_id"])) {

    header("Location: ../login.php");
    exit;

}

/* =========================
   USER
========================= */

$user =
    getUserById(
        $_SESSION["user_id"]
    );

/* =========================
   UPDATE
========================= */

if($_SERVER["REQUEST_METHOD"] === "POST") {

    $firstName =
        trim($_POST["first_name"]);

    $lastName =
        trim($_POST["last_name"]);

    $email =
        trim($_POST["email"]);

    updateUserProfile(

        $_SESSION["user_id"],
        $firstName,
        $lastName,
        $email

    );

    $_SESSION["user_name"] =
        $firstName;

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
        Modifier profil
    </title>

    <link rel="stylesheet"href="../assets/css/bootstrap.min.css">

    <link rel="stylesheet"href="../assets/css/style.css">

</head>

<body>

    <?php include __DIR__ . '/../includes/navbar.php'; ?>

    <div class="container py-5">

        <h1 class="mb-5">
            Modifier mon profil
        </h1>

        <form method="POST">

            <div class="mb-3">

                <label class="form-label">
                    Prénom
                </label>

                <input type="text"
                    name="first_name"
                    class="form-control"
                    value="<?= htmlspecialchars($user["first_name"]); ?>"
                required>

            </div>

            <div class="mb-3">

                <label class="form-label">
                    Nom
                </label>

                <input type="text"
                    name="last_name"
                    class="form-control"
                    value="<?= htmlspecialchars($user["last_name"]); ?>"
                required>

            </div>

            <div class="mb-4">

                <label class="form-label">
                    Email
                </label>

                <input type="email"
                    name="email"
                    class="form-control"
                    value="<?= htmlspecialchars($user["email"]); ?>"
                required>

            </div>

            <button type="submit"
                    class="btn btn-primary">

                Sauvegarder

            </button>

        </form>

    </div>

</body>
</html>