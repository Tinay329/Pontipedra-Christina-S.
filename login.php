<?php
session_start();
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (!empty($username) && !empty($password)) {
        // Query the users table
        $stmt = $conn->prepare("SELECT id, firstname, lastname, password FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows === 1) {
            $user = $result->fetch_assoc();

            // Compatible with plain-text demo passwords (e.g. '123456') or password_hash()
            if ($password === $user['password'] || password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['full_name'] = $user['firstname'] . ' ' . $user['lastname'];
                header("Location: dashboard.php");
                exit();
            }
        }
        $stmt->close();
    }
    // Redirect on invalid login
    header("Location: index.html?error=1");
    exit();
}
?>