<?php
session_start();
include 'db_connection.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'teacher') {
    header("Location: login.php");
    exit();
}

// Ensure a `course_id` is provided
if (!isset($_GET['course_id'])) {
    die("Course ID not specified.");
}

$courseId = $_GET['course_id'];
$teacherId = $_SESSION['user']['id'];

// Fetch the course details
$query = "SELECT * FROM courses WHERE course_id = ? AND user_id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$courseId, $teacherId]);
$course = $stmt->fetch();

if (!$course) {
    die("Course not found or you do not have permission to edit this course.");
}

// Handle form submission to update course
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_course'])) {
        $courseName = $_POST['course_name'];
        $courseDescription = $_POST['course_description'];
        $location = $_POST['location'];
        $curriculum = $_POST['study_details'];
        $daysToComplete = $_POST['course_duration'];
        $maxStudents = $_POST['max_students'];
        $startDate = $_POST['start_date'];
        $endDate = $_POST['end_date'];
        $timing = $_POST['timing'];

        $updateQuery = "UPDATE courses SET course_name = ?, course_description = ?, location = ?, study_details = ?, course_duration = ?, max_students = ?, start_date = ?, end_date = ?, timing = ? WHERE course_id = ?";
        $updateStmt = $pdo->prepare($updateQuery);
        $updateStmt->execute([$courseName, $courseDescription, $location, $curriculum, $daysToComplete, $maxStudents, $startDate, $endDate, $timing, $courseId]);

        echo "Course updated successfully!";
    }

    // Handle course deletion
    if (isset($_POST['delete_course'])) {
        $deleteQuery = "DELETE FROM courses WHERE course_id = ?";
        $deleteStmt = $pdo->prepare($deleteQuery);
        $deleteStmt->execute([$courseId]);

        echo "Course deleted successfully!";
        header("Location: teacher_dashboard.php"); // Redirect after deletion
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Course</title>
    <link rel="stylesheet" href="edit_course.css">
</head>
<body>

<div class="form-container">
    <h2>Edit Course</h2>
    <form action="" method="POST">
        <label for="course_name">Course Name:</label>
        <input type="text" id="course_name" name="course_name" value="<?php echo htmlspecialchars($course['course_name']); ?>" required>

        <label for="course_description">Description:</label>
        <textarea id="course_description" name="course_description" required><?php echo htmlspecialchars($course['course_description']); ?></textarea>

        <label for="location">Location:</label>
        <input type="text" id="location" name="location" value="<?php echo htmlspecialchars($course['location']); ?>" required>

        <label for="curriculum">Curriculum:</label>
        <textarea id="curriculum" name="curriculum" required><?php echo htmlspecialchars($course['study_details']); ?></textarea>

        <label for="days_to_complete">Days to Complete:</label>
        <input type="number" id="days_to_complete" name="days_to_complete" value="<?php echo htmlspecialchars($course['course_duration']); ?>" required>

        <label for="max_students">Maximum Students:</label>
        <input type="number" id="max_students" name="max_students" value="<?php echo htmlspecialchars($course['max_students']); ?>" required>

        <label for="start_date">Start Date:</label>
        <input type="date" id="start_date" name="start_date" value="<?php echo htmlspecialchars($course['start_date']); ?>" required>

        <label for="end_date">End Date:</label>
        <input type="date" id="end_date" name="end_date" value="<?php echo htmlspecialchars($course['end_date']); ?>" required>

        <label for="timing">Timing:</label>
        <input type="text" id="timing" name="timing" value="<?php echo htmlspecialchars($course['timing']); ?>" required>

        <button type="submit" name="update_course">Update Course</button>
        <button type="submit" name="delete_course" onclick="return confirm('Are you sure you want to delete this course?');">Delete Course</button>
    </form>
</div>

</body>
</html>
