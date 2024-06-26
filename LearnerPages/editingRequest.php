<?php
session_start();


$servername= "localhost";
$username= "root" ;
$password= "";
$dbname= "projectdb" ;
$connection= mysqli_connect($servername,$username,$password,$dbname);
$database= mysqli_select_db($connection, $dbname);
// Check the connection
if (!$connection) 
die("Connection failed: ".mysqli_connect_error());

$email =  $_SESSION['email'];
if(isset($_GET['id'])){
       $id2 = mysqli_real_escape_string($connection,$_GET['id']);
   $sql = "SELECT 'language', 'level',' start_date', 'duration', 'language_learner_email', 'language_partner_email' FROM  `request` WHERE `username` = '$id2'";
   $result = mysqli_query($connection,  $sql);
   $valu = mysqli_num_rows($result);
}

   

?>


<!DOCTYPE html>
<html>



<!---------------------HEAD---------------------------->
<head>

    <meta charset="UTF-8" />
    <title>Talk Tandem | Home </title>
    <meta name="description" content="welcome to talk tandem , Learn with JOY" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"><!--Setting the viewport to make your website look good on all devices:-->
    <meta name="keywords" content="Learn, Languages, education ">
    <link rel="stylesheet" hreflink rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous"="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'> <!--to use icons -->
    <link rel="shortcut icon" href="../homePage/Logo white .jpeg" type="image/x-icon">
    <link rel="stylesheet" href="HomePageLerner.css">
    <link rel="stylesheet" href="PostRequest.css">

</head>


<!---------------------BODY---------------------------->

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
            <a href="HomePageLerner.php">View</a>
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



    <!--      Form       -->

    
    <h1 class="text">Edit your Request </h1>
	<div class="container">
        
        <form>
          <label for="lang">Choose language:</label>
          <input class="lang" list="language" name="lang" placeholder="Choose" value="English" readonly>
          <datalist id="language">
            <option value="English" >
            <option value="Spanish">
            <option value="French">
            <option value="Chinese">
            <option value="Italian">
            <option value="Korean">
            <option value="Russian">
            <option value="Japanese">
            <option value="Other">
          </datalist>
          
          <label>Choose your level:</label>
          <div class="level-container">
            <div>
              <input  id="level1" type="radio" name="level">
              <label for="level1">Beginner</label>
              
            </div>
            <div>
              <input  id="level2" type="radio" name="level">
              <label for="level2">Pre-intermediate</label>
              
            </div>
            <div>
              <input  id="level3" type="radio" name="level" value="fixed" checked>
              <label for="level3">Intermediate</label>
              
            </div>
            <div>
              <input  id="level4" type="radio" name="level" >
              <label for="level4">Upper-Intermediate</label>
              
            </div>
            <div>
              <input  id="level5" type="radio" name="level">
              <label for="level5">Advanced</label>
              
            </div>
          </div>
      
          <label for="start-date">When do you want to start learning:</label>
          <input type="datetime-local" >
      
          <label for="duration">Choose course duration:</label>
          <select disabled name="duration" id="duration">
            <option value="fixed">30 munits</option>
            <option value="2"selected>1 hour</option>
            <option value="3">1:30 hour</option>
            <option value="4">2 hour</option>
          </select>
      
          <button type="submit" class="btn" name="Save_Changes">Save Changes</button>
         </form>  
        </div>
        
<!--    footer    -->
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
