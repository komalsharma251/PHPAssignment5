<?php
declare(strict_types=1);

ini_set('display_errors', '1');
error_reporting(E_ALL);

require __DIR__ . '/../../db/app.php';
require __DIR__ . '/../../db/database.php';


if (session_status() === PHP_SESSION_NONE) session_start();

// if customer not logged in
if (!isset($_SESSION['customerID'])) {
    header("Location: " . BASE_URL . "/views/customers/customer_login.php");

    exit;
}

$customerID = (int)$_SESSION['customerID'];
$message = "";

// Load all products for dropdown
$stmt = $pdo->query("SELECT productCode, name FROM products ORDER BY name");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Handle Register Product button
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productCode = $_POST['productCode'] ?? '';

    if ($productCode === '') {
        $message = "<div class='alert alert-danger'>Please select a product.</div>";
    } else {
        // Check if already registered
        $check = $pdo->prepare("
            SELECT registrationID 
            FROM registrations 
            WHERE customerID = :customerID AND productCode = :productCode
        ");
        $check->execute([
            'customerID' => $customerID,
            'productCode' => $productCode
        ]);

        if ($check->fetch()) {
            $message = "<div class='alert alert-warning'>This product is already registered.</div>";
        } else {
            // Insert registration
            $stmt = $pdo->prepare("
                INSERT INTO registrations (customerID, productCode)
                VALUES (:customerID, :productCode)
            ");
            $stmt->execute([
                'customerID' => $customerID,
                'productCode' => $productCode
            ]);

            // SUCCESS MESSAGE (as your project requires)
            $message = "<div class='alert alert-success'>
                Product was registered successfully. Product Code: <strong>" . htmlspecialchars($productCode) . "</strong>
            </div>";
        }
    }
}
?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Register Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow p-4">
        <h2>Register Product</h2>

        <p><strong>Customer:</strong> <?= htmlspecialchars($_SESSION['customerName'] ?? '') ?></p>

        <?= $message ?>

        <form method="post">
            <div class="mb-3">
                <label class="form-label">Product</label>

                <select name="productCode" class="form-select" required>
                    <option value="">-- Select a Product --</option>

                    <?php foreach ($products as $product): ?>
                        <option value="<?= htmlspecialchars($product['productCode']) ?>">
                            <?= htmlspecialchars($product['name']) ?> (<?= htmlspecialchars($product['productCode']) ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <button class="btn btn-success">Register Product</button>

            
            <a href="<?= BASE_URL ?>/auth/logout.php" class="btn btn-secondary">Logout</a>


        </form>
    </div>
</div>

</body>
</html>
