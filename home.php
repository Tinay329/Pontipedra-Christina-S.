<?php
session_start();
if (!isset($_SESSION['student_id'])) {
    header("Location: index.html");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Home | Student Portal</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; padding: 50px; background: #f0f8ff; }
        .box { background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); display: inline-block; }
        h2 { color: #2c3e50; margin-bottom: 15px; }
        p { font-size: 16px; color: #555; margin-bottom: 20px; }
        .logout { padding: 10px 20px; background: #e74c3c; color: white; border-radius: 25px; text-decoration: none; }
        .logout:hover { background: #c0392b; }
    </style>
</head>
<body>
    <div class="box">
        <h2>Welcome, <?php echo $_SESSION['full_name']; ?>!</h2>
        <p>Student ID: <?php echo $_SESSION['student_id']; ?></p>
        <p>You have successfully logged in.</p>
        <a href="logout.php" class="logout">Logout</a>
    </div>
</body>
</html>