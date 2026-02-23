<?php
declare(strict_types=1);

ini_set('display_errors', '1');
error_reporting(E_ALL);

// Include config and database
require __DIR__ . '/../db/app.php';
require __DIR__ . '/../db/database.php';

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) session_start();

$error = '';
$email = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = strtolower(trim($_POST['email'] ?? ''));
    $password = $_POST['password'] ?? '';

    if ($email === '' || $password === '') {
        $error = "Email and password are required.";
    } else {
        // Fetch user
        $stmt = $pdo->prepare("
            SELECT user_id, email, password_hash, role, first_name, last_name
            FROM users
            WHERE email = :email
        ");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verify user exists and password matches
        if (!$user || !password_verify($password, $user['password_hash'])) {
            $error = "Invalid email or password.";
        } else {
            // Good login: regenerate session id
            session_regenerate_id(true);

            // Store user info in session (avoid storing password hash)
            $_SESSION['user'] = [
                'user_id' => (int)$user['user_id'],
                'email'   => $user['email'],
                'role'    => $user['role'],
                'name'    => trim(($user['first_name'] ?? '') . ' ' . ($user['last_name'] ?? '')),
            ];

            // IMPORTANT: Get customerID from customers table using email (SportsPro requirement)
            $stmt2 = $pdo->prepare("
                SELECT customerID
                FROM customers
                WHERE email = :email
            ");
            $stmt2->execute(['email' => $user['email']]);
            $customer = $stmt2->fetch(PDO::FETCH_ASSOC);

            $_SESSION['customerID'] = $customer ? (int)$customer['customerID'] : null;

            // Optional: if customer not found, show error (recommended for SportsPro)
            if ($_SESSION['customerID'] === null && $user['role'] !== 'admin') {
                $error = "Customer record not found. Please add this email in customers table.";
            } else {
                // Redirect based on role
                $redirect = ($user['role'] === 'admin')
                    ? BASE_URL . '/index.php'
                    : BASE_URL . '/account/index.php';

                header("Location: $redirect");
                exit; // Important: Always exit after redirecting
            }
        }
    }
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow p-4">
        <h2>Login</h2>

        <?php if ($error): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="post">
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($email) ?>" required>
            </div>
            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>

        <p class="mt-3">No account? <a href="<?= BASE_URL ?>/auth/signup.php">Sign up</a></p>
    </div>
</div>

</body>
</html>
