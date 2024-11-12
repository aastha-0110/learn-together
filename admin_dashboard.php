<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin.css">
    <title>Admin Dashboard</title>
</head>
<body>
    <header>
        <h1>Admin Dashboard</h1>
        <a href="logout.php">Logout</a>
    </header>
    <div class="container">
        <aside class="sidebar">
            <nav>
                <a href="manage_users.php">Manage Users</a>
                <a href="manage_courses.php">Manage Courses</a>
                <a href="manage_enrollments.php">Manage Enrollments</a>
            </nav>
        </aside>
        <main class="main-content">
            <h2>Welcome, Admin</h2>
            <p>Select an option from the sidebar to manage the platform.</p>
        </main>
    </div>
</body>
</html>
