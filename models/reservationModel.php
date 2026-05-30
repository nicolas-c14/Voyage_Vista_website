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
            total_price,
            status
        )

        VALUES (?, ?, ?, ?, ?, ?, ?)"
    );

    $success = $stmt->execute([
        $userId,
        $accommodationId,
        $checkIn,
        $checkOut,
        $persons,
        $totalPrice,
        "pending"
    ]);

    if(!$success){
        return false;
    }

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

            accommodations.image,

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
        ON reservations.accommodation_id =
        accommodations.id

        INNER JOIN destinations
        ON accommodations.destination_id =
        destinations.id

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

/* =========================
   CHECK AVAILABILITY
========================= */

function isAccommodationAvailable(
    $accommodationId,
    $checkIn,
    $checkOut,
    $excludeReservationId = null
) {

    global $pdo;

    $sql = "

        SELECT COUNT(*) as total

        FROM reservations

        WHERE accommodation_id = ?

        AND status != 'cancelled'

        AND (
            (check_in <= ? AND check_out >= ?)
        )

    ";

    /* =========================
       EXCLUDE CURRENT RESERVATION
    ========================= */

    if ($excludeReservationId !== null) {

        $sql .= " AND id != ?";

    }

    $stmt = $pdo->prepare($sql);

    /* =========================
       EXECUTE
    ========================= */

    if ($excludeReservationId !== null) {

        $stmt->execute([
            $accommodationId,
            $checkOut,
            $checkIn,
            $excludeReservationId
        ]);

    } else {

        $stmt->execute([
            $accommodationId,
            $checkOut,
            $checkIn
        ]);

    }

    $result = $stmt->fetch();

    return $result["total"] == 0;

}

/* =========================
   GET RESERVATION BY ID
========================= */

function getReservationById(
    $reservationId,
    $userId
) {

    global $pdo;

    $stmt = $pdo->prepare(

        "SELECT *

        FROM reservations

        WHERE id = ?
        AND user_id = ?"

    );

    $stmt->execute([
        $reservationId,
        $userId
    ]);

    return $stmt->fetch();

}

/* =========================
   UPDATE RESERVATION
========================= */

function updateReservation(
    $reservationId,
    $checkIn,
    $checkOut,
    $persons,
    $totalPrice
) {

    global $pdo;

    $stmt = $pdo->prepare(

        "UPDATE reservations

        SET
            check_in = ?,
            check_out = ?,
            persons = ?,
            total_price = ?

        WHERE id = ?"

    );

    return $stmt->execute([
        $checkIn,
        $checkOut,
        $persons,
        $totalPrice,
        $reservationId
    ]);

}

/* =========================
   GET ALL RESERVATIONS
========================= */

function getAllReservations() {

    global $pdo;

    $stmt = $pdo->query(

        "SELECT

            reservations.*,

            users.first_name,
            users.last_name,

            accommodations.name
            AS accommodation_name,

            destinations.name
            AS destination_name

        FROM reservations

        INNER JOIN users
        ON reservations.user_id = users.id

        INNER JOIN accommodations
        ON reservations.accommodation_id =
           accommodations.id

        INNER JOIN destinations
        ON accommodations.destination_id =
           destinations.id

        ORDER BY reservations.created_at DESC"

    );

    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}

/* =========================
   UPDATE STATUS
========================= */

function updateReservationStatus(
    $reservationId,
    $status
) {

    global $pdo;

    $stmt = $pdo->prepare(

        "UPDATE reservations

         SET status = ?

         WHERE id = ?"

    );

    return $stmt->execute([
        $status,
        $reservationId
    ]);

}

/* =========================
   GET RESERVATION AGENCY
========================= */

function getReservationByIdAgency(
    $reservationId
) {

    global $pdo;

    $stmt = $pdo->prepare(

        "SELECT

            reservations.*,

            accommodations.name
            AS accommodation_name

        FROM reservations

        INNER JOIN accommodations

        ON reservations.accommodation_id =
           accommodations.id

        WHERE reservations.id = ?"

    );

    $stmt->execute([
        $reservationId
    ]);

    return $stmt->fetch(PDO::FETCH_ASSOC);

}

?>