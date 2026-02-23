<?php
declare(strict_types=1);

require __DIR__ . '/../../db/app.php';
require __DIR__ . '/../../db/database.php';

session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: ' . BASE_URL . '/auth/login.php');
    exit;
}

if (isset($_POST['incidentID'])) {
    $_SESSION['incidentID'] = (int)$_POST['incidentID'];
}

require __DIR__ . '/../header.php';

$stmt = $pdo->query("
    SELECT t.techID, t.firstName, t.lastName,
       (SELECT COUNT(*)
        FROM incidents i
        WHERE i.techID = t.techID
        AND i.dateClosed IS NULL) AS openIncidents
    FROM technicians t
    ORDER BY t.lastName
");
$technicians = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-5">
<h2>Select Technician</h2>

<table class="table table-bordered table-striped">
<thead class="table-dark">
<tr>
    <th>Name</th>
    <th>Open Incidents</th>
    <th>Assign</th>
</tr>
</thead>
<tbody>
<?php foreach ($technicians as $tech): ?>
<tr>
    <td><?= htmlspecialchars($tech['firstName'].' '.$tech['lastName']) ?></td>
    <td><?= $tech['openIncidents'] ?></td>
    <td>
        <form method="post" action="assign_process.php">
            <input type="hidden" name="techID" value="<?= $tech['techID'] ?>">
            <button class="btn btn-success btn-sm">Assign</button>
        </form>
    </td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</div>

<?php require __DIR__ . '/../footer.php'; ?>