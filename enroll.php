<?php
session_start();
include 'db_connection.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'student') {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_SESSION['user']['id'];
    $courseId = $_POST['course_id'];
    $selectedDate = $_POST['selected_date'];

    // Insert enrollment data
    $query = "INSERT INTO enrollments (user_id, course_id, selected_date) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$userId, $courseId, $selectedDate]);

    header("Location: profile.php?enrollment=success");
    exit();
}
?>
