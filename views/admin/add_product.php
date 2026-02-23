<?php
declare(strict_types=1);

// Include database connection
require __DIR__ . '/../../db/database.php';

// Include header
include __DIR__ . '/../header.php'; 

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $productCode = trim($_POST['productCode'] ?? '');
    $name        = trim($_POST['name'] ?? '');
    $version     = trim($_POST['version'] ?? '');
    $releaseDate = trim($_POST['releaseDate'] ?? '');

    // Server-side validation
    if ($productCode === '' || $name === '' || $version === '' || $releaseDate === '') {
        header('Location: ../error.php');
        exit;
    }

    // Use prepared statement to prevent SQL injection
    $sql = "INSERT INTO products (productCode, name, version, releaseDate)
            VALUES (:productCode, :name, :version, :releaseDate)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':productCode' => $productCode,
        ':name'        => $name,
        ':version'     => $version,
        ':releaseDate' => $releaseDate,
    ]);
    $stmt->closeCursor();

    // Redirect to Product List
    header('Location: product_manager.php');
    exit;
}
?>

<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-success text-white">
            <h3>Add Product</h3>
        </div>
        <div class="card-body">

            <form method="post">
                <div class="mb-3">
                    <label>Product Code</label>
                    <input type="text" name="productCode" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Version</label>
                    <input type="text" name="version" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Release Date</label>
                    <input type="date" name="releaseDate" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-success">Add Product</button>
                <a href="product_manager.php" class="btn btn-secondary ms-2">View Product List</a>
            </form>

        </div>
    </div>
</div>

<?php include __DIR__ . '/../footer.php'; ?>
