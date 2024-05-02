<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "projectdb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$email = isset($_POST['email']) ? $_POST['email'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

// Prepare SQL statement to check if the email exists and retrieve user data
$stmt = $conn->prepare("SELECT * FROM language_partners WHERE email=?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

// Check if the email exists in the database
if ($result->num_rows > 0) {
    // Fetch the user data
    $row = $result->fetch_assoc();
    // Verify the password
    if (password_verify($password, $row['password'])) {
        // Start session
        session_start();
        // Store user's name in the session
        $_SESSION['userName'] = $row['first_name']; // Assuming the first name is stored in the database
        // Redirect to the home page
        header("Location: ../nativePages/HomePageNative.html");
        exit();
    } else {
        // Password is incorrect
        echo "<script>alert('Incorrect password');</script>";
    }
} else {
    // Email is not registered
    echo "<script>alert('Email not registered');</script>";
}

// Close connection
$stmt->close();
$conn->close();
?>
