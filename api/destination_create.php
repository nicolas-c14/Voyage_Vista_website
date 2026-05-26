<?php
require_once __DIR__ . '/../includes/csrf.php';
require_once __DIR__ . '/../config/database.php';

header('Content-Type: application/json; charset=utf-8');

// A FAIRE: restreindre cet endpoint aux roles `agency` et `admin` via le middleware.
// A FAIRE: gerer l'upload image (multipart) au lieu d'un chemin texte libre.

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

$token = $_POST['csrf_token'] ?? '';
if (!csrf_validate($token)) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid CSRF token']);
    exit;
}

$name = trim($_POST['name'] ?? '');
$country = strtoupper(trim($_POST['country'] ?? ''));
$description = trim($_POST['description'] ?? '');
$image = trim($_POST['image'] ?? '');

if (empty($name) || empty($country)) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing fields']);
    exit;
}

// A FAIRE: ajouter des validations metier supplementaires (longueur nom/description, caracteres autorises).

try {
    $db = get_database_connection();

    // Validate country is allowed (exists in countries table)
    $stmt = $db->prepare('SELECT iso_code FROM countries WHERE iso_code = ? LIMIT 1');
    $stmt->execute([$country]);
    $c = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$c) {
        http_response_code(400);
        echo json_encode(['error' => 'Country not allowed (must be in Europe)']);
        exit;
    }

    // The current voyagevista schema uses `country` (not `country_code`).
    // The imported schema requires `image` to be present, so use an empty string by default.
    $stmt = $db->prepare('INSERT INTO destinations (name, country, description, image) VALUES (?, ?, ?, ?)');
    $stmt->execute([$name, $country, $description, $image !== '' ? $image : '']);

    // A FAIRE: creer une notification admin de moderation apres creation d'une destination.

    $id = $db->lastInsertId();
    echo json_encode(['success' => true, 'id' => $id]);
    exit;

} catch (Exception $e) {
    error_log('Destination create error: ' . $e->getMessage());
    http_response_code(500);
    $payload = ['error' => 'Server error'];
    if (getenv('APP_ENV') !== 'production') {
        $payload['details'] = $e->getMessage();
        if (stripos($e->getMessage(), "Table 'voyagevista.countries' doesn't exist") !== false) {
            $payload['hint'] = 'Import sql/add_countries_to_voyagevista.sql into the voyagevista database, or point the app to the database that contains the countries table.';
        }
    }
    echo json_encode($payload);
    exit;
}

?>
