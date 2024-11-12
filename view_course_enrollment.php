<?php
session_start();
include 'db_connection.php';

// Check if the user is a teacher
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'teacher') {
    header("Location: login.php");
    exit();
}

// Get the course_id from the URL
if (!isset($_GET['course_id'])) {
    die("Course ID not specified.");
}
$courseId = $_GET['course_id'];

// Fetch the course details
$query = "SELECT * FROM courses WHERE course_id = ? AND user_id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$courseId, $_SESSION['user']['id']]);
$course = $stmt->fetch();

if (!$course) {
    die("Course not found or you are not authorized to view this course.");
}

// Fetch students enrolled in this course
$query = "SELECT user.name, user.email, enrollments.enrollment_date
          FROM enrollments
          JOIN user ON enrollments.user_id = user.id
          WHERE enrollments.course_id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$courseId]);
$enrollments = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="course_enrollment.css">
    <title>Course Enrollments</title>
</head>
<body>

<h2><?php echo htmlspecialchars($course['course_name']); ?> - Enrollments</h2>
<p><?php echo htmlspecialchars($course['course_description']); ?></p>

<?php if ($enrollments): ?>
    <table border="1">
        <tr>
            <th>Student Name</th>
            <th>Email</th>
            <th>Selected Date</th>
        </tr>
        <?php foreach ($enrollments as $enrollment): ?>
            <tr>
                <td><?php echo htmlspecialchars($enrollment['name']); ?></td>
                <td><?php echo htmlspecialchars($enrollment['email']); ?></td>
                <td><?php echo htmlspecialchars($enrollment['enrollment_date']); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php else: ?>
    <p>No students enrolled in this course yet.</p>
<?php endif; ?>

</body>
</html>
