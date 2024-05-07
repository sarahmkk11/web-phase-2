<?php

session_start(); 
if(!isset($_SESSION['email']))
header("Location:../homePage/loginLF.php?error=Please Sign In again!");

 

 
$email=$_SESSION['email'];
$dsn = 'mysql:dbname=projectdb;host=127.0.0.1;port=3306;';
$user = 'root';
$password = '';
$db = new PDO($dsn, $user, $password);
$select_query="select * from book where language_learners_email='$email' ";
$stmt=$db->prepare($select_query);
$resobj=$stmt->execute([]);
 





?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
    <meta name="description" content="hi languege speaker! what do you whant to do ?" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"><!--Setting the viewport to make your website look good on all devices:-->
    <meta name="keywords" content="Learn, Languages, education ">
    <link rel="stylesheet" hreflink rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous"="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'> <!--to use icons -->
    <link rel="shortcut icon" href="..//homePage/Logo white .jpeg" type="image/x-icon">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="CuSessionN.css">

    <title> View My Sessions</title>
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
                    <li><a href="PartnerList.php?allmessages">messages</a></li>
                    <li class="dropdown">
                        <a href="#">Request</a>
                        <div class="dropdown-content">
                            <a href="HomePageLerner.html#new-Request">New</a>
                            <a href="HomePageLerner.html#Current">Current</a>
                        </div> 
                    </li>
                    <li class="dropdown">
                    <a href="#">View</a>
                    <div class="dropdown-content">
                        <a href="mybook.php">My Booked Session</a>
                        <a href="PartnerList.php">Language Partners</a>
                        <a href="PreviousSession.html">Previous Session</a>
                        <a href="CuSession.html">Current Session</a>
                        <a href="RateReviews .html">Rate and review</a>
                    </div>
                    </li>
                    
                  
                    <li><a href="LearnerProfile.php">Manage Profile</a></li>
             
             <li><a href="signOutL.php">Sign Out</a></li>
                </ul> 
            </nav>
            
        </header>
                
<div class="container">
    <h1>My Sessions</h1>

<?php 
if($stmt->rowCount()>0)
{
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

    $select_query_data="select * from partnersesession where Id={$row['partnersesession_id']} ";
    $stmt_data=$db->prepare($select_query_data);
    $resobj=$stmt_data->execute([]);
    $row_data = $stmt_data->fetch(PDO::FETCH_ASSOC);
    $select_query_data_partner="select * from language_partners where email='{$row['language_partners_email']}' ";
    $stmt_data_partner=$db->prepare($select_query_data_partner);
    $resobj=$stmt_data_partner->execute([]);
    $row_data_partner = $stmt_data_partner->fetch(PDO::FETCH_ASSOC);
        echo "<div class=''style='
        margin-bottom: 20px;
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 8px;
        background-color: #f5f5f5
        '>
            <div class='session-info'>
                <h3>{$row_data_partner['first_name']}  {$row_data_partner['last_name']}</h3>
                <p><strong>Language:</strong> {$row_data['Teacheslanguges']} </p>
                <p><strong>Date:</strong> {$row_data['datesession']}</p>
                <p><strong>Duration:</strong> {$row_data['SessionDuration']} hour </p>
            </div>
            
        </div>";


        }
        }else{
            echo  "<h1>no Session Booked</h1>";


        }
            
?>

</div>


        
    <!-- Include Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>

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
