<?php
declare(strict_types=1);

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

// Correct require paths
require __DIR__ . '/../../db/app.php';
require __DIR__ . '/../../db/database.php';

session_start();

// Admin check
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: ' . BASE_URL . '/auth/login.php');
    exit;
}

// Ensure customer selected
if (!isset($_SESSION['incident_customerID'])) {
    header('Location: get_customer.php');
    exit;
}


$customerID = (int)$_SESSION['incident_customerID'];
$customerName = $_SESSION['incident_customerName'] ?? '';

// Load products registered by this customer
$stmt = $pdo->prepare("
    SELECT p.productCode, p.name
    FROM products p
    INNER JOIN registrations r ON r.productCode = p.productCode
    WHERE r.customerID = :customerID
    ORDER BY p.name
");
$stmt->execute(['customerID' => $customerID]);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productCode = $_POST['productCode'] ?? '';
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');

    if ($productCode && $title && $description) {
        $stmt = $pdo->prepare("
            INSERT INTO incidents (customerID, productCode, title, description, dateOpened)
            VALUES (:customerID, :productCode, :title, :description, NOW())
        ");
        $stmt->execute([
            'customerID' => $customerID,
            'productCode' => $productCode,
            'title' => $title,
            'description' => $description
        ]);

        // Set a session flash message
        $_SESSION['incident_success'] = "Incident for <strong>".htmlspecialchars($customerName)."</strong> created successfully.";

        // Redirect to view_incidents.php
        header('Location: view_incidents.php');
        exit;
    } else {
        $error = "All fields are required.";
    }
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Create Incident</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="card shadow p-4">
        <h2>Create Incident</h2>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <p><strong>Customer:</strong> <?= htmlspecialchars($customerName) ?></p>

        <form method="post">
            <div class="mb-3">
                <label>Product</label>
                <select name="productCode" class="form-select" required>
                    <option value="">-- Select a Product --</option>
                    <?php foreach ($products as $p): ?>
                        <option value="<?= htmlspecialchars($p['productCode']) ?>">
                            <?= htmlspecialchars($p['name']) ?> (<?= htmlspecialchars($p['productCode']) ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label>Title</label>
                <input type="text" name="title" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Description</label>
                <textarea name="description" class="form-control" rows="4" required></textarea>
            </div>

            <button class="btn btn-success">Create Incident</button>
            <a href="<?= BASE_URL ?>/auth/logout.php" class="btn btn-secondary">Logout</a>
            <a href="get_customer.php" class="btn btn-secondary">Back to Get Customer</a>
        </form>
    </div>
</div>
</body>
</html>
