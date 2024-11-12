<?php
session_start();
include 'db_connection.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'student') {
    header("Location: login.php");
    exit();
}

$courseId = $_GET['id'];

// Fetch course details along with teacher's name from `user` and experience from `user_details`
$query = "SELECT courses.*, user.name AS teacher_name, user_details.experience AS teacher_experience 
          FROM courses 
          JOIN user ON courses.user_id = user.id 
          JOIN user_details ON user.id = user_details.user_id 
          WHERE courses.course_id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$courseId]);
$course = $stmt->fetch();

if (!$course) {
    echo "Course not found.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="course_details.css">

    <title><?php echo htmlspecialchars($course['course_name']); ?> - Details</title>
</head>
<body>
<div class="container">
<h2><?php echo htmlspecialchars($course['course_name']); ?></h2>
<p><strong>Location:</strong> <?php echo htmlspecialchars($course['location']); ?></p>
<p><strong>Description:</strong> <?php echo htmlspecialchars($course['course_description']); ?></p>
<p><strong>Start Date:</strong> <?php echo htmlspecialchars($course['start_date']); ?></p>
<p><strong>End Date:</strong> <?php echo htmlspecialchars($course['end_date']); ?></p>
<p><strong>Instructor:</strong> <?php echo htmlspecialchars($course['teacher_name']); ?></p>
<p><strong>Course duration:</strong> <?php echo htmlspecialchars($course['course_duration']); ?></p>
<p><strong>Study details:</strong> <?php echo htmlspecialchars($course['study_details']); ?></p>
<p><strong>Maximum students:</strong> <?php echo htmlspecialchars($course['max_students']); ?></p>
<p><strong>Timing:</strong> <?php echo htmlspecialchars($course['timing']); ?></p>


<form action="enroll.php" method="POST">
    <input type="hidden" name="course_id" value="<?php echo $courseId; ?>">
    <label for="date">Choose a date:</label>
    <input type="date" id="date" name="selected_date" required>
    <button type="submit">Enroll Now</button>
</form>
</div>

</body>
</html>
