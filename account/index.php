<?php
declare(strict_types=1);

// Include config
require __DIR__ . '/../db/app.php';

// Require login
require __DIR__ . '/../auth/require_login.php';
?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>My Account</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h2>My Account</h2>
        </div>
        <div class="card-body">
            <p><strong>Email:</strong> <?= htmlspecialchars($_SESSION['user']['email']) ?></p>
            <p><strong>Role:</strong> <?= htmlspecialchars($_SESSION['user']['role']) ?></p>
            <p><strong>Name:</strong> <?= htmlspecialchars($_SESSION['user']['name'] ?: '—') ?></p>

            <?php if ($_SESSION['user']['role'] === 'admin'): ?>
                <p>
                    <a class="btn btn-warning" href="<?= BASE_URL ?>/admin/dashboard.php">Go to Admin Dashboard</a>
                </p>
            <?php endif; ?>

            <p>
                <a href="<?= BASE_URL ?>/auth/logout.php" class="btn btn-danger">Logout</a>

            </p>
        </div>
    </div>
</div>

</body>
</html>
