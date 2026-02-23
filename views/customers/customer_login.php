<?php
declare(strict_types=1);

ini_set('display_errors', '1');
error_reporting(E_ALL);

require __DIR__ . '/../../db/app.php';
require __DIR__ . '/../../db/database.php';


if (session_status() === PHP_SESSION_NONE) session_start();

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = strtolower(trim($_POST['email'] ?? ''));

    if ($email === '') {
        $error = "Please enter your email.";
    } else {
        // Find customer by email
        $stmt = $pdo->prepare("SELECT customerID, firstName, lastName FROM customers WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $customer = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$customer) {
            $error = "No customer found with this email.";
        } else {
            $_SESSION['customerID'] = (int)$customer['customerID'];
            $_SESSION['customerName'] = $customer['firstName'] . " " . $customer['lastName'];

            header("Location: register_product.php");
            exit;
        }
    }
}
?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Customer Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow p-4">
        <h2>Customer Login</h2>

        <?php if ($error): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="post">
            <div class="mb-3">
                <label>Email Address</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <button class="btn btn-primary">Login</button>
        </form>
    </div>
</div>

</body>
</html>
