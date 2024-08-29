<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

$error_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];

    // Hardcoded admin credentials
    if ($username === 'admin' && $password === 'admin2580') {
        $_SESSION['admin'] = true;
        header("Location: admin.php"); // Redirect to admin page
        exit();
    }

    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'student_rewards');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT id, password FROM students WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        if (password_verify($password, $row['password'])) {
            // Password is correct
            $_SESSION['student_id'] = $row['id'];
            header("Location: student.php"); // Redirect to student page
            exit();
        } else {
            $error_message = "Invalid username or password.";
        }
    } else {
        $error_message = "Invalid username or password.";
    }

    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="regstyles.css">
    <style>
        .container {
            display: flex;
            max-width: 1000px;
            margin: 0 auto;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .leftdiv {
            flex: 1;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
        }
        .leftdiv img {
            width: 100%;
            height: 100%;
        }
        .login-container {
            flex: 1;
            padding: 20px;
            background-color: #fff;
        }
        .error-text {
            color: red;
        }
        a {
            color: #007bff;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="leftdiv">
            <img src="wifi.jpg" alt="Description of the image">
        </div>
        <div class="login-container">
            <h2>Login</h2>
            <br>
            <?php if (!empty($error_message)) : ?>
                <p class="error-text"><?php echo $error_message; ?></p>
            <?php endif; ?>
            <form method="post" action="login.php">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required><br><br>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required><br><br>

                <button type="submit">Login</button>
            </form>
            <br>
            <a href="register.php">Register</a> <br>
            <a href="forgot_password.php">Forgot Password?</a>
        </div>
    </div>
</body>
</html>
