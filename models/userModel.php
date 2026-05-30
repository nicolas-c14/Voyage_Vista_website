<?php

require_once __DIR__ . "/../config/database.php";

/* =========================
   GET USER BY ID
========================= */

function getUserById($id) {

    global $pdo;

    $stmt = $pdo->prepare(

        "SELECT *

         FROM users

         WHERE id = ?"

    );

    $stmt->execute([$id]);

    return $stmt->fetch(PDO::FETCH_ASSOC);

}

/* =========================
   UPDATE PROFILE
========================= */

function updateUserProfile(
    $id,
    $firstName,
    $lastName,
    $email
) {

    global $pdo;

    $stmt = $pdo->prepare(

        "UPDATE users

         SET
            first_name = ?,
            last_name = ?,
            email = ?

         WHERE id = ?"

    );

    return $stmt->execute([
        $firstName,
        $lastName,
        $email,
        $id
    ]);

}