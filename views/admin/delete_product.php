<?php
declare(strict_types=1);

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


// Include database connection
require __DIR__ . '/../../db/database.php'; 

// Get product code from POST
$product_code = $_POST['product_code'] ?? '';

if ($product_code !== '') {
    // Use prepared statement to safely delete
    $sql = "DELETE FROM products WHERE productCode = :productCode";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':productCode' => $product_code]);
    $stmt->closeCursor();
}

// Redirect back to Product Manager
header('Location: product_manager.php');
exit;
