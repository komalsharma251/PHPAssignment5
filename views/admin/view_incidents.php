<?php
declare(strict_types=1);

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require __DIR__ . '/../../db/app.php';
require __DIR__ . '/../../db/database.php';

session_start();

// Only admin can access
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: ' . BASE_URL . '/auth/login.php');
    exit;
}

// Flash message
$successMsg = $_SESSION['incident_success'] ?? null;
unset($_SESSION['incident_success']);

// Page type
$type = $_GET['type'] ?? 'unassigned';

/* ================================
   FETCH INCIDENTS
================================ */

if ($type === 'assigned') {

    $stmt = $pdo->query("
        SELECT i.incidentID, i.title, i.description,
               i.dateOpened, i.dateClosed,
               c.firstName, c.lastName,
               p.name AS productName,
               t.firstName AS techFirst,
               t.lastName AS techLast
        FROM incidents i
        JOIN customers c ON i.customerID = c.customerID
        JOIN products p ON i.productCode = p.productCode
        JOIN technicians t ON i.techID = t.techID
        ORDER BY i.dateOpened DESC
    ");

} else {

    $stmt = $pdo->query("
        SELECT i.incidentID, i.title, i.description,
               i.dateOpened, i.dateClosed,
               c.firstName, c.lastName,
               p.name AS productName
        FROM incidents i
        JOIN customers c ON i.customerID = c.customerID
        JOIN products p ON i.productCode = p.productCode
        WHERE i.techID IS NULL
        ORDER BY i.dateOpened DESC
    ");
}

$incidents = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>View Incidents</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">

<h2 class="mb-4">
    <?= $type === 'assigned' ? 'Assigned Incidents' : 'Unassigned Incidents' ?>
</h2>

<!-- Toggle Buttons -->
<div class="mb-3">
    <a href="view_incidents.php?type=unassigned"
       class="btn btn-outline-primary <?= $type === 'unassigned' ? 'active' : '' ?>">
        View Unassigned
    </a>

    <a href="view_incidents.php?type=assigned"
       class="btn btn-outline-success <?= $type === 'assigned' ? 'active' : '' ?>">
        View Assigned
    </a>
</div>

<?php if ($successMsg): ?>
    <div class="alert alert-success">
        <?= htmlspecialchars($successMsg) ?>
    </div>
<?php endif; ?>

<table class="table table-striped table-bordered">
<thead class="table-dark">
<tr>
    <th>ID</th>
    <th>Customer</th>
    <th>Product</th>
    <th>Title</th>
    <th>Description</th>
    <th>Date Opened</th>

    <?php if ($type === 'assigned'): ?>
        <th>Technician</th>
        <th>Status</th>
        <th>Action</th>
    <?php endif; ?>

    <?php if ($type === 'unassigned'): ?>
        <th>Actions</th>
    <?php endif; ?>
</tr>
</thead>

<tbody>

<?php if (empty($incidents)): ?>
<tr>
    <td colspan="9" class="text-center">
        No incidents found.
    </td>
</tr>
<?php else: ?>

<?php foreach ($incidents as $incident): ?>
<tr>
    <td><?= $incident['incidentID'] ?></td>

    <td>
        <?= htmlspecialchars($incident['firstName'].' '.$incident['lastName']) ?>
    </td>

    <td>
        <?= htmlspecialchars($incident['productName']) ?>
    </td>

    <td><?= htmlspecialchars($incident['title']) ?></td>

    <td><?= htmlspecialchars($incident['description']) ?></td>

    <td><?= $incident['dateOpened'] ?></td>

    <?php if ($type === 'assigned'): ?>

        <td>
            <?= htmlspecialchars($incident['techFirst'].' '.$incident['techLast']) ?>
        </td>

        <td>
            <?=
                $incident['dateClosed']
                ? $incident['dateClosed']
                : '<span class="badge bg-warning text-dark">OPEN</span>'
            ?>
        </td>

        <td>
            <?php if (!$incident['dateClosed']): ?>
                <a href="close_incident.php?id=<?= $incident['incidentID'] ?>"
                   class="btn btn-sm btn-danger"
                   onclick="return confirm('Are you sure you want to close this incident?');">
                    Close
                </a>
            <?php else: ?>
                <span class="badge bg-secondary">Closed</span>
            <?php endif; ?>
        </td>

    <?php endif; ?>

    <?php if ($type === 'unassigned'): ?>
        <td>
            <a href="<?= BASE_URL ?>/views/admin/assign_incident.php?id=<?= $incident['incidentID'] ?>"
               class="btn btn-sm btn-warning">
                Assign
            </a>
        </td>
    <?php endif; ?>

</tr>
<?php endforeach; ?>

<?php endif; ?>

</tbody>
</table>

<a href="create_incident.php" class="btn btn-primary">
    Create New Incident
</a>

<a href="<?= BASE_URL ?>/auth/logout.php"
   class="btn btn-secondary">
    Logout
</a>

</div>

</body>
</html>