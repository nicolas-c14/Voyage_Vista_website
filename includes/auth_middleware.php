<?php
require_once __DIR__ . '/session.php';

function require_login(string $redirectTo = '../login.php'): void
{
    if (empty($_SESSION['user_id'])) {
        header('Location: ' . $redirectTo);
        exit;
    }
}

function require_role($allowedRoles, string $redirectTo = '../index.php'): void
{
    require_login($redirectTo);

    $allowedRoles = is_array($allowedRoles) ? $allowedRoles : [$allowedRoles];
    $currentRole = $_SESSION['user_role'] ?? 'client';

    if (!in_array($currentRole, $allowedRoles, true)) {
        http_response_code(403);
        echo 'Accès interdit.';
        exit;
    }
}
