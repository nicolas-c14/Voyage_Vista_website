<?php

session_start();

require_once "../config/database.php";

/* =========================
   CHECK REQUEST
========================= */

if ($_SERVER["REQUEST_METHOD"] !== "POST") {

    die("Accès interdit.");

}

/* =========================
   GET DATA
========================= */

$email = trim($_POST["email"]);
$password = trim($_POST["password"]);

/* =========================
   VALIDATION
========================= */

if (
    empty($email) ||
    empty($password)
) {

    die("Tous les champs sont obligatoires.");

}

/* =========================
   GET USER
========================= */

$stmt = $pdo->prepare(

    "SELECT * FROM users
     WHERE email = ?"

);

$stmt->execute([$email]);

$user = $stmt->fetch();

/* =========================
   USER CHECK
========================= */

if (!$user) {

    die("Utilisateur introuvable.");

}

/* =========================
   PASSWORD VERIFY
========================= */

if (!password_verify(
    $password,
    $user["password"]
)) {

    die("Mot de passe incorrect.");

}

/* =========================
   CREATE SESSION
========================= */

$_SESSION["user_id"] =
    $user["id"];

$_SESSION["user_name"] =
    $user["first_name"];

$_SESSION["user_role"] =
    $user["role"];

/* =========================
   REDIRECT
========================= */

header("Location: ../index.php");

exit;