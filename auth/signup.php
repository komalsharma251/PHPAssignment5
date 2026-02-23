<?php
declare(strict_types=1);

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

// Include config and database
require __DIR__ . '/../db/app.php';
require __DIR__ . '/../db/database.php';

// Start session
if (session_status() === PHP_SESSION_NONE) session_start();

$errors = [];
$email = '';
$first = '';
$last  = '';
$role  = 'user'; // Default role for public signup

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = strtolower(trim($_POST['email'] ?? ''));
    $password = $_POST['password'] ?? '';
    $confirm  = $_POST['confirm_password'] ?? '';
    $first = trim($_POST['first_name'] ?? '');
    $last  = trim($_POST['last_name'] ?? '');

    // Basic validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Valid email required.";
    if (strlen($password) < 8) $errors[] = "Password must be at least 8 characters.";
    if ($password !== $confirm) $errors[] = "Passwords do not match.";

    if (!$errors) {
        // Check if email already exists
        $stmt = $pdo->prepare("SELECT user_id FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        if ($stmt->fetch()) {
            $errors[] = "That email is already registered.";
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $pdo->prepare("
                INSERT INTO users (email, password_hash, role, first_name, last_name)
                VALUES (:email, :hash, :role, :first, :last)
            ");
            $stmt->execute([
                'email' => $email,
                'hash'  => $hash,
                'role'  => $role,
                'first' => $first ?: null,
                'last'  => $last ?: null,
            ]);

            // Auto-login after signup
            $newId = (int)$pdo->lastInsertId();
            $_SESSION['user'] = [
                'user_id' => $newId,
                'email'   => $email,
                'role'    => $role,
                'name'    => trim("$first $last"),
            ];

            header('Location: ' . BASE_URL . '/account/index.php');
            exit;
        }
    }
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Sign Up</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h2>Sign Up</h2>
        </div>
        <div class="card-body">

            <?php if ($errors): ?>
                <ul class="text-danger">
                    <?php foreach ($errors as $e): ?><li><?= htmlspecialchars($e) ?></li><?php endforeach; ?>
                </ul>
            <?php endif; ?>

            <form method="post">
                <div class="mb-3">
                    <label>First Name</label>
                    <input class="form-control" name="first_name" value="<?= htmlspecialchars($first) ?>">
                </div>
                <div class="mb-3">
                    <label>Last Name</label>
                    <input class="form-control" name="last_name" value="<?= htmlspecialchars($last) ?>">
                </div>
                <div class="mb-3">
                    <label>Email</label>
                    <input class="form-control" type="email" name="email" value="<?= htmlspecialchars($email) ?>" required>
                </div>
                <div class="mb-3">
                    <label>Password</label>
                    <input class="form-control" type="password" name="password" required>
                </div>
                <div class="mb-3">
                    <label>Confirm Password</label>
                    <input class="form-control" type="password" name="confirm_password" required>
                </div>

                <button class="btn btn-primary" type="submit">Create Account</button>
            </form>

            <p class="mt-3">Already have an account? <a href="<?= BASE_URL ?>/auth/login.php">Login</a></p>

        </div>
    </div>
</div>
</body>
</html>
