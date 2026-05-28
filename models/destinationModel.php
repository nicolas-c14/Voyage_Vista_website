<?php

require_once __DIR__ . "/../config/database.php";

/* =========================
   GET ALL DESTINATIONS
========================= */

function getAllDestinations() {

    global $pdo;

    $stmt = $pdo->prepare(

        "SELECT * FROM destinations
         ORDER BY created_at DESC"

    );

    $stmt->execute();

    return $stmt->fetchAll();

};

/* =========================
   GET ONE DESTINATION
========================= */

function getDestinationById($id) {

    global $pdo;

    $stmt = $pdo->prepare(

        "SELECT * FROM destinations
         WHERE id = ?"

    );

    $stmt->execute([$id]);

    return $stmt->fetch();

};

/* =========================
   GET RANDOM DESTINATIONS
========================= */

function getRandomDestinations() {

    global $pdo;

    $stmt = $pdo->prepare(
        "SELECT *
         FROM destinations
         ORDER BY RAND()
         LIMIT 3"
    );

    $stmt->execute();

    return $stmt->fetchAll();
}

/* =========================
   ADD DESTINATION
========================= */

function addDestination(
    $name,
    $country,
    $description,
    $image,
    $price
) {

    global $pdo;

    $stmt = $pdo->prepare(

        "INSERT INTO destinations
        (
            name,
            country,
            description,
            image,
            price
        )

        VALUES (?, ?, ?, ?, ?)"

    );

    return $stmt->execute([
        $name,
        $country,
        $description,
        $image,
        $price
    ]);

}

/* =========================
   UPDATE DESTINATION
========================= */

function updateDestination(
    $id,
    $name,
    $country,
    $description,
    $image,
    $price
) {

    global $pdo;

    $stmt = $pdo->prepare(

        "UPDATE destinations

        SET
            name = ?,
            country = ?,
            description = ?,
            image = ?,
            price = ?

        WHERE id = ?"

    );

    return $stmt->execute([
        $name,
        $country,
        $description,
        $image,
        $price,
        $id
    ]);

}

/* =========================
   DELETE DESTINATION
========================= */

function deleteDestination($id) {

    global $pdo;

    $stmt = $pdo->prepare(

        "DELETE FROM destinations
         WHERE id = ?"

    );

    return $stmt->execute([$id]);

}

?>