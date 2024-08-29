<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$username_error = '';
$school_id_error = '';
$school_id_format_error = '';
$password_error = '';
$password_match_error = '';
$age_error = '';
$success_message = '';

$name = '';
$age = '';
$school_id_number = '';
$username = '';
$password = '';
$confirm_password = ''; // New variable for confirm password

const SCHOOL_ID_PREFIX = 'SCC-';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $age = $_POST['age'];
    $school_id_number = $_POST['school_id_number'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password']; // Get confirm password value

    // Validate age
    if ($age < 16) {
        $age_error = "You must be 16 years old or above";
    }

    // Validate school ID number format
    if (!preg_match('/^' . preg_quote(SCHOOL_ID_PREFIX, '/') . '\d{2}-\d+$/', $school_id_number)) {
        $school_id_format_error = "School ID Number must start with '" . SCHOOL_ID_PREFIX . "' and be in the format 'SCC-xx-xxxx'";
    }

    // Validate password length and match
    if (strlen($password) < 5) {
        $password_error = "Password must contain at least 5 characters";
    } elseif ($password !== $confirm_password) {
        $password_match_error = "Passwords do not match";
    } else {
        $password = password_hash($password, PASSWORD_DEFAULT);
    }

    // Database connection
    if (empty($age_error) && empty($school_id_format_error) && empty($password_error) && empty($password_match_error)) {
        $conn = new mysqli('localhost', 'root', '', 'student_rewards');

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Check if username already exists
        $sql = "SELECT id FROM students WHERE username = '$username'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $username_error = "Username already exists";
        }

        // Check if school ID number already exists
        $sql = "SELECT id FROM students WHERE school_id_number = '$school_id_number'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $school_id_error = "School ID Number already exists";
        }

        if (empty($username_error) && empty($school_id_error)) {
            $sql = "INSERT INTO students (name, age, school_id_number, username, password) VALUES ('$name', '$age', '$school_id_number', '$username', '$password')";

            if ($conn->query($sql) === TRUE) {
                $success_message = "New record created successfully";
            } else {
                $success_message = "Error: " . $sql . "<br>" . $conn->error;
            }
        }

        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="regstyles.css">
 
    <script>
        function validateForm() {
            var schoolId = document.getElementById('school_id_number').value;
            var age = document.getElementById('age').value;
            var password = document.getElementById('password').value;
            var confirmPassword = document.getElementById('confirm_password').value;
            var regex = /^SCC-\d{2}-\d+$/;
            var schoolIdErrorField = document.getElementById('school_id_format_error');
            var passwordErrorField = document.getElementById('password_error');
            var confirmPasswordErrorField = document.getElementById('confirm_password_error');
            var ageErrorField = document.getElementById('age_error');

            var valid = true;

            if (!regex.test(schoolId)) {
                schoolIdErrorField.textContent = "School ID Number must start with 'SCC-' and be in the format 'SCC-xx-xxxx'";
                schoolIdErrorField.style.display = "block";
                valid = false;
            } else {
                schoolIdErrorField.style.display = "none";
            }

            if (password.length < 5) {
                passwordErrorField.textContent = "Password must contain at least 5 characters";
                passwordErrorField.style.display = "block";
                valid = false;
            } else {
                passwordErrorField.style.display = "none";
            }

            if (password !== confirmPassword) {
                confirmPasswordErrorField.textContent = "Passwords do not match";
                confirmPasswordErrorField.style.display = "block";
                valid = false;
            } else {
                confirmPasswordErrorField.style.display = "none";
            }

            if (age < 16) {
                ageErrorField.textContent = "You must be 16 years old or above";
                ageErrorField.style.display = "block";
                valid = false;
            } else {
                ageErrorField.style.display = "none";
            }

            return valid;
        }
    </script>
</head>
<body>
    <div class="register-container">
        <h2>Register</h2>
        <form method="post" action="register.php" onsubmit="return validateForm();">
            <?php if (!empty($success_message)) : ?>
                <div class="message success"><?php echo $success_message; ?></div>
            <?php endif; ?>

            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" required><br>

            <label for="age">Age:</label>
            <input type="number" id="age" name="age" value="<?php echo htmlspecialchars($age); ?>" required><br>
            <?php if (!empty($age_error)) : ?>
                <p class="error-text" id="age_error"><?php echo $age_error; ?></p>
            <?php else : ?>
                <p class="error-text" id="age_error" style="display: none;"></p>
            <?php endif; ?>

            <label for="school_id_number">School ID Number:</label>
            <input type="text" id="school_id_number" name="school_id_number" value="<?php echo htmlspecialchars($school_id_number); ?>" class="<?php echo !empty($school_id_error) || !empty($school_id_format_error) ? 'error' : ''; ?>" required><br>
            <?php if (!empty($school_id_error)) : ?>
                <p class="error-text"><?php echo $school_id_error; ?></p>
            <?php endif; ?>
            <?php if (!empty($school_id_format_error)) : ?>
                <p class="error-text" id="school_id_format_error"><?php echo $school_id_format_error; ?></p>
            <?php else : ?>
                <p class="error-text" id="school_id_format_error" style="display: none;"></p>
            <?php endif; ?>

            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>" class="<?php echo !empty($username_error) ? 'error' : ''; ?>" required><br>
            <?php if (!empty($username_error)) : ?>
                <p class="error-text"><?php echo $username_error; ?></p>
            <?php endif; ?>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" class="<?php echo !empty($password_error) ? 'error' : ''; ?>" required><br>
            <?php if (!empty($password_error)) : ?>
                <p class="error-text" id="password_error"><?php echo $password_error; ?></p>
            <?php else : ?>
                <p class="error-text" id="password_error" style="display: none;"></p>
            <?php endif; ?>

            <label for="confirm_password">Confirm Password:</label>
            <input type="password" id="confirm_password" name="confirm_password" class="<?php echo !empty($password_match_error) ? 'error' : ''; ?>" required><br>
            <?php if (!empty($password_match_error)) : ?>
                <p class="error-text" id="confirm_password_error"><?php echo $password_match_error; ?></p>
            <?php else : ?>
                <p class="error-text" id="confirm_password_error" style="display: none;"></p>
            <?php endif; ?>

            <button type="submit">Register</button>
        </form>
       
        <a href="login.php">Log in</a> <!-- Added Login link here -->
    </div>
</body>
</html>
