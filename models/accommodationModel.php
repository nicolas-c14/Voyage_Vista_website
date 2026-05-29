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