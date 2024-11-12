<?php
session_start();
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['submit'])) {
        echo "Form submitted successfully"; // Check if this line appears

        $email = htmlspecialchars($_POST['email']);
        $password = $_POST['password'];

        // Prepare and execute SQL query
        $query = "SELECT * FROM user WHERE email = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$email]);

        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user'] = [
                'id' => $user['id'],
                'name' => $user['name'],
                'email' => $user['email'],
                'role' => strtolower($user['role'])
            ];

            if ($_SESSION['user']['role'] === 'student') {
                header("Location: profile.php");
                exit();
            } elseif ($_SESSION['user']['role'] === 'teacher') {
                header("Location: teacher_dashboard.php");
                exit();
            }
        } else {
            echo "Invalid email or password.";
        }
    }
}
