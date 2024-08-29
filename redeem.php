<?php
// redeem.php
session_start();

// Mock student ID for demonstration (in reality, you would get this from a login system)
$student_id = 1;

$code_error = ''; // Variable to hold error message
$code_class = ''; // Variable to set CSS class for the input field

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $code = $_POST['code'];

    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'student_rewards');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Validate code and process redemption
    $valid_codes = ['validcode']; // Define valid codes (you can expand this array)

    if (in_array($code, $valid_codes)) {
        // Code is valid, perform redemption logic
        $sql = "UPDATE students SET points = points + 10 WHERE id=$student_id";

        if ($conn->query($sql) === TRUE) {
            header("Location: student.php?success=1");
            exit();
        } else {
            header("Location: student.php?error=update");
            exit();
        }
    } else {
        // Invalid code
        header("Location: student.php?error=invalid&code=" . urlencode($code));
        exit();
    }

    $conn->close();
}
