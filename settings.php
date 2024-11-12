<!-- settings.php -->
<?php
session_start();
if (!isset($_SESSION['user']) || !isset($_SESSION['user']['id'])) {
    header("Location: login.php");
    exit();
}


include 'db_connection.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="profile.css">
    <title>Settings</title>
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
            <a href="courses.php">Courses</a>
            <a href="groups.php">Groups</a>
            <a href="settings.php" class="active">Settings</a>
        </nav>

        <div class="main-section">
            <h2>Settings</h2>
            <p>Update your preferences and account settings here.</p>
            <!-- Add settings options here -->
        </div>
    </div>
</main>

</body>
</html>
