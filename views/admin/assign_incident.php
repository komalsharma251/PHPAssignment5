<?php
declare(strict_types=1);

require __DIR__ . '/../../db/app.php';
require __DIR__ . '/../../db/database.php';

session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: ' . BASE_URL . '/auth/login.php');
    exit;
}

require __DIR__ . '/../header.php';

$stmt = $pdo->query("
    SELECT i.incidentID, i.title, i.dateOpened,
           c.firstName, c.lastName
    FROM incidents i
    JOIN customers c ON i.customerID = c.customerID
    WHERE i.techID IS NULL
    ORDER BY i.dateOpened DESC
");
$incidents = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-5">
<h2>Assign Incident</h2>

<?php if (empty($incidents)): ?>
    <div class="alert alert-info">No unassigned incidents.</div>
<?php else: ?>

<table class="table table-bordered table-striped">
<thead class="table-dark">
<tr>
    <th>Customer</th>
    <th>Title</th>
    <th>Date Opened</th>
    <th>Select</th>
</tr>
</thead>
<tbody>
<?php foreach ($incidents as $incident): ?>
<tr>
    <td><?= htmlspecialchars($incident['firstName'].' '.$incident['lastName']) ?></td>
    <td><?= htmlspecialchars($incident['title']) ?></td>
    <td><?= $incident['dateOpened'] ?></td>
    <td>
        <form method="post" action="select_technician.php">
            <input type="hidden" name="incidentID" value="<?= $incident['incidentID'] ?>">
            <button class="btn btn-primary btn-sm">Select</button>
        </form>
    </td>
</tr>
<?php endforeach; ?>
</tbody>
</table>

<?php endif; ?>
</div>

<?php require __DIR__ . '/../footer.php'; ?>