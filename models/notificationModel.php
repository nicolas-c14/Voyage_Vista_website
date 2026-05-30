<?php

require_once __DIR__ . "/../config/database.php";

/* =========================
   CREATE NOTIFICATION
========================= */

function createNotification(
    $userId,
    $title,
    $message
) {

    global $pdo;

    $stmt = $pdo->prepare(

        "INSERT INTO notifications
        (
            user_id,
            title,
            message
        )
        VALUES (?, ?, ?)"

    );

    return $stmt->execute([
        $userId,
        $title,
        $message
    ]);

}

/* =========================
   GET USER NOTIFICATIONS
========================= */

function getNotificationsByUser(
    $userId
) {

    global $pdo;

    $stmt = $pdo->prepare(

        "SELECT *

        FROM notifications

        WHERE user_id = ?

        ORDER BY created_at DESC"

    );

    $stmt->execute([
        $userId
    ]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}

/* =========================
   COUNT UNREAD
========================= */

function countUnreadNotifications(
    $userId
) {

    global $pdo;

    $stmt = $pdo->prepare(

        "SELECT COUNT(*) AS total

        FROM notifications

        WHERE user_id = ?
        AND is_read = 0"

    );

    $stmt->execute([
        $userId
    ]);

    return $stmt->fetch()["total"];

}

/* =========================
   MARK AS READ
========================= */

function markNotificationsAsRead(
    $userId
) {

    global $pdo;

    $stmt = $pdo->prepare(

        "UPDATE notifications

        SET is_read = 1

        WHERE user_id = ?"

    );

    return $stmt->execute([
        $userId
    ]);

}