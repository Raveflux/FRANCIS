<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$token = $_GET['token'] ?? '';
$error_message = '';
$success_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate token
    if (empty($token)) {
        $error_message = "Invalid token.";
    } elseif (strlen($password) < 5) {
        $error_message = "Password must contain at least 5 characters.";
    } elseif ($password !== $confirm_password) {
        $error_message = "Passwords do not match.";
    } else {
        // Database connection
        $conn = new mysqli('localhost', 'root', '', 'student_rewards');

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Check token validity
        $sql = "SELECT id FROM students WHERE reset_token = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $token);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $student_id = $row['id'];

            // Hash and update password
            $password = password_hash($password, PASSWORD_DEFAULT);
            $sql = "UPDATE students SET password = ?, reset_token = NULL WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('si', $password, $student_id);
            $stmt->execute();

            $success_message = "Your password has been updated successfully.";
        } else {
            $error_message = "Invalid or expired token.";
        }

        $stmt->close();
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="regstyles.css">
</head>
<body>
    <h2>Reset Password</h2>
    <?php if (!empty($error_message)) : ?>
        <p class="error-text"><?php echo $error_message; ?></p>
    <?php endif; ?>
    <?php if (!empty($success_message)) : ?>
        <p class="success-text"><?php echo $success_message; ?></p>
    <?php endif; ?>
    <form method="post" action="reset_password.php?token=<?php echo htmlspecialchars($token); ?>">
        <label for="password">New Password:</label>
        <input type="password" id="password" name="password" required><br>

        <label for="confirm_password">Confirm Password:</label>
        <input type="password" id="confirm_password" name="confirm_password" required><br>

        <button type="submit">Reset Password</button>
    </form>
</body>
</html>
