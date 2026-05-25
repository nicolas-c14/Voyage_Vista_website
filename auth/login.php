<?php
require_once __DIR__ . '/../includes/csrf.php';
require_once __DIR__ . '/../config/database.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../login.php');
    exit;
}

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';
$token = $_POST['csrf_token'] ?? '';

if (!csrf_validate($token)) {
    header('Location: ../login.php?error=csrf');
    exit;
}

try {
    $db = get_database_connection();
    $stmt = $db->prepare('SELECT id, password, role, first_name, last_name FROM users WHERE email = ? LIMIT 1');
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        session_regenerate_id(true);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_email'] = $email;
        $_SESSION['user_role'] = $user['role'] ?? 'user';
        $_SESSION['user_name'] = ($user['first_name'] ?? '') . ' ' . ($user['last_name'] ?? '');
        header('Location: ../index.php');
        exit;
    }

    header('Location: ../login.php?error=invalid');
    exit;

} catch (Exception $e) {
    // Log error server-side; do not expose details to user
    error_log('Login error: ' . $e->getMessage());
    header('Location: ../login.php?error=server');
    exit;
}

?>
