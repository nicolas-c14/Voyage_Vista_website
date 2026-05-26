<?php

session_start();

require_once "../config/database.php";

/* =========================
   CHECK FORM
========================= */

if ($_SERVER["REQUEST_METHOD"] !== "POST") {

    die("Accès interdit.");

}

/* =========================
   GET DATA
========================= */

$firstName = trim($_POST["firstName"]);
$lastName = trim($_POST["lastName"]);
$email = trim($_POST["email"]);
$password = trim($_POST["password"]);

/* =========================
   VALIDATION
========================= */

if (
    empty($firstName) ||
    empty($lastName) ||
    empty($email) ||
    empty($password)
) {

    die("Tous les champs sont obligatoires.");

}

/* =========================
   EMAIL CHECK
========================= */

$stmt = $pdo->prepare(
    "SELECT id FROM users WHERE email = ?"
);

$stmt->execute([$email]);

$user = $stmt->fetch();

if ($user) {

    die("Cet email existe déjà.");

}

/* =========================
   PASSWORD HASH
========================= */

$hashedPassword = password_hash(
    $password,
    PASSWORD_DEFAULT
);

/* =========================
   INSERT USER
========================= */

$stmt = $pdo->prepare(

    "INSERT INTO users
    (first_name, last_name, email, password)
    VALUES (?, ?, ?, ?)"

);

$stmt->execute([
    $firstName,
    $lastName,
    $email,
    $hashedPassword
]);

/* =========================
   REDIRECT
========================= */

header("Location: ../login.php");
exit;