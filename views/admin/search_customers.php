<?php
// views/admin/search_customers.php
session_start(); // Start session to use session variables

// Include necessary files
require_once __DIR__ . '/../../db/app.php'; // for BASE_URL
require_once __DIR__ . '/../../db/database.php';
require_once __DIR__ . '/../../models/customer_db.php';

// Get the last name from the query parameter
$lastName = filter_input(INPUT_GET, 'lastName', FILTER_SANITIZE_SPECIAL_CHARS);


$customers = []; // Initialize an empty array for customers
if ($lastName) {
    $customers = get_customers_by_lastname($lastName);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Search Customers</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow">

        <div class="card-header bg-primary text-white">
            <h2 class="mb-0">Search Customers</h2>
        </div>

        <div class="card-body">

            <!-- SUCCESS MESSAGE -->
            <?php if (!empty($_SESSION['success_message'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?php echo $_SESSION['success_message']; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php unset($_SESSION['success_message']); ?>
            <?php endif; ?>

            <!-- SEARCH FORM -->
            <form method="get" action="search_customers.php" class="row g-3 mb-4">
                <div class="col-md-8">
                    <label class="form-label fw-bold">Last Name</label>
                    <input type="text" name="lastName" class="form-control"
                           value="<?php echo htmlspecialchars($lastName ?? ''); ?>" required>
                </div>

                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-success w-100">
                        Search
                    </button>
                </div>
            </form>

            <!-- RESULTS TABLE -->
            <?php if ($lastName): ?>
                <h5 class="mb-3">
                    Results for:
                    <span class="text-primary"><?php echo htmlspecialchars($lastName); ?></span>
                </h5>

                <?php if (count($customers) > 0): ?>
                    <table class="table table-bordered table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Country</th>
                                <th style="width: 120px;">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($customers as $customer): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($customer['firstName'] . " " . $customer['lastName']); ?></td>
                                    <td><?php echo htmlspecialchars($customer['email']); ?></td>
                                    <td><?php echo htmlspecialchars($customer['countryCode']); ?></td>
                                    <td>
                                        <form action="customer_form.php" method="get">
                                            <input type="hidden" name="customerID" value="<?php echo $customer['customerID']; ?>">
                                            <button type="submit" class="btn btn-primary btn-sm">
                                                Select
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>

                    </table>
                <?php else: ?>
                    <p class="text-danger fw-bold">No customers found.</p>
                <?php endif; ?>
            <?php endif; ?>

            <a href="<?= BASE_URL ?>/index.php" class="btn btn-secondary mt-3">Home</a>


        </div>
    </div>
</div>

<!-- Bootstrap JS (Required for alert close button) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
