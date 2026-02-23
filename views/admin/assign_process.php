<?php
declare(strict_types=1);

require __DIR__ . '/../../db/app.php';
require __DIR__ . '/../../db/database.php';

session_start();

/* ================================
   ADMIN CHECK
================================ */
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: ' . BASE_URL . '/auth/login.php');
    exit;
}

/* ================================
   GET VALUES
================================ */
$incidentID = $_SESSION['incidentID'] ?? null;
$techID = filter_input(INPUT_POST, 'techID', FILTER_VALIDATE_INT);

/* ================================
   UPDATE INCIDENT
================================ */
if ($incidentID && $techID) {

    $stmt = $pdo->prepare("
        UPDATE incidents
        SET techID = :techID
        WHERE incidentID = :incidentID
    ");

    $stmt->execute([
        ':techID' => $techID,
        ':incidentID' => $incidentID
    ]);

    // Clear session incident
    unset($_SESSION['incidentID']);

    // Success message
    $_SESSION['incident_success'] = "Incident successfully assigned!";

    // Redirect to Assigned page
    header("Location: view_incidents.php?type=assigned");
    exit;

} else {

    $_SESSION['incident_success'] = "Invalid request.";
    header("Location: view_incidents.php?type=unassigned");
    exit;
}