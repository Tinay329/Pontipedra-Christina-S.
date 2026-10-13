<?php
session_start();
require_once 'db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.html");
    exit();
}

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Handle the update form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $firstname = trim($_POST['firstname']);
    $lastname = trim($_POST['lastname']);

    if (!empty($firstname) && !empty($lastname) && $id > 0) {
        $stmt = $conn->prepare("UPDATE students SET firstname = ?, lastname = ? WHERE id = ?");
        $stmt->bind_param("ssi", $firstname, $lastname, $id);
        $stmt->execute();
        $stmt->close();

        header("Location: dashboard.php?msg=updated");
        exit();
    }
}

// Fetch existing record to populate the form
$stmt = $conn->prepare("SELECT * FROM students WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();
$stmt->close();

if (!$student) {
    header("Location: dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student - Student Management System</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Arial, Helvetica, sans-serif;
        }
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        .edit-card {
            background: #fff;
            width: 100%;
            max-width: 420px;
            padding: 35px 30px;
            border-radius: 24px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
        }
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 25px;
        }
        .input-group {
            margin-bottom: 20px;
        }
        .input-group label {
            display: block;
            margin-bottom: 6px;
            color: #555;
            font-size: 14px;
            font-weight: bold;
        }
        .input-group input {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #ccc;
            border-radius: 25px;
            font-size: 15px;
            outline: none;
            transition: 0.3s;
        }
        .input-group input:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.25);
        }
        .btn-update {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 25px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: transform 0.2s;
        }
        .btn-update:hover {
            transform: translateY(-2px);
        }
        .cancel-link {
            display: block;
            text-align: center;
            margin-top: 15px;
            color: #777;
            text-decoration: none;
            font-size: 14px;
        }
        .cancel-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="edit-card">
        <h2>Edit Student</h2>
        <form method="POST" action="update.php">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($student['id']); ?>">
            
            <div class="input-group">
                <label>First Name</label>
                <input type="text" name="firstname" value="<?php echo htmlspecialchars($student['firstname']); ?>" required>
            </div>

            <div class="input-group">
                <label>Last Name</label>
                <input type="text" name="lastname" value="<?php echo htmlspecialchars($student['lastname']); ?>" required>
            </div>

            <button type="submit" class="btn-update">Save Changes</button>
            <a href="dashboard.php" class="cancel-link">Cancel</a>
        </form>
    </div>

</body>
</html>