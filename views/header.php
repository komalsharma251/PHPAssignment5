<?php
declare(strict_types=1);

// Include BASE_URL and start session
require_once __DIR__ . '/../db/app.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>SportsPro Technical Support</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand fw-bold" href="<?= BASE_URL ?>/index.php">
            SportsPro Technical Support
        </a>

        <button class="navbar-toggler" type="button"
                data-bs-toggle="collapse"
                data-bs-target="#mainNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav ms-auto">
                <?php if (!empty($_SESSION['user'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= BASE_URL ?>/index.php">Home</a>
                    </li>

                    <li class="nav-item">
                        <span class="nav-link text-white">
                            <?= htmlspecialchars($_SESSION['user']['name'] ?: $_SESSION['user']['email']) ?>
                        </span>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link btn btn-sm btn-danger text-white ms-2" 
                           href="<?= BASE_URL ?>/auth/logout.php">Logout</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= BASE_URL ?>/auth/login.php">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= BASE_URL ?>/auth/signup.php">Sign Up</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-5">
