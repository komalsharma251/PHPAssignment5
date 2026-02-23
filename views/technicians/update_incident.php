<?php
declare(strict_types=1);

require __DIR__ . '/../../db/app.php';
require __DIR__ . '/../../db/database.php';

session_start();

if (!isset($_SESSION['techID'])) {
    header('Location: technician_login.php');
    exit;
}

$techID = $_SESSION['techID'];

if (isset($_POST['incidentID'])) {
    $_SESSION['incidentID'] = $_POST['incidentID'];
}

if (isset($_POST['update'])) {

    $stmt = $pdo->prepare("
        UPDATE incidents
        SET description = :description,
            dateClosed = :dateClosed
        WHERE incidentID = :incidentID
    ");

    $stmt->execute([
        ':description' => $_POST['description'],
        ':dateClosed' => $_POST['dateClosed'] ?: null,
        ':incidentID' => $_SESSION['incidentID']
    ]);

    $message = "Incident updated successfully!";
}

$stmt = $pdo->prepare("
    SELECT * FROM incidents
    WHERE techID = :techID
    AND dateClosed IS NULL
");
$stmt->execute([':techID' => $techID]);
$incidents = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-5">
<h2>Your Open Incidents</h2>

<?php if (!empty($message)): ?>
<div class="alert alert-success"><?= $message ?></div>
<?php endif; ?>

<?php if (empty($incidents)): ?>
<p>No open incidents.</p>
<?php else: ?>
<table class="table table-bordered">
<tr>
<th>Title</th>
<th>Date Opened</th>
<th>Select</th>
</tr>
<?php foreach ($incidents as $incident): ?>
<tr>
<td><?= $incident['title'] ?></td>
<td><?= $incident['dateOpened'] ?></td>
<td>
<form method="post">
<input type="hidden" name="incidentID" value="<?= $incident['incidentID'] ?>">
<button class="btn btn-primary btn-sm">Select</button>
</form>
</td>
</tr>
<?php endforeach; ?>
</table>
<?php endif; ?>

<?php if (isset($_SESSION['incidentID'])): ?>
<hr>
<h4>Update Incident</h4>
<form method="post">
<textarea name="description" class="form-control mb-2" required></textarea>
<input type="date" name="dateClosed" class="form-control mb-2">
<button name="update" class="btn btn-success">Update Incident</button>
</form>
<?php endif; ?>
</div>