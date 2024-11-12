<?php
// remove_enrollment.php

session_start();
require 'db_connection.php';

// Check if the user is an admin
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header("Location: admin_login.php");
    exit();
}

// Get the enrollment ID from the URL
if (isset($_GET['id'])) {
    $enrollment_id = $_GET['id'];

    // Prepare and execute delete statement
    $stmt = $pdo->prepare("DELETE FROM enrollments WHERE enrollment_id = ?");
    $stmt->execute([$enrollment_id]);

    // Redirect back to manage_enrollments.php
    header("Location: manage_enrollments.php");
    exit();
} else {
    echo "Invalid enrollment ID.";
}
?>
