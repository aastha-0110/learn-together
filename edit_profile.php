<?php
session_start(); // Start the session

// Database connection
$host = 'localhost'; // Database host
$dbname = 'learntogether'; // Database name
$username = 'root'; // Database username
$password = ''; // Database password (default for WAMP)

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    header('Location: login.php'); // Redirect to login page if not logged in
    exit();
}

// Fetch current user information
$userId = $_SESSION['user']['id']; // Assuming user ID is stored in session
$sql = "SELECT * FROM user WHERE id = :id"; // Ensure the table name is 'users'
$stmt = $conn->prepare($sql);
$stmt->bindValue(':id', $userId);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $location = htmlspecialchars($_POST['location']); // Fetch location from the form

    // Update user information in the database
    $updateSql = "UPDATE user SET name = :name, email = :email, location = :location WHERE id = :id"; // Use correct table name
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->bindValue(':name', $name);
    $updateStmt->bindValue(':email', $email);
    $updateStmt->bindValue(':location', $location);
    $updateStmt->bindValue(':id', $userId);

    if ($updateStmt->execute()) {
        $_SESSION['user']['name'] = $name; // Update session variable
        header('Location: profile.php'); // Redirect to profile page after updating
        exit();
    } else {
        $error = "Failed to update profile. Please try again.";
    }
} else {
    // Ensure $location is set to avoid undefined variable warning
    $location = $user['location'] ?? '';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="profile.css">
    <title>Edit Profile</title>
</head>
<body>

<header>
    <h1>Edit Profile</h1>
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
        <form action="" method="POST">
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>

            <label for="email">Email:</label>
            <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>

            <label for="location">Location:</label>
            <input type="text" name="location" id="location" value="<?php echo htmlspecialchars($location); ?>" required>

w            <button type="submit">Update Profile</button>
            <?php if (isset($error)): ?>
                <p class="error"><?php echo $error; ?></p>
            <?php endif; ?>
        </form>
    </div>
</main>

</body>


























</html>
