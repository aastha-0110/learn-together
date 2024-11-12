<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'teacher') {
    header("Location: login.php");
    exit();
}

include 'db_connection.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Capture form data
    $courseName = $_POST['course_name'];
    $courseDescription = $_POST['course_description'];
    $location = $_POST['location'];
    $studyDetails = $_POST['study_details'];
    $courseDuration = $_POST['course_duration'];
    $maxStudents = $_POST['max_students'];
    $startDate = $_POST['start_date'];
    $endDate = $_POST['end_date'];
    $timing = $_POST['timing'];
    $teacher_id = $_SESSION['user']['id'];


    // Insert the new course into the database
    $query = "INSERT INTO courses (course_name, course_description, location, study_details, course_duration, max_students, start_date, end_date, timing,user_id)
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$courseName, $courseDescription, $location, $studyDetails, $courseDuration, $maxStudents,$startDate, $endDate, $timing,$teacher_id]);

    // Redirect to the dashboard after successful creation
    header("Location: teacher_dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="new_course.css">
    <title>Create New Course</title>
</head>
<body>
    <h2>Create New Course</h2>
    <form action="create_new_course.php" method="POST">
        <div>
            <label for="course_name">Course Name:</label>
            <input type="text" name="course_name" id="course_name" placeholder="Course Name" required>
        </div>
        
        <div>
            <label for="course_description">Course Description:</label>
            <textarea name="course_description" id="course_description" placeholder="Course Description" required></textarea>
        </div>

        <div>
            <label for="location">Location (Detailed):</label>
            <textarea name="location" id="location" placeholder="Enter course location in detail" required></textarea>
        </div>

        <div>
            <label for="study_details">Study Details:</label>
            <textarea name="study_details" id="study_details" placeholder="What will be studied in this course" required></textarea>
        </div>

        <div>
            <label for="course_duration">Course Duration (in days):</label>
            <input type="number" name="course_duration" id="course_duration" placeholder="Duration in days" required>
        </div>

        <div>
            <label for="max_students">Maximum Number of Students:</label>
            <input type="number" name="max_students" id="max_students" placeholder="Max students allowed" required>
        </div>

        <div>
            <label for="start_date">Start Date:</label>
            <input type="date" name="start_date" id="start_date" required>
        </div>

        <div>
            <label for="end_date">End Date:</label>
            <input type="date" name="end_date" id="end_date" required>
        </div>

        <div>
            <label for="timing">Class Timing:</label>
            <input type="text" name="timing" id="timing" placeholder="e.g. 10:00 AM - 12:00 PM" required>
        </div>

        <button type="submit">Create Course</button>
    </form>
</body>
</html>
