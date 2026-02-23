<?php
declare(strict_types=1);

// Include the database connection
require_once __DIR__ . '/../db/database.php';

/**
 * Get customers by last name (partial match)
 *
 * @param string $lastName
 * @return array
 */
function get_customers_by_lastname(string $lastName): array {
    global $pdo;

    $query = "SELECT * FROM customers
              WHERE lastName LIKE :lastName
              ORDER BY lastName, firstName";

    $stmt = $pdo->prepare($query);
    $stmt->bindValue(':lastName', $lastName . '%');
    $stmt->execute();

    $customers = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $customers;
}

/**
 * Get a single customer by ID
 *
 * @param int $customerID
 * @return array|false
 */
function get_customer(int $customerID): array|false {
    global $pdo;

    $query = "SELECT * FROM customers WHERE customerID = :customerID";
    $stmt = $pdo->prepare($query);
    $stmt->bindValue(':customerID', $customerID, PDO::PARAM_INT);
    $stmt->execute();

    $customer = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $customer;
}

/**
 * Update a customer record
 *
 * @param int $customerID
 * @param string $firstName
 * @param string $lastName
 * @param string $address
 * @param string $city
 * @param string $state
 * @param string $postalCode
 * @param string $countryCode
 * @param string $phone
 * @param string $email
 */
function update_customer(
    int $customerID,
    string $firstName,
    string $lastName,
    string $address,
    string $city,
    string $state,
    string $postalCode,
    string $countryCode,
    string $phone,
    string $email
): void {
    global $pdo;

    $query = "UPDATE customers
              SET firstName = :firstName,
                  lastName = :lastName,
                  address = :address,
                  city = :city,
                  state = :state,
                  postalCode = :postalCode,
                  countryCode = :countryCode,
                  phone = :phone,
                  email = :email
              WHERE customerID = :customerID";

    $stmt = $pdo->prepare($query);
    $stmt->bindValue(':firstName', $firstName);
    $stmt->bindValue(':lastName', $lastName);
    $stmt->bindValue(':address', $address);
    $stmt->bindValue(':city', $city);
    $stmt->bindValue(':state', $state);
    $stmt->bindValue(':postalCode', $postalCode);
    $stmt->bindValue(':countryCode', $countryCode);
    $stmt->bindValue(':phone', $phone);
    $stmt->bindValue(':email', $email);
    $stmt->bindValue(':customerID', $customerID, PDO::PARAM_INT);

    $stmt->execute();
    $stmt->closeCursor();
}
