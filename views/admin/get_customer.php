<?php
declare(strict_types=1);

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

// Correct require paths
require __DIR__ . '/../../db/app.php';
require __DIR__ . '/../../db/database.php';

session_start();

// Only admin can access
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: ' . BASE_URL . '/auth/login.php');
    exit;
}

$error = '';
$customer = null;

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = strtolower(trim($_POST['email'] ?? ''));

    if ($email === '') {
        $error = "Please enter a customer email.";
    } else {
        // Fetch customer by email
        $stmt = $pdo->prepare("SELECT customerID, firstName, lastName FROM customers WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $customer = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$customer) {
            $error = "Customer not found with that email.";
        } else {
            // Store customer info in session for create_incident.php
            $_SESSION['incident_customerID'] = $customer['customerID'];
            $_SESSION['incident_customerName'] = $customer['firstName'] . ' ' . $customer['lastName'];

            // Redirect to create_incident.php
            header('Location: create_incident.php');
            exit;
        }
    }
}
?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Get Customer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="card shadow p-4">
        <h2>Get Customer</h2>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="post">
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <button class="btn btn-primary">Get Customer</button>
            <a href="<?= BASE_URL ?>/auth/logout.php" class="btn btn-secondary">Logout</a>
        </form>
    </div>
</div>
</body>
</html>
