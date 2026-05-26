<?php

require_once "../config/database.php";

/* =========================
   ADD RESERVATION
========================= */

function addReservation(
    $userId,
    $destinationId,
    $travelDate,
    $persons
) {

    global $pdo;

    $stmt = $pdo->prepare(

        "INSERT INTO reservations
        (
            user_id,
            destination_id,
            travel_date,
            persons
        )

        VALUES (?, ?, ?, ?)"

    );

    return $stmt->execute([
        $userId,
        $destinationId,
        $travelDate,
        $persons
    ]);

}

/* =========================
   GET USER RESERVATIONS
========================= */

function getReservationsByUser($userId) {

    global $pdo;

    $stmt = $pdo->prepare(

        "SELECT
            reservations.*,
            destinations.name,
            destinations.country,
            destinations.image

        FROM reservations

        INNER JOIN destinations

        ON reservations.destination_id =
           destinations.id

        WHERE user_id = ?

        ORDER BY created_at DESC"

    );

    $stmt->execute([$userId]);

    return $stmt->fetchAll();

}