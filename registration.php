<?php
// Start the session to store user information
session_start();

echo "Reached registration.php";
$servername = "localhost";
$username = "root";  // Default username for WAMP
$password = "";      // Leave blank for WAMP
$dbname = "learntogether"; // Name of your database

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Connected successfully"; // This will confirm the connection
}

// Check if the form is submitted
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Secure password hashing
    $role = $_POST['role'];

    // Check if the email already exists using prepared statements
    $stmt = $conn->prepare("SELECT * FROM user WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "Email already exists!";
    } else {
        // Prepare and bind for inserting user data
        $stmt = $conn->prepare("INSERT INTO user (name, email, password, role) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $password, $role);

        if ($stmt->execute()) {
            // Store user ID in session after successful registration
            $_SESSION['user_id'] = $conn->insert_id; // Get the last inserted ID

            // Redirect to user details page
            header("Location: user_details.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
    }

    // Close the prepared statement
    $stmt->close();
}

// Close the connection
$conn->close();
?>
