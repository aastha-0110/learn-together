<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'teacher') {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['user']['id'];
include 'db_connection.php';

// Fetch courses created by this teacher
$query = "SELECT * FROM courses WHERE user_id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$userId]);
$courses = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="profile.css">
    <title>Teacher Dashboard</title>
</head>
<body>

<header>
    <h1>Learn Together - Teacher Dashboard</h1>
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
            <a href="manage_students.php">Manage Students</a>
            <a href="settings.php">Settings</a>
        </nav>

        <div class="main-section">
            <div class="banner">
                <h2>Teach and Share</h2>
                <p>Help learners in your community gain new skills through engaging, in-person or online courses.</p>
            </div>
            
            <!-- Course Creation Form -->
            <!-- Create New Course Section -->
            <div class="create-course-section">
                 <h2>Create New Course</h2>
                <!-- Use a button that redirects to another page -->
                <a href="create_new_course.php">
                <button type="button">Create New Course</button>
                </a>
            </div>

            <!-- Manage Existing Courses -->
            <div class="manage-courses-section">
                <h2>Manage Your Courses</h2>
                <div class="courses-grid">
                    <?php foreach ($courses as $course): ?>
                        <div class="course-box">
                            <h3><?php echo htmlspecialchars($course['course_name']); ?></h3>
                            <p>Status: <?php echo htmlspecialchars($course['status'] ?? 'Active'); ?></p>
                            <button onclick="window.location.href='view_course_enrollment.php?course_id=<?php echo $course['course_id']; ?>'">View</button>
                            <button onclick="window.location.href='edit_course.php?course_id=<?php echo $course['course_id']; ?>'">Edit</button>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Availability Calendar Section -->
            <div class="availability-section">
                <h2>Set Availability</h2>
                <p>Choose your available dates and times for teaching.</p>
                <a href="set_availability.php" class="button">Set Availability</a>
            </div>
        </div>
    </div>
</main>

</body>
</html>
