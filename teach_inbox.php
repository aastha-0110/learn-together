<!-- inbox.php -->
<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['user']['id'];
include 'db_connection.php';


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="profile.css">
    <title>Inbox</title>
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
            <a href="teach_inbox.php" class="active">Inbox</a>
            <a href="my_course.php">My Courses</a>
            <a href="manage_students.php">Manage Students</a>
            <a href="settings.php">Settings</a>
        </nav>

        <div class="main-section">
            <h2>Inbox</h2>
            <p>Your messages and notifications will appear here.</p>
            <!-- Add inbox content here as needed -->
        </div>
    </div>
</main>

</body>
</html>
