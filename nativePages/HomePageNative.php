<?php 
   echo "
   <script src='https://code.jquery.com/jquery-3.7.1.slim.min.js' integrity='sha256-kmHvs0B+OpCW5GVHUNjv9rOmY0IvSIRcf7zGUDTDQM8=' crossorigin='anonymous'></script>
   <script src='https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js' integrity='sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T' crossorigin='anonymous'></script>
    ";
    session_start();

    if(!isset($_SESSION['userName']))
      header("Location:../homePage/loginNF.php?error=Please Sign In again!");

    else{



      
      $dsn = 'mysql:dbname=projectdb;host=127.0.0.1;port=3306;';
      $user = 'root';
      $password = '';
      $db = new PDO($dsn, $user, $password);
      
if( isset($_REQUEST['allmessages'])){
  echo "<script type='text/javascript'>
  $(document).ready(function(){
  $('#messageModel').modal('show');
  });
  </script>";
}







if( isset($_REQUEST['messageidforlarner'])){

  if( isset($_REQUEST['msgcontent'])){

      $ins_query="insert into chate(language_partners_email,language_learners_email,msgcontent,datesend,msgtype) values (?,?,?,?,?);";
      $stmt=$db->prepare($ins_query);
      $parttener_email=$_SESSION['email'];
     $datesend=date('Y-m-d H:i:s');
        $learner_email=$_REQUEST["lernar_email_messag"];   
    
     
      $msgcontent=$_REQUEST["msgcontent"];
      @$res =$stmt->execute([$parttener_email,$learner_email,$msgcontent,$datesend,"recive"]);
      echo "<script type='text/javascript'>
      $(document).ready(function(){
      $('#messagelearnerModel').modal('show');
      });
      </script>";
     
    }
  

  $select_query_chat="select * from chate where language_partners_email='{$_SESSION['email']}' AND language_learners_email='{$_REQUEST['messageidforlarner']}'";
  $stmt_chat=$db->prepare($select_query_chat);
  $resobj=$stmt_chat->execute([]);

  $select_query_leardata="select * from language_learners where email='{$_REQUEST['messageidforlarner']}'";
  $stmt_learner=$db->prepare($select_query_leardata);
  $resobj_learner=$stmt_learner->execute([]);
  if($stmt_learner->rowCount()>0)
  {
    $row_learner_data = $stmt_learner->fetch(PDO::FETCH_ASSOC);
  
  }
   $fullname=$row_learner_data["first_name"]." ".$row_learner_data["last_name"] ."." ;
   $imageofpartner=$row_learner_data['photo'];
   $lernar_email_messag=$row_learner_data["email"];

   echo "<script type='text/javascript'>
   $(document).ready(function(){
   $('#messagelearnerModel').modal('show');
   });
   </script>";

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
    <link rel="stylesheet" href="../LearnerPages/HomePageLerner.css">
    <link rel="stylesheet" href="../LearnerPages/styleRequest.css">
    <link rel="stylesheet" href="HomePageNative.css">
    <link rel="stylesheet" href="style.css">


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
                <li><a href="HomePageNative.php?allmessages">messages</a></li>

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


      <br>

<div id="messagelearnerModel" class="modal">
<div class="modal-content" style="margin-top: 10%">
  <span class="close">&times;</span>
  
  <div class="modal-header">
    <div class="model_header_title">
      <div class="model_header_t1">
      <?php echo $fullname;?>

      </div>
    </div>
  </div>
  <div class="modal-body">
    <div class="body_content">




    <?php 
  if( isset($_REQUEST['messageidforlarner'])){
  if($stmt_chat->rowCount()>0)
       {
         while ($row_chat = $stmt_chat->fetch(PDO::FETCH_ASSOC)){
          // var_dump ($row_chat);
         
  
  if($row_chat['msgtype']=="recive"){
    if($_SESSION['photo']==null)
    $img="4325945.png";
  else
  $img=$_SESSION['photo'];
$myname=$_SESSION['userName'] ." ".$_SESSION['lastName'];
  }else{
    if($imageofpartner==null)
    $img="4325945.png";
  else
  $img=$imageofpartner;
  $myname=$fullname;
  }
   
   echo "
      <div class='body_content_day'>
        <div class='body_item'>{$row_chat['datesend']}</div>
      </div>
      <div class='model_content_side'>
        <img
          src=../homePage/uploads/$img
          alt=''
          width='50
          height='50'
          style='border-radius: 50%'>
        <div class='model_content_hi'>$myname</div>
      </div>
      <div class='model_send'>
        <div>{$row_chat['msgcontent']}</div>
        <!-- <div>send</div> -->
      </div>";
       }
      }else
      {
        echo " <h1 style='text-align: center;'> start message</h1>";
      }
  }
      ?>


      <div class="model_textarea">
      <form method="Post" action ='<?php echo "HomePageNative.php?messageidforlarner=$lernar_email_messag";?>' >
      <input type="text" value="<?php echo $lernar_email_messag; ?>" name="lernar_email_messag" hidden>
      <textarea name="msgcontent" id="0" cols="30" rows="2" placeholder="your message"  required> </textarea>
      <input type="submit" value="Send Message" style="margin-top:3px;">
   
</form>
      </div>
      
    </div>
  </div>
</div>

</div>








<div id="messageModel" class="modal">
<div class="modal-content" style="margin-top: 10%">
  <span class="close">&times;</span>


  <div class="modal-header">
    <div class="model_header_title">
      <div class="model_header_t1">

        <?php echo $_SESSION['userName'] ." ".$_SESSION['lastName'];?>.</div>
    </div>
  </div>
  <div class="modal-body">
    <div class="body_content">
      <?php 
          $par_email=$_SESSION['email'];
          $select_querychat="select * from chate where language_partners_email='$par_email' GROUP BY language_learners_email DESC;";
          $stmtchat=$db->prepare($select_querychat);
          $resobj=$stmtchat->execute([]);
if($stmtchat->rowCount()>0)
{


while ($row = $stmtchat->fetch(PDO::FETCH_ASSOC)){
   $select_query_learner="select * from language_learners where email='{$row['language_learners_email']}'";
  $stmtlearner=$db->prepare($select_query_learner);
  $resobj=$stmtlearner->execute([]);
   if($stmtlearner->rowCount()>0)
  $row_learner = $stmtlearner->fetch(PDO::FETCH_ASSOC);
  if($row_learner['photo']==null)
  $img="4325945.png";
else
$img=$row_learner['photo'];
 
      echo"
      <div class='body_content_day'>
        <div class='body_item'>{$row['datesend']}</div>
      </div>
      <div class='model_content_side'>
     <a href='HomePageNative.php?messageidforlarner={$row_learner['email']}'>
      <img
       src=../homePage/uploads/$img
       alt=''
       width='50'
       height='50'
       style='border-radius: 50%'>
       </a>
        <div class='model_content_hi' >{$row_learner['first_name']} {$row_learner['last_name']}</div>
      </div>
      <div class='model_send'>
        <div style='font-weight: bold;'> {$row['msgcontent']} </div>
      </div>
      <hr width='90%'>
  
      </div>";
}
  }else{
      echo " <h1 style='text-align: center;'> no chat yet </h1>";
  }
         ?>
      
    </div>
  </div>
</div>
</div>


<!-- Include Font Awesome -->
<script>

var modal = document.getElementById("messagelearnerModel");
var modal2 = document.getElementById("messageModel");



var span = document.getElementsByClassName("close")[0];
var span2 = document.getElementsByClassName("close")[1];



span.onclick = function () {
modal.style.display = "none";
};
span2.onclick = function () {
modal2.style.display = "none";
};
</script>





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