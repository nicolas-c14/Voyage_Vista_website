<?php

session_start();

require_once __DIR__ . "/../models/notificationModel.php";

if(!isset($_SESSION["user_id"])) {

    header("Location: ../login.php");
    exit;

}

$notifications =
    getNotificationsByUser(
        $_SESSION["user_id"]
    );

markNotificationsAsRead(
    $_SESSION["user_id"]
);

?>

<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">

    <title>
        Notifications
    </title>

    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">

    <link rel="stylesheet" href="../assets/css/style.css">

</head>

<body>

    <?php include __DIR__ . '/../includes/navbar.php'; ?>

    <div class="container py-5">

        <h1 class="mb-5">
            Mes notifications
        </h1>

        <?php foreach($notifications as $notification): ?>

            <div class="alert alert-light border">

                <h5>

                    <?= $notification["title"]; ?>

                </h5>

                <p class="mb-1">

                    <?= $notification["message"]; ?>

                </p>

                <small>

                    <?= $notification["created_at"]; ?>

                </small>

            </div>

        <?php endforeach; ?>

    </div>

</body>

</html>