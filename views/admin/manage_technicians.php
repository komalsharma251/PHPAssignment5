<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require __DIR__ . '/../../db/database.php';
require __DIR__ . '/../../models/technician_db.php';

$technicians = get_technicians();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Technicians</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-dark text-white">
            <h2 class="mb-0">Technician List</h2>
        </div>

        <div class="card-body">
            <table class="table table-bordered table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Technician Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th style="width: 120px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (count($technicians) > 0): ?>
                    <?php foreach ($technicians as $tech): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($tech['firstName'] . ' ' . $tech['lastName']); ?></td>
                            <td><?php echo htmlspecialchars($tech['email']); ?></td>
                            <td><?php echo htmlspecialchars($tech['phone']); ?></td>
                            <td>
                                <form action="delete_technician.php" method="post" onsubmit="return confirm('Are you sure?');">
                                    <input type="hidden" name="techID" value="<?php echo $tech['techID']; ?>">
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center">No technicians found.</td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>

            <a href="create_technician.php" class="btn btn-primary">Add Technician</a>
            <a href="../../index.php" class="btn btn-secondary">Home</a>
        </div>
    </div>
</div>

</body>
</html>
