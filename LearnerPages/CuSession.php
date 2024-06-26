<?php
session_start(); 
$user_email = $_SESSION['email']; 


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "projectdb";


$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$current_time = date("Y-m-d H:i:s");

$sql = "SELECT * FROM request WHERE 
        (TIMESTAMPADD(MINUTE, session_duration, schedule_Time) > '$current_time') AND 
         language_Learner_email = '$user_email'";
$result = $conn->query($sql);


if ($result->num_rows > 0) {
  
    while($row = $result->fetch_assoc()) {
 
        echo "<div class='session'>";
        echo "<h2>Language: " . $row['language'] . "</h2>";
        echo "<p>Level: " . $row['level'] . "</p>";
        echo "<p>Schedule Time: " . $row['schedule_Time'] . "</p>";
        echo "<p>Session Duration: " . $row['session_duration'] . "</p>";

        
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="hi language speaker! what do you want to do?">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="Learn, Languages, education">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="CuSession.css">
    <style>
        .btn-delete {
            background-color: #f44336;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            margin-right: 10px;
        }
        .btn-delete:hover {
            background-color: #d32f2f;
        }
        .btn-continue {
            background-color: #4caf50;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn-continue:hover {
            background-color: #388e3c;
        }
        .progress-bar {
            background-color: #4caf50; /* Green */
            height: 5px;
            margin-top: 5px;
            position: relative;
        }
        .progress-result {
            position: absolute;
            top: 100%;
            left: 0;
            width: 100%;
            text-align: center;
            font-size: 14px;
            color: #333;
            margin-top: 5px;
        }
    </style>
    <title>View Current Sessions</title>
</head>
<body>
    <header>
    <div class="logo">
            <img src="../homePage/logo bule.jpeg">
            <h1>Talk Tandem</h1>
        </div>

        <nav class="mainMenu">
            <ul>
                <li><a href="HomePageLerner.php">Home</a></li>

                <li class="dropdown">
                    <a href="HomePageLerner.php#Request">Request</a>
                    <div class="dropdown-content">
                        <a href="HomePageLerner.php#new-Request">New</a>
                        <a href="HomePageLerner.php#Current">Current</a>
                    </div> 
                </li>
                <li class="dropdown">
                <a href="#">View</a>
                <div class="dropdown-content">
                    <a href="PartnerList.php">Language Partners</a>
                    <a href="PreviousSession.php">Previous Session</a>
                    <a href="CuSession.php">Current Session</a>
                    <a href="RateReviews.php">Rate and review</a>
                </div>
                </li>
                
                <li><a href="LearnerProfile.php">Manage Profile</a></li>
             
                <li><a href="../homePage/HomePage.php">Sign Out</a></li>
            </ul> 
        </nav>
    </header>

    <div class="container">
    

    </div>

    <footer>
    <div class="social-icons">
      <a href="https://www.facebook.com/talktandem" class="icon facebook"><i class="fab fa-facebook"></i></a>
      <a href="https://www.twitter.com/talktandem" class="icon twitter"><i class="fab fa-twitter"></i></a>
      <a href="https://www.instagram.com/talktandem" class="icon instagram"><i class="fab fa-instagram"></i></a>
      <a href="https://www.linkedin.com/talktandem" class="icon linkedin"><i class="fab fa-linkedin"></i></a>
      <a href="mailto:contact@talktandem.com" class="icon email"><i class="far fa-envelope"></i></a>
    </div>
    <p class="copyright">© 2024 Talk Tandem. All rights reserved.</p>
    </footer>
</body>
</html>
