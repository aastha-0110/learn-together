<?php
include 'db_connection.php';
$query = "SELECT * FROM user";
$stmt = $pdo->query($query);
$users = $stmt->fetchAll();
?>

<h2>Manage Users</h2>
<table>
    <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Role</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($users as $user): ?>
    <tr>
        <td><?php echo htmlspecialchars($user['name']); ?></td>
        <td><?php echo htmlspecialchars($user['email']); ?></td>
        <td><?php echo $user['role'] === '1' ? 'Admin' : 'User'; ?></td>
        <td>
            <a href="edit_user.php?id=<?php echo $user['id']; ?>">Edit</a>
            <a href="delete_user.php?id=<?php echo $user['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
