<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "projectdb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Test database connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Database connected successfully";
}

// Get form data
$email = isset($_POST['Email']) ? $_POST['Email'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

// Prepare SQL statement to check if the email exists and retrieve the user's name
$sql = "SELECT * FROM language_learners WHERE email=?";
$stmt = $conn->prepare($sql);
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
        header("Location: ../LearnerPages/HomePageLerner.php");
        exit();
    } else {
        // Password is incorrect
        echo "Incorrect password";
    }
} else {
    // Email is not registered
    echo "Email not registered";
}

// Close connection
$stmt->close();
$conn->close();
?>
