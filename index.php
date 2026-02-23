<?php
declare(strict_types=1);

require __DIR__ . '/db/app.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// If user not logged in → redirect to login page
if (empty($_SESSION['user'])) {
    header("Location: " . BASE_URL . "/auth/login.php");
    exit;
}

// If user is NOT admin → redirect to user account page (or customer page)
if (($_SESSION['user']['role'] ?? '') !== 'admin') {
    header("Location: " . BASE_URL . "/account/index.php");
    exit;
}

// If admin → show admin dashboard content
require __DIR__ . '/views/header.php';
?>

<div class="container mt-5">

    <!-- PAGE HEADER -->
    <div class="text-center mb-5">
        <h1 class="fw-bold display-4">SportsPro Technical Support</h1>
        <p class="lead text-muted">
            Product management and technical support system
        </p>
    </div>

    <!-- ADMINISTRATORS -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Administrators</h4>
        </div>
        <div class="card-body">
            <div class="list-group list-group-flush">
                <a href="<?= BASE_URL ?>/views/admin/product_manager.php" class="list-group-item list-group-item-action">
                    Manage Products
                </a>
                <a href="<?= BASE_URL ?>/views/admin/manage_technicians.php" class="list-group-item list-group-item-action">
                    Manage Technicians
                </a>

                <a href="<?= BASE_URL ?>/views/admin/search_customers.php" class="list-group-item list-group-item-action">
                    Manage Customers
                </a>

                <a href="<?= BASE_URL ?>/views/admin/create_incident.php" class="list-group-item list-group-item-action">
                    Create Incident
                </a>
                <a href="<?= BASE_URL ?>/views/incidents/assign_incident.php" class="list-group-item list-group-item-action">
                    Assign Incident
                </a>
                <a href="<?= BASE_URL ?>/views/admin/view_incidents.php" class="list-group-item list-group-item-action">
                    Display Incidents
                </a>

            </div>
        </div>
    </div>

    <!-- TECHNICIANS -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-warning text-dark">
            <h4 class="mb-0">Technicians</h4>
        </div>
        <div class="card-body">
            <div class="list-group list-group-flush">
                <a href="<?= BASE_URL ?>/views/technicians/update_incident.php" class="list-group-item list-group-item-action">
                    Update Incident
                </a>
            </div>
        </div>
    </div>

    <!-- CUSTOMERS -->
    <div class="card shadow-sm mb-5">
        <div class="card-header bg-success text-white">
            <h4 class="mb-0">Customers</h4>
        </div>
        <div class="card-body">
            <div class="list-group list-group-flush">
                <a href="<?= BASE_URL ?>/views/customers/register_product.php" class="list-group-item list-group-item-action">
                    Register Product
                </a>
            </div>
        </div>
    </div>

    <div class="text-center mb-5">
        <a href="<?= BASE_URL ?>/auth/logout.php" class="btn btn-danger">
            Logout
        </a>
    </div>

</div>

<?php include __DIR__ . '/views/footer.php'; ?>
