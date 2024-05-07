<?php
echo "
<script src='https://code.jquery.com/jquery-3.7.1.slim.min.js' integrity='sha256-kmHvs0B+OpCW5GVHUNjv9rOmY0IvSIRcf7zGUDTDQM8=' crossorigin='anonymous'></script>
<script src='https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js' integrity='sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T' crossorigin='anonymous'></script>
 ";
$dsn = 'mysql:dbname=projectdb;host=127.0.0.1;port=3306;';
$user = 'root';
$password = '';
$db = new PDO($dsn, $user, $password);
session_start(); 
$email=$_REQUEST['email'];
 







// echo  date('Y-m-d H:i:s');
$select_query="select * from language_partners where email='{$email}'";
$stmt=$db->prepare($select_query);
$resobj=$stmt->execute([]);
if($stmt->rowCount()>0)
{
  $row = $stmt->fetch(PDO::FETCH_ASSOC);

}
 $fullname=$row["first_name"]." ".$row["last_name"] ."." ;
 $imageofpartner=$row['photo'];
 
if( isset($_REQUEST['addfeedback'])){
  $leaner_idsession=$_SESSION['email'];
$select_query="select * from book where language_learners_email=$leaner_idsession AND language_partners_email=$email";
$stmt=$db->prepare($select_query);
$resobj=$stmt->execute([]);
if($stmt->rowCount()>0)
{
  $ins_query="insert into review(language_partners_email,Learner_name,review) values (?,?,?);";
  $stmt=$db->prepare($ins_query);
  $parttener_email=$email;
  if(@$_SESSION['userName']){
    $Learner_name=$_SESSION['userName'] ." ".$_SESSION['lastName'];

  }else{
    $Learner_name="new user";

  }
  $review=$_REQUEST["addfeedback"];
  @$res =$stmt->execute([$parttener_email,$Learner_name,$review]);

}else{

  echo "<script> alert('book the session frist.. '); 
  </script>";



}
}




if( isset($_REQUEST['partnersesession_id'])){
  $leaner_ema=$_SESSION['email'];

  $ins_query_book="insert into book(language_partners_email,language_learners_email,partnersesession_id) values (?,?,?);";
  $stmt_book=$db->prepare($ins_query_book);
  $parttener_id=$email;
  @$res =$stmt_book->execute([$email,$leaner_ema,$_REQUEST['partnersesession_id']]);

  $update_query="update partnersesession set statussession='booked'  where id={$_REQUEST['partnersesession_id']}";
   $stmt=$db->prepare($update_query);
   $resobj=$stmt->execute();
   header('Location:mybook.php');

}



 
if( isset($_REQUEST['msgcontent'])){

  $ins_query="insert into chate(language_partners_email,language_learners_email,msgcontent,datesend,msgtype) values (?,?,?,?,?);";
  $stmt=$db->prepare($ins_query);
  $parttener_email=$email;
 $datesend=date('Y-m-d H:i:s');
    $learner_email=$_SESSION['email'];
    // $learner_email=1;

 
  $msgcontent=$_REQUEST["msgcontent"];
  @$res =$stmt->execute([$email,$learner_email,$msgcontent,$datesend,"send"]);
  echo "<script type='text/javascript'>
  $(document).ready(function(){
  $('#messageModel').modal('show');
  });
  </script>";
 
}

$select_rate="select AVG(rate) FROM rate WHERE language_partners_email='$email' GROUP BY language_partners_email";
$stmtrate=$db->prepare($select_rate);
$resobj=$stmtrate->execute([]);
if($stmtrate->rowCount()>0)
{
  $rowrate = $stmtrate->fetch(PDO::FETCH_ASSOC);
 
  $rateofprtner=ROUND($rowrate["AVG(rate)"], 2);

}else
{
  $rateofprtner="no rate yet";
}

?>
<!DOCTYPE html>
<html >
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>English Language Tutors</title>
    
<!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous"> -->
<!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script> -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"> -->
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script> -->
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="formstyle.css">

 
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
            
            <li><a href="LearnerProfile.html">Manage Profile</a></li>
             
             <li><a href="signOutL.php">Sign Out</a></li>
        </ul> 
    </nav>
    
</header>

    <div class="tutor-container">
        <div class="details tutor">
            <div class="tutor-data-details">
                <div class="tutor-img">
                  <?php
                              if($row['photo']==null)
                              $row['photo']="4325945.png";
                            echo "<img src=../homePage/uploads/{$row['photo']} alt='Tutor 1'>";
                  ?>
                    
                </div>


                   <?php
            $select_query_a="select * from partnersesession where Id={$_REQUEST['partsession']} ";
            $stmt_a=$db->prepare($select_query_a);
            $resobj=$stmt_a->execute([]);
            if($stmt_a->rowCount()>0)
            {
              $row_a = $stmt_a->fetch(PDO::FETCH_ASSOC);
            }


            ?><div class="tutor-data">
                    <div>
                        <h2><?php  echo $row["first_name"] ." ".$row["last_name"] ."." ;?></h2>
                        <p><span class="data"><i class="fas fa-map-marker-alt"></i></span> <?php  echo $row["city"]  ;?></p>

                        <p><span class="data"><i class="fas fa-user"></i></span> Teaches <?php  echo $row_a["Teacheslanguges"]  ;?> sessions</p>
                        <p><span class="data"><i class="fas fa-language"></i></span> Speaks <?php  echo $row_a["Speakslanguges"]  ;?></p>
                    </div>
                </div>
            </div>
         
            <div class="tutor-action tutor-action-details">
                <!-- <img src="img4.png" class="tutor1-img"> -->
                  <h2><span class="rate"><i class="fas fa-star"></i></span> <?php echo $rateofprtner;?></h2>
                  <p>Price per Hour: $  <?php  echo $row_a["price"]  ;?></p>
                  <button id="openModal"> Book Session</button>
                  <button id="openModal2" class="msg-btn-detsils">Contact Partner</button>
            </div>
        </div>
        
        <div class="about-tutor">
            <h3>About Tutor</h3>           
            <?php  echo $row["bio"]  ;?>
 
        
        </div>
        

        <div class="feedback-section" >
            <h3>User Feedback</h3>
            <div class="overall-rate">
                <div class="stars-box">
                    <span class="average-rating"> <?php echo $rateofprtner;?></span>
                    <div>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                </div>
                <div class="progress">
                    <div class="progress-row">
                        <div class="progress-bar" style="width: 70%;"></div>
                        <span class="star-rating">5 Stars</span>
                    </div>
                    <div class="progress-row">
                        <div class="progress-bar" style="width: 20%;"></div>
                        <span class="star-rating">4 Stars</span>
                    </div>
                    <div class="progress-row">
                        <div class="progress-bar" style="width: 5%;"></div>
                        <span class="star-rating">3 Stars</span>
                    </div>
                    <div class="progress-row">
                        <div class="progress-bar" style="width: 3%;"></div>
                        <span class="star-rating">2 Stars</span>
                    </div>
                    <div class="progress-row">
                        <div class="progress-bar" style="width: 2%;"></div>
                        <span class="star-rating">1 Star</span>
                    </div>
                </div>
            </div>
        <br>
            <!-- Feedbacks -->
            <?php
                $select_query="select * from review where session_id={$_REQUEST['partsession']}";
                $stmt=$db->prepare($select_query);
                $resobj=$stmt->execute([]);
                if($stmt->rowCount()>0)
                {
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                
                echo "
                 <div class='feedback'>
                <h3>{$row['Learner_name']}</h3>
                <p>{$row['review']}</p>
            </div>";
                    }
                  }
                  else{
                   echo "<h1> No Review  yet </h1>";
                  }
        ?>
 
<!--  
<form method="Post" action ='
<?php 
// echo "partner1.php?email={$email}&partsession={$_REQUEST['partsession']}";
 ?>
' >
    
<input type="text"  name="addfeedback" required placeholder="Add yor feedback" required><br>
    <input type="submit" value="Add Feedback">
     
  </form> -->
        </div>      
    </div>

    <script>
      function toggleSeeMore() {
          if(document.getElementById("textarea").style.display == 'none') {
              document.getElementById("textarea").style.display = 'block';
              document.getElementById("seeMore").innerHTML = 'See less';
          }
          else {
              document.getElementById("textarea").style.display = 'none';
              document.getElementById("seeMore").innerHTML = 'See more';        
          }
      }
      </script>

<!-- book Session -->
<div id="bookingModel" class="modal">
      <div class="modal-content">
      <span class="close">&times;</span>

      <div >
   
<br>
<br>
  
   <?php
            $select_query_partnersesession="select * from  partnersesession where language_partners_email='$email' AND statussession='available'";
            $stmt_sesession=$db->prepare($select_query_partnersesession);
            $resobj=$stmt_sesession->execute([]);
            if($stmt_sesession->rowCount()>0)
            {
                while ($row = $stmt_sesession->fetch(PDO::FETCH_ASSOC)){
echo "
<div  style='margin: 70px;   
 background-color: #fff;
border-radius: 10px;
box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
margin: 20px;
padding: 20px;
width: 400px;'>

<div class='tutor-data'>
<div>
    <h2>$fullname</h2>
    <p><span class='data'><i class='fas fa-language'></i></span> Language: {$row['Teacheslanguges']} </p>
    <p><span class='data'><i class='fas fa-calendar-alt'></i></span> Date: {$row['datesession']} </p>
    <p><span class='data'><i class='far fa-clock'></i></span> Session Duration: {$row['SessionDuration']} hour </p>
           
</div>
</div>

<div class='tutor-action'>
<a href='partner1.php?email={$email}&partnersesession_id={$row['Id']}&partsession={$_REQUEST['partsession']}' class='buttonn'>  Book Session </a>
   
</div>
</div>

";
                }
              }else
              {
echo " <h1 style='text-align: center;'> No Session Available </h1>";

              }
   ?>

    
  

</div>
      </div>
    </div>



    <!-- Send Message -->
    <div id="messageModel" class="modal">
      <div class="modal-content">
        <span class="close">&times;</span>
        <div class="modal-header">
          <div class="model_header_title">
            <div class="model_header_t1"><?php echo $fullname;?></div>
          </div>
        </div>
        <div class="modal-body">
          <div class="body_content">
            


          <?php 
         $leaner_email=$_SESSION['email'];
         $select_query="select * from chate where language_partners_email='$email' AND language_learners_email='$leaner_email'";
         $stmt=$db->prepare($select_query);
         $resobj=$stmt->execute([]);
         if($stmt->rowCount()>0)
         {
             while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        if($row['msgtype']=="send"){
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
              <div class='body_item'>{$row['datesend']}</div>
            </div>
            <div class='model_content_side'>
              <img
                src=../homePage/uploads/{$img}
                alt=''
                width='50
                height='50'
                style='border-radius: 50%'>
              <div class='model_content_hi'>$myname</div>
            </div>
            <div class='model_send'>
              <div>{$row['msgcontent']}</div>
              <!-- <div>send</div> -->
            </div>";
             }
            }else
            {
              echo " <h1 style='text-align: center;'> start message</h1>";
            }

            ?>

            <div class="model_textarea">
            <form method="Post" action ='<?php echo "partner1.php?email={$email}&partsession={$_REQUEST['partsession']}";?>' >
            <textarea name="msgcontent" id="0" cols="30" rows="2" placeholder="your message"  required> </textarea>
            <input type="submit" value="Send Message" style="margin-top:3px;">
         
              </form>
            </div>
            
          </div>
        </div>
      </div>
    </div>

    <script>
      var confirmTimeBtn = document.querySelector(".confirm-time-btn");

      var modal = document.getElementById("bookingModel");
      var modal2 = document.getElementById("messageModel");

      var btn = document.getElementById("openModal");
      var btn2 = document.getElementById("openModal2");

      var span = document.getElementsByClassName("close")[0];
      var span2 = document.getElementsByClassName("close")[1];

      btn.onclick = function () {
        modal.style.display = "block";
      };
      btn2.onclick = function () {
        modal2.style.display = "block";
      };
      span.onclick = function () {
        modal.style.display = "none";
        confirmTimeBtn.disabled = true;
      };
      span2.onclick = function () {
        modal2.style.display = "none";
        // confirmTimeBtn.disabled = true;
      };
    </script>
    
    <!-- <script>
      var timeSlots2 = document.querySelectorAll(".slot-time2");
      var confirmTimeBtn = document.querySelector(".confirm-time-btn");
      var modal = document.getElementById("bookingModel"); 

      function handleTimeSlot2Click() {
        timeSlots2.forEach((slot) => {
          slot.classList.remove("active");
          slot.style.border = ""; 
          slot.style.padding = "";
        });
        this.classList.add("active");
        confirmTimeBtn.disabled = false;
        this.style.border = "1px solid black";
        this.style.padding = "5px";
      }
      timeSlots2.forEach(function (timeSlot) {
        timeSlot.addEventListener("click", handleTimeSlot2Click);
      });
      confirmTimeBtn.addEventListener("click", function () {
        modal.style.display = "none";
        alert("Time confirmed successfully!");
      });
    </script>
     -->
    <footer>
      <div class="social-icons">
        <a href="https://www.instagram.com/talktandem" class="icon facebook"><i class="fab fa-facebook" style="margin-top:10px;"></i></a>
        <a href="https://www.twitter.com/talktandem" class="icon twitter"><i class="fab fa-twitter" style="margin-top:10px;"></i></a>
        <a href="https://www.instagram.com/talktandem" class="icon instagram"><i class="fab fa-instagram" style="margin-top:10px;"></i></a>
        <a href="https://www.linkedin.com/talktandem" class="icon linkedin"><i class="fab fa-linkedin" style="margin-top:10px;"></i></a>
        <a href="mailto:contact@talktandem.com" class="icon email"><i class="far fa-envelope" style="margin-top:10px;"></i></a>
      </div>
      <p class="copyright">© 2024 Talk Tandem. All rights reserved.</p>
    </footer>
  </body>
</html>