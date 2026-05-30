<?php

require_once __DIR__ . '/../config/database.php';

function getTransportsByDestination($destinationId)
{
    global $pdo;

    $sql = "SELECT * FROM transports
            WHERE destination_id = ?";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([$destinationId]);

    return $stmt->fetchAll();
}

function bookTransport($transportId)
{
    global $pdo;

    $sql = "UPDATE transports
            SET available_seats = available_seats - 1
            WHERE id = ?
            AND available_seats > 0";

    $stmt = $pdo->prepare($sql);

    return $stmt->execute([$transportId]);
}

function cancelTransport($transportId)
{
    global $pdo;

    $sql = "UPDATE transports
            SET available_seats = available_seats + 1
            WHERE id = ?";

    $stmt = $pdo->prepare($sql);

    return $stmt->execute([$transportId]);
}