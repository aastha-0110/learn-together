<?php
session_start();
include 'db_connection.php';

// Ensure output buffering to prevent any header issues
ob_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if user ID is set in session
    if (!isset($_SESSION['user_id'])) {
        die("User is not logged in.");
    }

    // Get user input
    $userId = $_SESSION['user_id'];
    $role = $_POST['role'];
    $location = $_POST['location'];

    // Handle file upload
    $targetFile = '';
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
        $targetDir = "uploads/";
        $targetFile = $targetDir . basename($_FILES['profile_picture']['name']);
        
        // Move uploaded file
        if (!move_uploaded_file($_FILES['profile_picture']['tmp_name'], $targetFile)) {
            die("File upload failed.");
        }
    } else {
        die("Profile picture upload error.");
    }

    // Prepare and execute SQL based on role
    try {
        if ($role === 'teacher') {
            $teachingSubject = $_POST['teaching_subject'];
            $experience = $_POST['experience'];

            $query = "INSERT INTO user_details (user_id, profile_picture, location, teaching_subject, experience) VALUES (?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$userId, $targetFile, $location, $teachingSubject, $experience]);
        } else {
            $interests = $_POST['interests'];

            $query = "INSERT INTO user_details (user_id, profile_picture, location, interests) VALUES (?, ?, ?, ?)";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$userId, $targetFile, $location, $interests]);
        }

        // Redirect to profile.php after successful execution
        header("Location: login.html");
        exit();
        
    } catch (PDOException $e) {
        die("Database insert error: " . $e->getMessage());
    }
}

// End output buffering and flush output
ob_end_flush();
?>
