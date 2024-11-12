<?php
// manage_enrollments.php

// Start session and include database connection
session_start();
require 'db_connection.php';

// Check if the user is an admin
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header("Location: admin_login.php");
    exit();
}

// Query to fetch all enrollments with user and course details
$query = "
    SELECT enrollments.enrollment_id, users.name AS user_name, courses.course_name, enrollments.enrollment_date
    FROM enrollments
    JOIN users ON enrollments.user_id = users.user_id
    JOIN courses ON enrollments.course_id = courses.course_id
    ORDER BY enrollments.enrollment_date DESC
";
$stmt = $pdo->query($query);
$enrollments = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin.css">
    <title>Manage Enrollments</title>
</head>
<body>
    <header>
        <h1>Admin Dashboard - Manage Enrollments</h1>
        <a href="admin_dashboard.php">Back to Dashboard</a>
    </header>

    <main>
        <h2>Enrollments</h2>
        <table>
            <tr>
                <th>User Name</th>
                <th>Course Name</th>
                <th>Enrollment Date</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($enrollments as $enrollment): ?>
            <tr>
                <td><?php echo htmlspecialchars($enrollment['user_name']); ?></td>
                <td><?php echo htmlspecialchars($enrollment['course_name']); ?></td>
                <td><?php echo htmlspecialchars($enrollment['enrollment_date']); ?></td>
                <td>
                    <a href="remove_enrollment.php?id=<?php echo $enrollment['enrollment_id']; ?>" onclick="return confirm('Are you sure you want to remove this enrollment?')">Remove</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </main>
</body>
</html>
