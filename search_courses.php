
<?php
session_start();
include 'db_connection.php';
if (!isset($_SESSION['user']) || !isset($_SESSION['user']['id'])) {
    header("Location: login.php");
    exit();
}
$searchQuery = isset($_GET['query']) ? trim($_GET['query']) : '';

if ($searchQuery) {
    // Search for courses with names that match the search query
    $query = "SELECT * FROM courses WHERE course_name LIKE ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['%' . $searchQuery . '%']);
    $courses = $stmt->fetchAll();
} else {
    $courses = [];
}



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="profile.css">
    <title>Search Results</title>
</head>
<body>

<header>
    <h1>Learn Together</h1>
    
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
            <a href="courses.php">Courses</a>
            <a href="groups.php">Groups</a>
            <a href="settings.php">Settings</a>
        </nav>

        <div class="main-section">
            <h2>Search Results</h2>
            <div class="courses-section">
        <h2>Results for "<?php echo htmlspecialchars($searchQuery); ?>"</h2>
        <?php if (count($courses) > 0): ?>
            <div class="courses-grid">
                <?php foreach ($courses as $course): ?>
                    <div class="course-box">
                        <h3><?php echo htmlspecialchars($course['course_name']); ?></h3>
                        <p>Location: <?php echo htmlspecialchars($course['location']); ?></p>
                        <button onclick="window.location.href='course_details.php?id=<?php echo htmlspecialchars($course['course_id']); ?>'">View</button>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>No courses found matching "<?php echo htmlspecialchars($searchQuery); ?>".</p>
        <?php endif; ?>
    </div>
            
        </div>
    </div>
</main>

</body>
</html>
