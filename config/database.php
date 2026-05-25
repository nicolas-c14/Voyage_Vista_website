<?php

// Database configuration - consider moving credentials to environment variables in production
$host = "localhost";
$dbname = "voyagevista";
$username = getenv('DB_USER') ?: "root";
$password = getenv('DB_PASS') ?: "root";

$pdo = null;
try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch (PDOException $e) {
    // Log detailed error and show a generic message to users
    error_log('Database connection error: ' . $e->getMessage());
    http_response_code(500);
    echo 'Erreur de connexion au serveur.';
    exit;
}

function get_database_connection()
{
    global $pdo;
    return $pdo;
}
?>