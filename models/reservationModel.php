<?php

require_once __DIR__ . "/../config/database.php";

/* =========================
   ADD RESERVATION
========================= */

function addReservation(
    $userId,
    $accommodationId,
    $checkIn,
    $checkOut,
    $persons,
    $totalPrice
) {

    global $pdo;

    $stmt = $pdo->prepare(

        "INSERT INTO reservations
        (
            user_id,
            accommodation_id,
            check_in,
            check_out,
            persons,
            total_price
        )

        VALUES (?, ?, ?, ?, ?, ?)"
    );
    
    $stmt->execute([
        $userId,
        $accommodationId,
        $checkIn,
        $checkOut,
        $persons,
        $totalPrice
    ]);

return $pdo->lastInsertId();
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

            destinations.name
            AS destination_name,

            destinations.country,

            transports.type
            AS transport_type,

            transports.departure_city,

            transports.arrival_city

        FROM reservations

        LEFT JOIN transports
        ON reservations.transport_id = transports.id

        INNER JOIN accommodations
        ON reservations.accommodation_id = accommodations.id

        INNER JOIN destinations
        ON accommodations.destination_id = destinations.id

        WHERE reservations.user_id = ?

        ORDER BY reservations.created_at DESC"

    );

    $stmt->execute([$userId]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);

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