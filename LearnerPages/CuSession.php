<?php
session_start(); // Start session to retrieve user's email
$user_email = $_SESSION['email']; // Assuming you have stored user's email in a session variable

// Establish a connection to the MySQL database
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

$current_time = date("Y-m-d H:i:s");

// Fetch data from the 'request' table for sessions that haven't finished
$sql = "SELECT * FROM request WHERE 
        (TIMESTAMPADD(MINUTE, session_duration, schedule_Time) > '$current_time') AND 
         language_Learner_email = '$user_email'";
$result = $conn->query($sql);

// Check if any rows are returned
if ($result->num_rows > 0) {
    // Loop through each row
    while($row = $result->fetch_assoc()) {
        // Generate HTML for each session
        echo "<div class='session'>";
        echo "<h2>Language: " . $row['language'] . "</h2>";
        echo "<p>Level: " . $row['level'] . "</p>";
        echo "<p>Schedule Time: " . $row['schedule_Time'] . "</p>";
        echo "<p>Session Duration: " . $row['session_duration'] . "</p>";

        // Add Delete and Continue session buttons
        echo "<div class='btn-container'>";
        echo "<button class='btn-delete' onclick='location.href=\"delete_session.php?session_id=" . $row['SessionID'] . "\"'>Delete Session</button>";
        echo "<button class='btn-continue' onclick='location.href=\"https://www.youtube.com/watch?v=your_video_id_here\"'>Continue Session</button>";
        echo "</div>";

        echo "</div>"; // session div
    }
} else {
    echo "No sessions found.";
}
$conn->close();
?>
