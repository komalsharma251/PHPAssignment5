
<?php

// views/admin/customer_form.php
require_once __DIR__ . '/../../db/database.php';
require_once __DIR__ . '/../../models/customer_db.php';

$customerID = filter_input(INPUT_GET, 'customerID', FILTER_VALIDATE_INT);

if (!$customerID) {
    $error_message = "Invalid Customer ID.";
    $back_link = "search_customers.php";
    $back_text = "Back to Search";
    include('error.php');
    exit();
}

$customer = get_customer($customerID);

if (!$customer) {
    $error_message = "Customer not found.";
    $back_link = "search_customers.php";
    $back_text = "Back to Search";
    include('error.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>View / Update Customer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow">

        <div class="card-header bg-dark text-white">
            <h2 class="mb-0">View / Update Customer</h2>
        </div>

        <div class="card-body">

            <form action="update_customer.php" method="post">

                <input type="hidden" name="customerID" value="<?php echo $customer['customerID']; ?>">

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">First Name</label>
                        <input type="text" name="firstName" class="form-control"
                               value="<?php echo htmlspecialchars($customer['firstName']); ?>" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Last Name</label>
                        <input type="text" name="lastName" class="form-control"
                               value="<?php echo htmlspecialchars($customer['lastName']); ?>" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Address</label>
                    <input type="text" name="address" class="form-control"
                           value="<?php echo htmlspecialchars($customer['address']); ?>">
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label fw-bold">City</label>
                        <input type="text" name="city" class="form-control"
                               value="<?php echo htmlspecialchars($customer['city']); ?>">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold">State</label>
                        <input type="text" name="state" class="form-control"
                               value="<?php echo htmlspecialchars($customer['state']); ?>">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold">Postal Code</label>
                        <input type="text" name="postalCode" class="form-control"
                               value="<?php echo htmlspecialchars($customer['postalCode']); ?>">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Country Code</label>
                        <select name="countryCode" class="form-select">
                            <option value="US" <?php if ($customer['countryCode'] === 'US') echo 'selected'; ?>>US</option>
                            <option value="CA" <?php if ($customer['countryCode'] === 'CA') echo 'selected'; ?>>CA</option>
                            <option value="IN" <?php if ($customer['countryCode'] === 'IN') echo 'selected'; ?>>IN</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Phone</label>
                        <input type="text" name="phone" class="form-control"
                               value="<?php echo htmlspecialchars($customer['phone']); ?>">
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Email</label>
                    <input type="email" name="email" class="form-control"
                           value="<?php echo htmlspecialchars($customer['email']); ?>">
                </div>

                <button type="submit" class="btn btn-success">
                    Update Customer
                </button>

                <a href="search_customers.php" class="btn btn-primary">
                    Search Customers
                </a>

                <a href="search_customers.php?lastName=<?php echo urlencode($customer['lastName']); ?>" class="btn btn-secondary">
                    Back
                </a>

            </form>

        </div>
    </div>
</div>

</body>
</html>
