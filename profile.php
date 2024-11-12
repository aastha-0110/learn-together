<?php
session_start();
if (!isset($_SESSION['user']) || !isset($_SESSION['user']['id'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['user']['id'];
$name = htmlspecialchars($_SESSION['user']['name']);
$email = htmlspecialchars($_SESSION['user']['email']);
$role = htmlspecialchars($_SESSION['user']['role']);

include 'db_connection.php';

// Fetch additional user details
$query = "SELECT * FROM user_details WHERE user_id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$userId]);
$userDetails = $stmt->fetch();

if (!$userDetails) {
    error_log("User details not found for user_id: $userId");
    die("No user details found.");
}

// Fetch all courses without location filtering
$coursesQuery = "SELECT * FROM courses";
$stmtCourses = $pdo->prepare($coursesQuery);
$stmtCourses->execute();
$courses = $stmtCourses->fetchAll();

include 'profile.html';
?>
