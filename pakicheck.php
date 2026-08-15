<?php
session_start();

// Database connection
$host = "localhost";
$dbname = "school_db";
$user = "root";
$pass = "";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get login inputs
$studentID = trim($_POST['studentID']);
$password = trim($_POST['password']);

// Prepare & execute
$stmt = $conn->prepare("SELECT StudentID, FirstName, LastName FROM STUDENT WHERE StudentID = ? AND Password = ?");
$stmt->bind_param("ss", $studentID, $password);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();
    $_SESSION['student_id'] = $row['StudentID'];
    $_SESSION['full_name'] = $row['FirstName'] . ' ' . $row['LastName'];
    header("Location: home.php");
    exit;
} else {
    header("Location: index.html?error=1");
    exit;
}

$stmt->close();
$conn->close();
?>