<?php
session_start();
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $course_name = $_POST['course_name'];
    $course_description = $_POST['course_description'];
    $location = $_POST['location'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $teacher_id = $_SESSION['user']['id']; // Assuming teacher is logged in and session has user data

    $sql = "INSERT INTO courses (course_name, course_description, location, start_date, end_date, user_id)
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$course_name, $course_description, $location, $start_date, $end_date, $user_id]);

    echo "Course created successfully!";
    header("Location: teacher_dashboard.php");
    exit();
} else {
    echo "Invalid request.";
}
?>
