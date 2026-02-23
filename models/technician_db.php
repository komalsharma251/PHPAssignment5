<?php
declare(strict_types=1);

// Include the database connection
require_once __DIR__ . '/../db/database.php';

/**
 * Get all technicians
 *
 * @return array
 */
function get_technicians(): array {
    global $pdo; // Use the PDO object from database.php

    $query = "SELECT * FROM technicians ORDER BY lastName";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $technicians = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $technicians;
}

/**
 * Add a new technician
 *
 * @param string $firstName
 * @param string $lastName
 * @param string $email
 * @param string $phone
 * @param string $passwordHash
 */
function add_technician(string $firstName, string $lastName, string $email, string $phone, string $passwordHash): void {
    global $pdo;

    $query = "INSERT INTO technicians (firstName, lastName, email, phone, passwordHash)
              VALUES (:firstName, :lastName, :email, :phone, :passwordHash)";
    
    $stmt = $pdo->prepare($query);
    $stmt->bindValue(':firstName', $firstName);
    $stmt->bindValue(':lastName', $lastName);
    $stmt->bindValue(':email', $email);
    $stmt->bindValue(':phone', $phone);
    $stmt->bindValue(':passwordHash', $passwordHash);
    $stmt->execute();
    $stmt->closeCursor();
}

/**
 * Delete a technician by ID
 *
 * @param int $techID
 */
function delete_technician(int $techID): void {
    global $pdo;

    $query = "DELETE FROM technicians WHERE techID = :techID";
    $stmt = $pdo->prepare($query);
    $stmt->bindValue(':techID', $techID, PDO::PARAM_INT);
    $stmt->execute();
    $stmt->closeCursor();
}
