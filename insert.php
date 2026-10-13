<?php
session_start();
require_once 'db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.html");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstname = trim($_POST['firstname']);
    $lastname = trim($_POST['lastname']);

    if (!empty($firstname) && !empty($lastname)) {
        $stmt = $conn->prepare("INSERT INTO students (firstname, lastname) VALUES (?, ?)");
        $stmt->bind_param("ss", $firstname, $lastname);
        $stmt->execute();
        $stmt->close();
    }
}

// Redirect back to dashboard
header("Location: dashboard.php");
exit();
?>