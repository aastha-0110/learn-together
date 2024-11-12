<?php
include 'db_connection.php';
$query = "SELECT * FROM courses";
$stmt = $pdo->query($query);
$courses = $stmt->fetchAll();
?>

<h2>Manage Courses</h2>
<table>
    <tr>
        <th>Course Name</th>
        <th>Location</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($courses as $course): ?>
    <tr>
        <td><?php echo htmlspecialchars($course['course_name']); ?></td>
        <td><?php echo htmlspecialchars($course['location']); ?></td>
        <td>
            <a href="edit_course.php?id=<?php echo $course['course_id']; ?>">Edit</a>
            <a href="delete_course.php?id=<?php echo $course['course_id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
