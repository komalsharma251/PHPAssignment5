
<?php
require('../../db/database.php');
require('../../models/technician_db.php');


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
                <?php foreach ($technicians as $technician) : ?>
                    <tr>
                        <td><?php echo $technician['firstName'] . " " . $technician['lastName']; ?></td>
                        <td><?php echo $technician['email']; ?></td>
                        <td><?php echo $technician['phone']; ?></td>

                        <td>
                            <form action="delete_technician.php" method="post">
                                <input type="hidden" name="techID" value="<?php echo $technician['techID']; ?>">
                                <button type="submit" class="btn btn-danger btn-sm">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>

            <a href="create_technician.php" class="btn btn-primary">Add Technician</a>
            <a href="../index.php" class="btn btn-secondary">Home</a>

        </div>
    </div>
</div>

</body>
</html>
