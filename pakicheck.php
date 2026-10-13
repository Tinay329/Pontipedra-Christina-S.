<?php
session_start();

// Tugma sa iyong MySQL Database
$host = "localhost";
$dbname = "phpcrudchristina";
$user = "root";
$pass = "";

$conn = new mysqli($host,$user, $pass,$dbname);
if ($conn->connect_error) {
    die("Database Connection failed: " . $conn->connect_error);
}

// Kunin ang inputs galing sa form
$username = trim($_POST['username']);
$password = trim($_POST['password']);

// I-query ang table na `users`
$stmt =$conn->prepare("SELECT id, firstname, lastname, password FROM users WHERE username = ?");
$stmt->bind_param("s", $username);$stmt->execute();
$result =$stmt->get_result();

if ($result->num_rows === 1) {
    $row =$result->fetch_assoc();

    // Check kung parehas ang password
    if ($password === $row['password']) {$_SESSION['user_id'] = $row['id'];$_SESSION['full_name'] = $row['firstname'] . ' ' .$row['lastname'];
        
        // Pupunta sa ginawa nating dashboard
        header("Location: dashboard.php");
        exit();
    }
}

// Kung mali, ibalik sa index.php na may error flag
header("Location: index.php?error=1");
exit();

$stmt->close();$conn->close();
?>