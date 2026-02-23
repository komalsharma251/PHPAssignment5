<?php
require __DIR__ . '/../../db/database.php';
require __DIR__ . '/../../models/technician_db.php';

$techID = filter_input(INPUT_POST, 'techID', FILTER_VALIDATE_INT);

if (!$techID) {
    $error_message = "Invalid technician ID.";
    include('error.php');
    exit();
}

delete_technician($techID);

header("Location: manage_technicians.php");
exit();
