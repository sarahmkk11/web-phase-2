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
$firstName = isset($_POST['first_name']) ? $_POST['firs_name'] : '';
$lastName = isset($_POST['last_name']) ? $_POST['last_name'] : '';
$age = isset($_POST['age']) ? $_POST['age'] : '';
$gender = isset($_POST['gender']) ? $_POST['gender'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$phone = isset($_POST['phone']) ? $_POST['phone'] : '';
$city = isset($_POST['city']) ? $_POST['city'] : '';
$shortBio = isset($_POST['short-bio']) ? $_POST['short-bio'] : '';

// Check if file is uploaded
if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
    // Handle file upload
    $photoName = $_FILES['photo']['name'];
    $photoTmpName = $_FILES['photo']['tmp_name'];
    $photoSize = $_FILES['photo']['size'];
    $photoError = $_FILES['photo']['error'];

    // Check if file is actually uploaded
    if (is_uploaded_file($photoTmpName)) {
        // Move uploaded file to desired location
        $photoDestination = 'uploads/' . $photoName;
        if (!move_uploaded_file($photoTmpName, $photoDestination)) {
            echo "Error moving file to destination";
            exit(); // Exit script
        }
    } else {
        echo "Error uploading file";
        exit(); // Exit script
    }
} else {
    // No file uploaded
    $photoDestination = ''; // Set to empty string
}

// Check if email already exists
$stmt_check_email = $conn->prepare("SELECT * FROM language_partners WHERE email=?");
$stmt_check_email->bind_param("s", $email);
$stmt_check_email->execute();
$result = $stmt_check_email->get_result();

// If email already exists, show an alert to the user
if ($result->num_rows > 0) {
    // Redirect back to the signup page with an error message
    header("Location: SignUpNF.php?error=Email%20already%20exists.%20Please%20use%20a%20different%20email.");
    exit(); // Exit script
} else {
    // Hash the password before storing it
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Prepare SQL statement to insert data into the database
    $stmt = $conn->prepare("INSERT INTO language_partners (first_name, last_name, age, gender, email, password, photo, phone, city, bio) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssisssssss", $firstName, $lastName, $age, $gender, $email, $hashedPassword, $photoDestination, $phone, $city, $shortBio);

    // Execute the statement
    if ($stmt->execute()) {
        // Redirect to login page
        header("Location: loginN.html");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}

// Close connection
$stmt_check_email->close();
$stmt->close();
$conn->close();
?>
