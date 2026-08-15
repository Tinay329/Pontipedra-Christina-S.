<?php
session_start();
// Restrict access to logged‑in users only
if (!isset($_SESSION['student_id']) || empty($_SESSION['student_id'])) {
    header("Location: index.html");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Welcome</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; padding: 50px; background: #f0f8ff; }
        .card { background: white; padding: 40px; border-radius: 16px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); display: inline-block; }
        h2 { color: #2c3e50; margin-bottom: 15px; }
        p { color: #555; font-size: 16px; margin-bottom: 25px; }
        .logout-btn { padding: 10px 25px; background: #e74c3c; color: white; border-radius: 30px; text-decoration: none; transition: 0.3s; }
        .logout-btn:hover { background: #c0392b; }
    </style>
</head>
<body>
    <div class="card">
        <h2>Welcome, <?php echo htmlspecialchars($_SESSION['full_name']); ?>!</h2>
        <p>Student ID: <?php echo htmlspecialchars($_SESSION['student_id']); ?></p>
        <p>You are successfully logged into the School System.</p>
        <a href="logout.php" class="logout-btn">Logout</a>
    </div>
</body>
</html>