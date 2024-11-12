<!-- courses.php -->
<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['user']['id'];
include 'db_connection.php';
$query = "SELECT * FROM courses";
$stmt = $pdo->prepare($query);
$stmt->execute();
$courses = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="profile.css">
    <title>Courses</title>
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
        <span id="username"><?php echo htmlspecialchars($_SESSION['user']['name']);?></span>
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
            <a href="profile.php">Dashboard</a>
            <a href="inbox.php">Inbox</a>
            <a href="courses.php" class="active">Courses</a>
            <a href="groups.php">Groups</a>
            <a href="settings.php">Settings</a>
        </nav>

        <div class="main-section">
            <h2>Courses</h2>
            <div class="courses-grid">
            <?php foreach ($courses as $course): ?>
                <div class="course-box">
                    <h3><?php echo htmlspecialchars($course['course_name']); ?></h3>
                    <p>Location: <?php echo htmlspecialchars($course['location']); ?></p>
                    <button onclick="window.location.href='course_details.php?id=<?php echo htmlspecialchars($course['course_id']); ?>'">View</button>
                </div>
            <?php endforeach; ?>
        </div>
        </div>
    </div>
</main>

</body>
</html>
