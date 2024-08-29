<?php
session_start();

if (!isset($_SESSION['student_id'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}

// Retrieve student ID from session
$student_id = $_SESSION['student_id'];

// Database connection
$conn = new mysqli('localhost', 'root', '', 'student_rewards');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT name, school_id_number, points FROM students WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $student_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $student = $result->fetch_assoc();
} else {
    // Set default values if no student is found
    $student = [
        'name' => 'Unknown',
        'school_id_number' => 'N/A',
        'points' => 0
    ];
}

$stmt->close();
$conn->close();

// Handle errors or success messages
$code_error = '';
$code_class = '';
$code_value = '';
if (isset($_GET['error'])) {
    if ($_GET['error'] == 'invalid') {
        $code_error = 'Invalid code. Please try again.';
        $code_class = 'error';
        $code_value = htmlspecialchars($_GET['code']); // Maintain the input value
    } elseif ($_GET['error'] == 'update') {
        $code_error = 'Error updating record. Please try again.';
        $code_class = 'error';
    }
} elseif (isset($_GET['success'])) {
    $code_error = 'Code redeemed successfully. Points added.';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Page</title>
    <link rel="stylesheet" href="studentstyles.css">
    <style>
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background-color: #f0f0f0;
        }
        .logout-button {
            padding: 8px 16px;
            background-color: #f44336;
            color: white;
            border: none;
            cursor: pointer;
        }
        .error {
            border-color: red;
        }
        .error-message {
            color: red;
            font-size: 14px;
        }
    </style>
    <script>
        function confirmAction(action) {
            var confirmMessage = "";
            if (action === 'charge') {
                confirmMessage = "Are you sure you want to use 1 point for this charge?";
            } else if (action === 'wifi') {
                confirmMessage = "Are you sure you want to use 1 point for WiFi?";
            }

            if (confirmMessage && confirm(confirmMessage)) {
                // Proceed with the action logic here if confirmed
                alert(action.charAt(0).toUpperCase() + action.slice(1) + " completed successfully!");
                // You can add further logic here if needed
            } else {
                // Do something if user cancels (optional)
                alert(action.charAt(0).toUpperCase() + action.slice(1) + " canceled.");
            }
        }
    </script>
</head>
<body>
    <div class="header">
        <h2>Welcome, <?php echo htmlspecialchars($student['name']); ?>!</h2>
        <button onclick="location.href='logout.php'" class="logout-button">Log Out</button>
    </div>
    <div class="info">
        <p>Name: <?php echo htmlspecialchars($student['name']); ?></p>
        <p>School ID No.: <?php echo htmlspecialchars($student['school_id_number']); ?></p>
        <p>Your Points: <?php echo htmlspecialchars($student['points']); ?></p>
    </div>
  
    <div id="reward-options">
        <button onclick="confirmAction('charge')">Charge</button>
        <button onclick="confirmAction('wifi')">WiFi</button>
    </div>
    <form method="post" action="redeem.php">
        <label for="code">Redeem Code:</label>
        <input type="text" id="code" name="code" class="<?php echo htmlspecialchars($code_class); ?>" value="<?php echo htmlspecialchars($code_value); ?>" required>
        <?php if (!empty($code_error)) : ?>
            <p class="error-message"><?php echo htmlspecialchars($code_error); ?></p>
        <?php endif; ?>
        <button type="submit">Redeem</button>
    </form>
</body>
</html>
