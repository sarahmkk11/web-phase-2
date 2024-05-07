<?php
// Establish a connection to the MySQL database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "web2";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if session_id is provided in the URL
if(isset($_GET['session_id'])) {
    // Sanitize the input to prevent SQL injection
    $session_id = $conn->real_escape_string($_GET['session_id']);

    // Prepare a DELETE query
    $sql = "DELETE FROM request WHERE SessionID = $session_id";

    // Execute the DELETE query
    if ($conn->query($sql) === TRUE) {
        echo "Session deleted successfully.";
    } else {
        echo "Error deleting session: " . $conn->error;
    }
} else {
    echo "Session ID not provided.";
}

$conn->close();
?>
