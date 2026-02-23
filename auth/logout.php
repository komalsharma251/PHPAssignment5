<?php
declare(strict_types=1);

require __DIR__ . '/../db/app.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/*
    Decide redirect BEFORE destroying session
*/
$redirect = BASE_URL . '/auth/login.php'; // default (admin/user login)

if (isset($_SESSION['customerID'])) {
    $redirect = BASE_URL . '/views/customers/customer_login.php';
}

/*
    Clear session data
*/
$_SESSION = [];

// Destroy session cookie
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// Destroy session
session_destroy();

// Redirect correctly
header("Location: $redirect");
exit;
