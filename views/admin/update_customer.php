
<?php

session_start();

require_once __DIR__ . '/../../db/app.php'; // for BASE_URL
require_once __DIR__ . '/../../db/database.php';
require_once __DIR__ . '/../../models/customer_db.php';

$customerID = filter_input(INPUT_POST, 'customerID', FILTER_VALIDATE_INT);
$firstName = filter_input(INPUT_POST, 'firstName');
$lastName = filter_input(INPUT_POST, 'lastName');
$address = filter_input(INPUT_POST, 'address');
$city = filter_input(INPUT_POST, 'city');
$state = filter_input(INPUT_POST, 'state');
$postalCode = filter_input(INPUT_POST, 'postalCode');
$countryCode = filter_input(INPUT_POST, 'countryCode');
$phone = filter_input(INPUT_POST, 'phone');
$email = filter_input(INPUT_POST, 'email');

if (!$customerID || !$firstName || !$lastName) {
    $error_message = "First Name and Last Name are required.";
    $back_link = "search_customers.php";
    $back_text = "Back to Search";
    include('error.php');
    exit();
}

update_customer(
    $customerID,
    $firstName,
    $lastName,
    $address ?? '',
    $city ?? '',
    $state ?? '',
    $postalCode ?? '',
    $countryCode ?? 'US',
    $phone ?? '',
    $email ?? ''
);

$_SESSION['success_message'] = "Customer updated successfully!";

header("Location: search_customers.php?lastName=" . urlencode($lastName));
exit();
