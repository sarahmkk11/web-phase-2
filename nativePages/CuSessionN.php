<?php
session_start(); ?>                

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Previous Sessions</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="PreviousSessionN.css">
    <style>
        
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
            line-height: 1.6;
        }

        header {
            background: linear-gradient(135deg, #8fe2f5, #858bef);
            width: 100%;
            position: sticky;
            top: 0;
            z-index: 100;
            padding: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            display: flex;
            align-items: center;
        }

        .logo img {
            width: 100px;
            height: auto;
            margin-right: 10px;
        }

        .logo h1 {
            font-size: 24px;
            font-weight: bold;
        }

        nav ul {
            list-style-type: none;
            display: flex;
        }

        nav ul li {
            margin-left: 10px;
        }

        nav ul li a {
            text-decoration: none;
            color: #f3f3f3;
            padding: 5px;
            font-size: 16px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        nav ul li a:hover {
            background-color: #273e81;
            color: #ffffff;
        }

        /* Main Menu */
        .mainMenu {
            top: 10px;
            right: 10px;
        }

        .mainMenu ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            display: flex;
        }

        .mainMenu ul li {
            margin-left: 10px;
            position: relative;
        }

        .mainMenu ul li a {
            text-decoration: none;
            color: #f3f3f3;
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            transition: background-color 0.3s, transform 0.3s;
            display: flex;
            align-items: center;
            position: relative;
        }

        .mainMenu ul li a:hover {
            background-color: #273e81;
            color: #ffffff;
            transform: scale(1.1);
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background: linear-gradient(135deg,#5fc6dd,#6167d3 );  
            min-width: 120px;
            border-radius: 5px;
            z-index: 1;
            top: 100%;
            left: 0;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 10px 0;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s, transform 0.3s;
            transform: translateY(-10px);
        }

        .dropdown:hover .dropdown-content {
            display: block;
            opacity: 1;
            pointer-events: auto;
            transform: translateY(0);
        }

        .dropdown-content a {
            color: #ffffff;
            padding: 10px 20px;
            text-decoration: none;
            display: block;
            transition: background-color 0.3s;
            display: flex;
            align-items: center;
        }

        
        h1 {
            text-align: center;
        }

        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #8a95e4;
            color: #333;
            text-align: center;
        }

        tr:nth-child(even) {
            background-color: #c0c4f8;
        }

        tr:hover {
            background-color: #91dcf9;
        }

       
        footer {
            background: linear-gradient(135deg,#8FE2F5,#858BEF);
            padding: 20px;
            text-align: center;
            transition: background-color 0.3s;
        }

        .social-icons {
            display: flex;
            justify-content: center;
            margin-bottom: 10px;
        }

        .social-icons .icon {
            display: inline-block;
            width: 40px;
            height: 40px;
            background-color: #fff;
            text-align: center;
            line-height: 40px;
            font-size: 18px;
            margin: 0 5px;
            border-radius: 50%;
            transition: background-color 0.3s;
        }

        .social-icons .icon i {
            color:#858BEF ;
        }

        .social-icons .icon:hover {
            background-color:#8FE2F5;
        }

        .social-icons .icon:hover i {
            color: #fff;
        }

        .footer .email {
            color: #555555;
            font-size: 14px;
            margin-bottom: 5px;
        }

        .footer .email a {
            color: #858BEF;
            text-decoration: none;
        }

        .footer .email a:hover {
            text-decoration: underline;
        }

        .footer .copyright {
            color: #555555;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <header>
        <div class="logo">
            <img src="../homePage/logo bule.jpeg" alt="Logo">
            <h1>Talk Tandem</h1>
        </div>

        <nav class="mainMenu">
            <ul>
                <li><a href="HomePageNative.php">Home</a></li>
                <li class="dropdown">
                    <a href="#">Requests</a>
                    <div class="dropdown-content">
                        <a href="LearningRequestList.php">Request List</a>
                        <a href="HomePageNative.php##view_Request">Request Status</a>
                        <a href="HomePageNative.php#Accept-Rej">Learner Requests</a>
                    </div>
                </li>
                <li class="dropdown">
                    <a href="#">View</a>
                    <div class="dropdown-content">
                        <a href="PreviousSessionsN.php">Previous Session</a>
                        <a href="CuSessionN.php">Current Session</a>
                        <a href="viewReviews.php">Reviews</a>
                    </div>
                </li>
                <li><a href="NativeProfile.php">Manage Profile</a></li>
                <li><a href="../homePage/HomePage.php">Sign Out</a></li>
            </ul>
        </nav>
    </header>

    <br>
    <h1>Previous Sessions</h1>
    <?php
$user_email = $_SESSION['email']; 


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "projectdb";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$current_time = date("Y-m-d H:i:s");


$sql = "SELECT *, ADDTIME(schedule_Time, session_duration) AS session_end FROM request WHERE ADDTIME(schedule_Time, session_duration) <= '$current_time' AND language_parters_email = '$user_email'";

$result = $conn->query($sql);


if ($result->num_rows > 0) {
    
    echo "<table>
            <tr>
                <th>Date</th>
                <th>Language</th>
                <th>Duration</th>
                <th>Level</th>
                <th>Rate And Review</th>
            </tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["schedule_Time"] . "</td>";
        echo "<td>" . $row["language"] . "</td>";
        echo "<td>" . $row["session_duration"] . "</td>";
        echo "<td>" . $row["level"] . "</td>";
        echo "<td><a href='RateReviews.php'><button>Rate And Reviews</button></a></td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p>No results</p>";
}


$conn->close();
?>
    
    <footer>
        <div class="social-icons">
            <a href="https://www.facebook.com/talktandem" class="icon facebook"><i class="fab fa-facebook"></i></a>
            <a href="https://www.twitter.com/talktandem" class="icon twitter"><i class="fab fa-twitter"></i></a>
            <a href="https://www.instagram.com/talktandem" class="icon instagram"><i class="fab fa-instagram"></i></a>
            <a href="https://www.linkedin.com/talktandem" class="icon linkedin"><i class="fab fa-linkedin"></i></a>
            <a href="mailto:contact@talktandem.com" class="icon email"><i class="far fa-envelope"></i></a>
        </div>
        <p class="copyright">©️ 2024 Talk Tandem. All rights reserved.</p>
    </footer>
</body>
</html>
