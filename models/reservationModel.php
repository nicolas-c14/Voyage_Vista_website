<?php

require_once __DIR__ . "/../config/database.php";

/* =========================
   ADD RESERVATION
========================= */

function addReservation(
    $userId,
    $accommodationId,
    $travelDate,
    $persons
) {

    global $pdo;

    $stmt = $pdo->prepare(

        "INSERT INTO reservations
        (
            user_id,
            accommodation_id,
            travel_date,
            persons
        )

        VALUES (?, ?, ?, ?)"

    );

    return $stmt->execute([
        $userId,
        $accommodationId,
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

            accommodations.name
            AS accommodation_name,

            accommodations.image,

            destinations.name
            AS destination_name,

            destinations.country

        FROM reservations

        INNER JOIN accommodations

        ON reservations.accommodation_id =
        accommodations.id

        INNER JOIN destinations

        ON accommodations.destination_id =
        destinations.id

        WHERE reservations.user_id = ?

        ORDER BY reservations.created_at DESC"

    );

    $stmt->execute([$userId]);

    return $stmt->fetchAll();

}

/* =========================
   DELETE RESERVATION
========================= */

function deleteReservation($reservationId, $userId) {

    global $pdo;

    $stmt = $pdo->prepare(

        "DELETE FROM reservations
         WHERE id = ? AND user_id = ?"

    );

    return $stmt->execute([
        $reservationId,
        $userId
    ]);

}

?>