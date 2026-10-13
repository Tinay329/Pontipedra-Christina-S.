<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Arial, Helvetica, sans-serif;
        }
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .container {
            width: 100%;
            max-width: 420px;
            padding: 35px 30px;
            background: white;
            border-radius: 30px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.2);
        }
        h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #333;
        }
        .input-group {
            position: relative;
            margin-bottom: 20px;
        }
        .input-group input {
            width: 100%;
            padding: 12px 18px;
            border-radius: 30px;
            font-size: 15px;
            border: 1px solid #ccc;
            outline: none;
        }
        .input-group input:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.2);
        }
        .toggle-pass {
            position: absolute;
            right: 18px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #555;
            font-size: 14px;
        }
        .row-group {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 14px;
            margin-bottom: 20px;
            color: #555;
        }
        .row-group a {
            color: #667eea;
            text-decoration: none;
        }
        .login-btn {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            font-weight: bold;
            border: none;
            border-radius: 30px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            cursor: pointer;
            transition: 0.3s;
        }
        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(102, 126, 234, 0.35);
        }
        .error-banner {
            background-color: #fde8e8;
            color: #c81e1e;
            padding: 10px;
            border-radius: 10px;
            margin-bottom: 18px;
            text-align: center;
            font-size: 14px;
        }
        .register-link {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #555;
        }
        .register-link a {
            color: #667eea;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Login</h2>

        <?php if (isset($_GET['error'])): ?>
            <div class="error-banner">Maling Username o Password!</div>
        <?php endif; ?>

        <!-- Form papunta sa pakicheck.php -->
        <form action="pakicheck.php" method="POST">
            <div class="input-group">
                <input type="text" name="username" placeholder="Enter Username" required>
            </div>

            <div class="input-group">
                <input type="password" name="password" id="password" placeholder="Enter Password" required>
                <span class="toggle-pass" onclick="togglePassword()">Show</span>
            </div>

            <div class="row-group">
                <label><input type="checkbox" name="remember"> Remember Me</label>
                <a href="#">Forgot Password?</a>
            </div>

            <button type="submit" class="login-btn">Login</button>
        </form>

        <div class="register-link">
            Don't have an account? <a href="#">Register Here</a>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passField = document.getElementById('password');
            const toggleText = document.querySelector('.toggle-pass');
            if (passField.type === 'password') {
                passField.type = 'text';
                toggleText.textContent = 'Hide';
            } else {
                passField.type = 'password';
                toggleText.textContent = 'Show';
            }
        }
    </script>
</body>
</html>