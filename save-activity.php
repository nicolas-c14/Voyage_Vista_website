<?php

session_start();

require_once __DIR__ . '/config/database.php';

$reservationId =
    intval($_GET["reservation_id"]);

$activityId =
    intval($_GET["activity_id"]);

$sql = "
INSERT INTO reservation_activities
(reservation_id, activity_id)

VALUES (?, ?)
";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    $reservationId,
    $activityId
]);

header(
    "Location: choose-activity.php?reservation_id=" . $reservationId
);

exit;