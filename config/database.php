<?php

$host = "localhost";
$dbname = "voyagevista";
$username = "root";
$password = "root";

try {

    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8",
        $username,
        $password
    );

    $pdo->setAttribute(
        PDO::ATTR_ERRMODE,
        PDO::ERRMODE_EXCEPTION
    );

} catch(PDOException $e) {

    die("Erreur connexion : " . $e->getMessage());

}
?>