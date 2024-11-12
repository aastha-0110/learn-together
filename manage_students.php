<!-- manage_student.php -->
<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'teacher') {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['user']['id'];
include 'db_connection.php';

// Check if a course_id is provided
if (!isset($_GET['course_id'])) {
    die("Course ID not specified.");
}

$courseId = $_GET['course_id'];

// Fetch students enrolled in the specified course
$query = "
    SELECT u.user_id, u.name, u.email 
    FROM user u 
    INNER JOIN enrollments ce ON u.user_id = ce.student_id 
    WHERE ce.course_id = ? AND ce.teacher_id = ?
";
$stmt = $pdo->prepare($query);
$stmt->execute([$courseId, $userId]);
$students = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="profile.css">
    <title>Manage Students</title>
</head>
<body>

<header>
    <h1>Learn Together</h1>
    <div class="search-bar">
        <form action="search_courses.php" method="GET">
            <input type="text" name="query" placeholder="Search courses..." required>
            <button type="submit">Search</button>
        </form>
    </div>
    <div class="user-profile">
        <span id="username"><?php echo htmlspecialchars($_SESSION['user']['name']); ?></span>
        <div class="dropdown-content">
            <a href="edit_profile.php">Edit Profile</a>
            <a href="logout.php">Logout</a>
        </div>
    </div>
</header>

<main>
    <div class="content">
        <nav class="sidebar">
            <h2>Overview</h2>
            <a href="teacher_dashboard.php">Dashboard</a>
            <a href="teach_inbox.php">Inbox</a>
            <a href="my_course.php">My Courses</a>
            <a href="manage_students.php" class="active">Manage Students</a>
            <a href="settings.php">Settings</a>
        </nav>

        <div class="main-section">
            <h2>Students Enrolled in Course</h2>

            <?php if ($students): ?>
                <table>
                    <tr>
                        <th>Student Name</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                    <?php foreach ($students as $student): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($student['name']); ?></td>
                            <td><?php echo htmlspecialchars($student['email']); ?></td>
                            <td>
                                <a href="view_student.php?student_id=<?php echo $student['user_id']; ?>">View</a> |
                                <a href="remove_student.php?student_id=<?php echo $student['user_id']; ?>&course_id=<?php echo $courseId; ?>" onclick="return confirm('Are you sure you want to remove this student from the course?');">Remove</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php else: ?>
                <p>No students enrolled in this course.</p>
            <?php endif; ?>
        </div>
    </div>
</main>

</body>
</html>
