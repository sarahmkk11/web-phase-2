<?php 
    session_start();

    if(!isset($_SESSION['userName']))
      header("Location:../homePage/loginNF.php?error=Please Sign In again!");

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
    <link rel="shortcut icon" href="../homePage/Logo white .jpeg" type="image/x-icon">
    <link rel="stylesheet" href="../LearnerPages/HomePageLerner.css">
    <link rel="stylesheet" href="../LearnerPages/styleRequest.css">
    <link rel="stylesheet" href="HomePageNative.css">

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

                <li class="dropdown">
                    <a href="#">Requests</a>
                    <div class="dropdown-content">
                        <a href="LearningRequestList.html">Request List</a>
                        <a href="#view_Request"> Request Status</a>
                        <a href="#Accept-Rej">Learner Requests</a>
                    </div> 
                </li>
                <li class="dropdown">
                <a href="#">View</a>
                <div class="dropdown-content">
                    <a href="PreviousSessionsN.html">Previous Session</a>
                    <a href="CuSessionN.html">Current Session</a>
                    <a href="viewReviews.html">Reviews</a>
                </div>
                </li>
                
                <li><a href="NativeProfile.php">Manage Profile</a></li>
             
                <li><a href="signOutN.php">Sign Out</a></li>
            </ul> 
        </nav>
        
    </header>

               <!-- container  -->


        <div class="contain">
           <div class="Teach">
             <?php echo "<h1>Welcome, " . $_SESSION['userName'] . "!</h1>";?>
                <p > to our vibrant community of language educators! </p>
                </div>
                <div class="Native">
                    <img src="laptop-provider-visit-lg2 (2).png" alt="Language Learner">
                </div>
            </div>

<!-- <div class="a">
    <div class="b">
        <div class="c">
          <img src="chat.svg" alt="">


        </div>


    </div>



</div> -->







        <!-- Status of requests -->


    <label class="Status" id="view_Request"><h3> Status of requests</h3></label>
    <section class="requests">
        <div class="request">
          <h3>first request</h3>
          <p> <strong>Language : </strong>  English </p>
          <p> <strong>Proficiency level :</strong>  Intermediate</p>
          <p> <strong>The course begins :</strong>  04/11/2024</p>
          <p> <strong>course duration : </strong> 1 hour </p>
          <br>
          <strong> Pending </strong>
        </div>

        <div class="request">
            <h3>Second request</h3>
            <p> <strong>Language : </strong>  Chinese </p>
            <p> <strong>Proficiency level :</strong>  Beginner</p>
            <p> <strong>The course begins :</strong>  01/08/2024</p>
            <p> <strong>course duration : </strong> 1 hour </p>
            <br>
            <strong> Accepted</strong>
        </div>
      </section>
      
      <!-- Language Learner requests  -->

      <label class="LLrequest" id="Accept-Rej"><h3> Language Learner requests </h3></label>
      <section class="requests">
          <div class="request">
            <h3>first request</h3>
            <p> <strong>Language : </strong>  English </p>
            <p> <strong>Proficiency level :</strong>  Intermediate</p>
            <p> <strong>Date :</strong>  04/11/2024</p>
            <p> <strong>Session duration : </strong> 1 hour </p>
              <button class="Edit-button">Accept</button>
              <button class="Delete-button">Reject</button>
          </div>

          <div class="request">
            <h3>Second request</h3>
            <p> <strong>Language : </strong>  Chinese </p>
            <p> <strong>Proficiency level :</strong>  Beginner</p>
            <p> <strong>Date :</strong>  01/08/2024</p>
            <p> <strong>Session duration : </strong> 30 minutes </p>
            <button class="Edit-button">Accept</button>
            <button class="Delete-button">Reject</button>
        </div>
      </section>





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
<?php 
    }
?>