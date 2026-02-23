<?php
require __DIR__ . '/../../db/database.php';
require __DIR__ . '/../../models/technician_db.php';

$firstName = filter_input(INPUT_POST, 'firstName');
$lastName  = filter_input(INPUT_POST, 'lastName');
$email     = filter_input(INPUT_POST, 'email');
$phone     = filter_input(INPUT_POST, 'phone');
$password  = filter_input(INPUT_POST, 'password');

if (!$firstName || !$lastName || !$email || !$phone || !$password) {
    $error_message = "All fields are required.";
    include('error.php');
    exit();
}

$passwordHash = password_hash($password, PASSWORD_DEFAULT);

add_technician($firstName, $lastName, $email, $phone, $passwordHash);

header("Location: manage_technicians.php");
exit();
