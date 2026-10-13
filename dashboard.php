<?php
session_start();
require_once 'db.php';

// Authentication Guard: Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.html");
    exit();
}

// Handle Add Student
$message = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_student'])) {
    $firstname = trim($_POST['firstname']);
    $lastname = trim($_POST['lastname']);

    if (!empty($firstname) && !empty($lastname)) {
        $stmt = $conn->prepare("INSERT INTO students (firstname, lastname) VALUES (?, ?)");
        $stmt->bind_param("ss", $firstname, $lastname);
        if ($stmt->execute()) {
            $message = "Student added successfully!";
        } else {
            $message = "Error adding student.";
        }
        $stmt->close();
    } else {
        $message = "All fields are required.";
    }
}

// Handle Delete Student
if (isset($_GET['delete'])) {
    $delete_id = intval($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM students WHERE id = ?");
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();
    $stmt->close();
    header("Location: dashboard.php");
    exit();
}

// Fetch all students
$studentsResult = $conn->query("SELECT * FROM students ORDER BY id DESC");

// Fetch statistics
$totalStudents = $conn->query("SELECT COUNT(*) AS total FROM students")->fetch_assoc()['total'];
$totalUsers = $conn->query("SELECT COUNT(*) AS total FROM users")->fetch_assoc()['total'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management System - Dashboard</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Arial, Helvetica, sans-serif;
        }
        body {
            background-color: #f4f6fc;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        /* Top Navigation */
        .navbar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #fff;
            padding: 18px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        .navbar h1 {
            font-size: 22px;
            letter-spacing: 0.5px;
        }
        .navbar .user-info {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        .navbar .user-info span {
            font-size: 15px;
        }
        .btn-logout {
            background: #ff5e62;
            color: white;
            padding: 8px 18px;
            border-radius: 20px;
            text-decoration: none;
            font-size: 14px;
            font-weight: bold;
            transition: 0.3s;
        }
        .btn-logout:hover {
            background: #d63031;
        }

        /* Dashboard Container */
        .container {
            max-width: 1100px;
            margin: 40px auto;
            padding: 0 20px;
            width: 100%;
        }

        /* Stat Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .stat-card {
            background: #fff;
            padding: 24px;
            border-radius: 18px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            border-top: 5px solid #667eea;
        }
        .stat-card h3 {
            font-size: 14px;
            color: #777;
            text-transform: uppercase;
            margin-bottom: 8px;
        }
        .stat-card p {
            font-size: 28px;
            font-weight: bold;
            color: #333;
        }

        /* Content Sections */
        .content-card {
            background: #fff;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
        }
        .content-card h2 {
            font-size: 20px;
            color: #333;
            margin-bottom: 20px;
            border-bottom: 2px solid #f0f0f0;
            padding-bottom: 10px;
        }

        /* Form Controls */
        .form-row {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }
        .form-row input {
            flex: 1;
            min-width: 200px;
            padding: 12px 18px;
            border-radius: 25px;
            border: 1px solid #ccc;
            font-size: 15px;
            outline: none;
        }
        .form-row input:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.2);
        }
        .btn-submit {
            padding: 12px 28px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 25px;
            font-weight: bold;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.35);
        }

        /* Table */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table th, table td {
            text-align: left;
            padding: 14px 16px;
            border-bottom: 1px solid #f0f0f0;
            font-size: 15px;
        }
        table th {
            background-color: #fbfbfd;
            color: #555;
            font-weight: 600;
        }
        .btn-delete {
            color: #e74c3c;
            text-decoration: none;
            font-weight: bold;
        }
        .btn-delete:hover {
            text-decoration: underline;
        }

        /* Alerts */
        .alert {
            padding: 12px 18px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-size: 14px;
            background-color: #d4edda;
            color: #155724;
        }
    </style>
</head>
<body>

    <!-- Header Navigation -->
    <header class="navbar">
        <h1>Student Management System</h1>
        <div class="user-info">
            <span>Welcome, <strong><?php echo htmlspecialchars($_SESSION['full_name']); ?></strong></span>
            <a href="logout.php" class="btn-logout">Logout</a>
        </div>
    </header>

    <main class="container">
        <!-- Stat Cards -->
        <div class="stats-grid">
            <div class="stat-card">
                <h3>Total Students</h3>
                <p><?php echo $totalStudents; ?></p>
            </div>
            <div class="stat-card" style="border-top-color: #764ba2;">
                <h3>Active Staff Users</h3>
                <p><?php echo $totalUsers; ?></p>
            </div>
        </div>

        <?php if (!empty($message)): ?>
            <div class="alert"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>

        <!-- Add Student Form -->
        <section class="content-card">
            <h2>Add New Student</h2>
            <form method="POST" action="insert.php" class="form-row">
    <input type="text" name="firstname" placeholder="First Name" required>
    <input type="text" name="lastname" placeholder="Last Name" required>
    <button type="submit" class="btn-submit">Add Student</button>
</form>
        </section>

        <!-- Student Records Table -->
        <section class="content-card">
            <h2>Student Directory</h2>
            <table>
                <thead>
                    <tr>
                        <th style="width: 100px;">ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th style="width: 120px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($studentsResult && $studentsResult->num_rows > 0): ?>
                        <?php while ($row = $studentsResult->fetch_assoc()): ?>
                            <tr>
                                <td>#<?php echo htmlspecialchars($row['id']); ?></td>
                                <td><?php echo htmlspecialchars($row['firstname']); ?></td>
                                <td><?php echo htmlspecialchars($row['lastname']); ?></td>
                                <td>
    <a href="update.php?id=<?php echo $row['id']; ?>" style="color: #667eea; font-weight: bold; text-decoration: none; margin-right: 12px;">Edit</a>
    <a href="delete.php?id=<?php echo $row['id']; ?>" class="btn-delete" onclick="return confirm('Are you sure you want to delete this student?');">Delete</a>
    <a href="logout.php" class="btn-logout">Logout</a>
</td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" style="text-align: center; color: #999; padding: 25px;">
                                No student records found. Add your first student above.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </section>
    </main>

</body>
</html>