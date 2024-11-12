<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}

// Assuming user data is stored in the session
$userName = $_SESSION['user']['name'];
$userRole = $_SESSION['user']['role'];
?>
