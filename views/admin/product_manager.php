<?php
declare(strict_types=1);

// Load BASE_URL
require __DIR__ . '/../../db/app.php';

// Connect to database
require __DIR__ . '/../../db/database.php';

// Include header
include __DIR__ . '/../header.php';
?>

<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h3 class="mb-0">Product List</h3>
        </div>
        <div class="card-body">
            <?php
            $sql = "SELECT productCode, name, version, releaseDate FROM products";
            $stmt = $pdo->query($sql);
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
            ?>
            
            <table class="table table-striped table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Product Code</th>
                        <th>Name</th>
                        <th>Version</th>
                        <th>Release Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?= htmlspecialchars($product['productCode']); ?></td>
                        <td><?= htmlspecialchars($product['name']); ?></td>
                        <td><?= htmlspecialchars($product['version']); ?></td>
                        <td><?= date('Y-m-d', strtotime($product['releaseDate'])); ?></td>
                        <td>
                            <form action="delete_product.php" method="post" style="display:inline;">
                                <input type="hidden" name="product_code" value="<?= htmlspecialchars($product['productCode']); ?>">
                                <button type="submit" class="btn btn-sm btn-danger"
                                    onclick="return confirm('Are you sure you want to delete this product?');">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="mt-3">
                <a href="add_product.php" class="btn btn-success">Add Product</a>
                <a href="<?= BASE_URL ?>/index.php" class="btn btn-secondary">Home</a>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../footer.php'; ?>
