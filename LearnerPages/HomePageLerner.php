<?php 
    session_start();

    if(!isset($_SESSION['userName']))
      header("Location:../homePage/loginLF.php?error=Please Sign In again!");

    else{

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
    <link rel="shortcut icon" href="/homePage/Logo white .jpeg" type="image/x-icon">
    <link rel="stylesheet" href="HomePageLerner.css">
    <link rel="stylesheet" href="styleRequest.css">

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
                <li><a href="#">Home</a></li>
                <li><a href="PartnerList.php?allmessages"> messages </a></li>
                <li class="dropdown">
                    <a href="#">Request</a>
                    <div class="dropdown-content">
                        <a href="#new-Request">New</a>
                        <a href="#Current">Current</a>
                    </div> 
                </li>
                <li class="dropdown">
                <a href="#">View</a>
                <div class="dropdown-content">
                <a href="mybook.php">My Booked Session</a>
                    <a href="PartnerList.php">Language Partners</a>
                    <a href="PreviousSession.php">Previous Session</a>
                    <a href="CuSession.php">Current Session</a>
                    <a href="RateReviews.php">Rate and review</a>
                </div>
                </li>
                
                <li><a href="LearnerProfile.php">Manage Profile</a></li>
             
                <li><a href="signOutL.php">Sign Out</a></li> 
            </ul> 
        </nav>
        
    </header>

    
  
	<div class="container">
    <div class="text">
      <?php echo "<h1>Welcome, " . $_SESSION['userName'] . "!</h1>"; ?>
      <p>Master any language by actually chatting with real people</p>
  </div>
  
        <div class="learner">
            <img src="../homePage/language-learner.png" alt="Language Learner">
        </div>
        <!------------------------new req----------------------------->
        <div class="newRequest">
          <h1> New Request</h1>
        </div>
        <form class="new-Request" id="new-Request">
          <label for="lang">Choose language:</label>
          <input class="lang" list="language" name="lang" placeholder="Choose">
          <datalist id="language">
            <option value="English">
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
              <input  id="level3" type="radio" name="level">
              <label for="level3">Intermediate</label>
              
            </div>
            <div>
              <input  id="level4" type="radio" name="level">
              <label for="level4">Upper-Intermediate</label>
              
            </div>
            <div>
              <input  id="level5" type="radio" name="level">
              <label for="level5">Advanced</label>
              
            </div>
          </div>
      
          <label for="start-date">When do you want to start learning:</label>
          <input type="date" id="start-date">
      
          <label for="duration">Choose session duration:</label>
          <select name="duration" id="duration">
            <option value="1"> 30 minutes</option>
            <option value="2"> 1 hour</option>
            <option value="3"> 2 hours</option>
            <option value="4">3 hours</option>
          </select>
      
          <button type="submit" class="btn">Submit</button>
        </form>
        <!-- -------------------------------------------------------------------------------------- -->
        </div>
    <a href="#request" class="go">
    </a>
   
    <label class="Current" id="Current"> <h3> Current requests</h3></label>
    <section class="requests">
        <div class="request">
          <h3>first request</h3>
          <p> <strong>Language : </strong>  English </p>
          <p> <strong>Proficiency level :</strong>  Intermediate</p>
          <p> <strong> Date:</strong>  04/11/2024</p>
          <p> <strong> Session duration : </strong> 1 hour </p>
            <a href="EditRequest.html"><button class="Edit-button">Edit</button></a>
            <button class="Delete-button">Delete</button>
        </div>

        <div class="request">
            <h3>Second request</h3>
            <p> <strong>Language : </strong>  Chinese </p>
            <p> <strong>Proficiency level :</strong>  Beginner</p>
            <p> <strong> Date :</strong>  01/08/2024</p>
            <p> <strong> Session duration : </strong> 2 hours </p>
            <br>
            <strong> Congratulations! , your request has been accepted</strong>
        </div>
      </section>

      





      </body>
      
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

  </html>
  
  
  <?php 
    }
?>
    
