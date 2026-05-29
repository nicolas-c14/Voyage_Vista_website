<?php

require_once __DIR__ . "/../config/database.php";

/* =========================
   GET BY DESTINATION
========================= */

function getAccommodationsByDestination(
    $destinationId
) {

    global $pdo;

    $stmt = $pdo->prepare(

        "SELECT *
         FROM accommodations
         WHERE destination_id = ?"

    );

    $stmt->execute([$destinationId]);

    return $stmt->fetchAll();

}

/* =========================
   GET ONE
========================= */

function getAccommodationById($id) {

    global $pdo;

    $stmt = $pdo->prepare(

        "SELECT *
         FROM accommodations
         WHERE id = ?"

    );

    $stmt->execute([$id]);

    return $stmt->fetch();

}

/* =========================
   GET ALL ACCOMMODATIONS
========================= */

function getAllAccommodations() {

    global $pdo;

    $stmt = $pdo->query(

        "SELECT *
         FROM accommodations
         ORDER BY id DESC"

    );

    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}

/* =========================
   ADD ACCOMMODATION
========================= */

function addAccommodation(
    $destinationId,
    $name,
    $type,
    $description,
    $price,
    $image
) {

    global $pdo;

    $stmt = $pdo->prepare(

        "INSERT INTO accommodations
        (
            destination_id,
            name,
            type,
            description,
            price_per_night,
            image
        )

        VALUES (?, ?, ?, ?, ?, ?)"

    );

    return $stmt->execute([
        $destinationId,
        $name,
        $type,
        $description,
        $price,
        $image
    ]);

}

/* =========================
   UPDATE ACCOMMODATION
========================= */

function updateAccommodation(
    $id,
    $destinationId,
    $name,
    $type,
    $description,
    $price,
    $image
) {

    global $pdo;

    $stmt = $pdo->prepare(

        "UPDATE accommodations

        SET
            destination_id = ?,
            name = ?,
            type = ?,
            description = ?,
            price_per_night = ?,
            image = ?

        WHERE id = ?"

    );

    return $stmt->execute([
        $destinationId,
        $name,
        $type,
        $description,
        $price,
        $image,
        $id
    ]);

}

/* =========================
   DELETE ACCOMMODATION
========================= */

function deleteAccommodation($id) {

    global $pdo;

    $stmt = $pdo->prepare(

        "DELETE FROM accommodations
         WHERE id = ?"

    );

    return $stmt->execute([$id]);

}
