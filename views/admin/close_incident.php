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
   GET INCIDENT ID
================================ */
$incidentID = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if ($incidentID) {

    /* ================================
       CLOSE INCIDENT
    ================================= */
    $stmt = $pdo->prepare("
        UPDATE incidents
        SET dateClosed = NOW()
        WHERE incidentID = :incidentID
    ");

    $stmt->execute([
        ':incidentID' => $incidentID
    ]);

    /* ================================
       SUCCESS MESSAGE
    ================================= */
    $_SESSION['incident_success'] = "Incident successfully closed!";

    /* ================================
       REDIRECT TO ASSIGNED PAGE
    ================================= */
    header("Location: view_incidents.php?type=assigned");
    exit;

} else {

    $_SESSION['incident_success'] = "Invalid request.";
    header("Location: view_incidents.php?type=assigned");
    exit;
}