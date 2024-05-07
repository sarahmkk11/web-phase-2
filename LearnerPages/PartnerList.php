<?php 
session_start(); 
if(!isset($_SESSION['email']))
header("Location:../homePage/loginLF.php?error=Please Sign In again!");
 
  echo "
  <script src='https://code.jquery.com/jquery-3.7.1.slim.min.js' integrity='sha256-kmHvs0B+OpCW5GVHUNjv9rOmY0IvSIRcf7zGUDTDQM8=' crossorigin='anonymous'></script>
  <script src='https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js' integrity='sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T' crossorigin='anonymous'></script>
   ";
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
        $learner_email=$_SESSION['email'];
       $datesend=date('Y-m-d H:i:s');
          $parttener_email=$_REQUEST["partner_email_messag"];   
      
       
        $msgcontent=$_REQUEST["msgcontent"];
        @$res =$stmt->execute([$parttener_email,$learner_email,$msgcontent,$datesend,"send"]);
        echo "<script type='text/javascript'>
        $(document).ready(function(){
        $('#messagelearnerModel').modal('show');
        });
        </script>";
       
      }
    

    $select_query_chat="select * from chate where language_partners_email='{$_REQUEST['messageidforlarner']}' AND language_learners_email='{$_SESSION['email']}'";
    $stmt_chat=$db->prepare($select_query_chat);
    $resobj=$stmt_chat->execute([]);

    $select_query_leardata="select * from language_partners where email='{$_REQUEST['messageidforlarner']}'";
    $stmt_learner=$db->prepare($select_query_leardata);
    $resobj_learner=$stmt_learner->execute([]);
    if($stmt_learner->rowCount()>0)
    {
      $row_learner_data = $stmt_learner->fetch(PDO::FETCH_ASSOC);
    
    }
     $fullname=$row_learner_data["first_name"]." ".$row_learner_data["last_name"] ."." ;
     $imageofpartner=$row_learner_data['photo'];
     $part_email_messag=$row_learner_data["email"];

     echo "<script type='text/javascript'>
     $(document).ready(function(){
     $('#messagelearnerModel').modal('show');
     });
     </script>";

 }   




?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Include Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <title>Lnguage Prtner List</title>
    <link rel="shortcut icon" href="Logo white .jpeg" type="image/x-icon">
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
                        <a href="PreviousSession.php">Previous Session</a>
                        <a href="CuSession.php">Current Session</a>
                        <a href="RateReviews .php">Rate and review</a>
                    </div>
                    </li>
                    
                  
                <li><a href="LearnerProfile.html">Manage Profile</a></li>
             
             <li><a href="signOutL.php">Sign Out</a></li>
                </ul> 
            </nav>
            
        </header>
        
 
       
    <!-- Filter Dropdowns -->
    <div class="filter-dropdown">
    <form   method="post">
        <select name="price" id="filter-location" onchange="this.form.submit()" >
            <option ><?php 
            if( isset($_REQUEST['price'])){
    echo $_REQUEST['price'];
}else
{
    echo "Price per Session";
}?></option>
            <option value="0-25">0-25$</option>
            <option value="25-50">25-50$</option>
            <option value="50-75">50-75$</option>
            <option value="75-above">75$ and above</option>
            <option value="others">others</option>

        </select>
     
        <select  name="languge"  id="filter-language" onchange="this.form.submit()"  >
            
            <option ><?php 
            if( isset($_REQUEST['languge'])){
    echo $_REQUEST['languge'];
}else
{
    echo "I want to learn..";
}?></option>
            <option value="English">English</option>
            <option value="Spanish">Spanish</option>
            <option value="French">French</option>
            <option value="others">others</option>
        </select>
        </form>
    </div>
    
    <div class="tutor-container tutor-container-home">
<?php

  if( (@$_REQUEST['price'] =='others' && @$_REQUEST['languge']=='others') || (@$_REQUEST['price'] =='' && @$_REQUEST['languge']=='') ){

    $select_query="select * from language_partners";
    $stmt=$db->prepare($select_query);
    $resobj=$stmt->execute([]);
   
    if($stmt->rowCount()>0)
    {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            if($row['photo']==null)
            $row['photo']="4325945.png";
            $select_query_session="select * from partnersesession where language_partners_email='{$row['email']}' AND statussession='available'";
            $stmt_session=$db->prepare($select_query_session);
            $resobj=$stmt_session->execute([]);
            $select_rate="select AVG(rate) FROM rate WHERE language_partners_email='{$row['email']}' GROUP BY language_partners_email";
            $stmtrate=$db->prepare($select_rate);
            $resobj=$stmtrate->execute([]);
            if($stmtrate->rowCount()>0)
            {
              $rowrate = $stmtrate->fetch(PDO::FETCH_ASSOC);
             
              $rateofprtner=ROUND($rowrate["AVG(rate)"], 2);
            
            }else
            {
              $rateofprtner="0";
            }
           
            if($stmt_session->rowCount()>0)
            {
                while ($row_session = $stmt_session->fetch(PDO::FETCH_ASSOC)){
              



    echo "
            <div class='tutor'>
                <div class='tutor-img'>
    
                    <img src='../homePage/uploads/{$row['photo']}' alt='Tutor 1'>
    
                </div>
                <div class='tutor-data'>
                    <div>
                        <h2> {$row['first_name']} {$row['last_name']}.</h2>
                        <p><span class='data'><i class='fas fa-map-marker-alt'></i></span> {$row['city']}</p>
                        <p><span class='data'><i class='fas fa-chalkboard-teacher'></i></span> Teaches {$row_session['Teacheslanguges']} sessions</p>
                        <p><span class='data'><i class='fas fa-language'></i></span> Speaks {$row_session['Speakslanguges']}</p>
                        <p> {$row['bio']}.</p>           
                    </div>
                </div>
                
                <div class='tutor-action'>
                    <h2><span class='rate'><i class='fas fa-star'></i></span> {$rateofprtner}</h2>
                    <p>Price per Hour:$   {$row_session['price']}</p>
                        <a href='partner1.php?email={$row['email']}&partsession={$row_session['Id']}' class='buttonn'>  View Details </a>
                        
                </div>
            </div>";
        }
        }
      }
    }

    }else{
$a=explode("-", @$_REQUEST['price']);
if(@$a[1]=="above" || @$a[1]==""  ){

 
    if(@$a[0]=="others" || @$a[0]=="Price per Session" ){
        // $_REQUEST["languge"]="*";
        $a[0]=0;
    }
   
    $select_query="select * from  partnersesession  WHERE Teacheslanguges LIKE '%$_REQUEST[languge]%'    AND price >=$a[0] AND statussession='available'";
    if($_REQUEST["languge"]=="others" ||$_REQUEST["languge"]=="I want to learn..")
    $select_query="select * from partnersesession WHERE     price >=$a[0] AND statussession='available'";

}else{
    $select_query="select * from partnersesession WHERE Teacheslanguges LIKE '%$_REQUEST[languge]%'   AND price BETWEEN  $a[0] AND  $a[1] AND statussession='available'";
    if($_REQUEST["languge"]=="others" ||$_REQUEST["languge"]=="I want to learn..")
    $select_query="select * from partnersesession WHERE  price BETWEEN  $a[0] AND  $a[1] AND statussession='available'
  ";

}

        $stmt=$db->prepare($select_query);
        $resobj=$stmt->execute([]);
        // var_dump($select_query);
        if($stmt->rowCount()>0)
        {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

              $select_query_partner="select * from language_partners where email='{$row['language_partners_email']}'";
              $stmt_session=$db->prepare($select_query_partner);
              $resobj=$stmt_session->execute([]);
              $select_rate="select AVG(rate) FROM rate WHERE language_partners_email='{$row['language_partners_email']}' GROUP BY language_partners_email";
              $stmtrate=$db->prepare($select_rate);
              $resobj=$stmtrate->execute([]);
              if($stmtrate->rowCount()>0)
              {
                $rowrate = $stmtrate->fetch(PDO::FETCH_ASSOC);
               
                $rateofprtner=ROUND($rowrate["AVG(rate)"], 2);
              
              }else
              {
                $rateofprtner="0";
              }
              if($stmt_session->rowCount()>0)
              {
                  while ($row_session = $stmt_session->fetch(PDO::FETCH_ASSOC)){
                
  
                if($row_session['photo']==null)
                $row_session['photo']="4325945.png";
        
        echo "
                <div class='tutor'>
                    <div class='tutor-img'>
        
                        <img src='../homePage/uploads/{$row_session['photo']}' alt='Tutor 1'>
        
                    </div>
                    <div class='tutor-data'>
                        <div>
                            <h2> {$row_session['first_name']} {$row_session['last_name']}.</h2>
                            <p><span class='data'><i class='fas fa-map-marker-alt'></i></span> {$row_session['city']}</p>
                            <p><span class='data'><i class='fas fa-chalkboard-teacher'></i></span> Teaches {$row['Teacheslanguges']} sessions</p>
                            <p><span class='data'><i class='fas fa-language'></i></span> Speaks {$row['Speakslanguges']}</p>
                            <p> {$row_session['bio']}.</p>           
                        </div>
                    </div>
                    
                    <div class='tutor-action'>
                        <h2><span class='rate'><i class='fas fa-star'></i></span>{$rateofprtner}</h2>
                        <p>Price per Hour:$   {$row['price']}</p>
                            <a href='partner1.php?email={$row_session['email']}&partsession={$row['Id']}' class='buttonn'>  View Details </a>
                            
                    </div>
                </div>";
            } 
          }
        }
        }else{
          echo  "<h1>there is no data match your search</h1>";
        }
    }
?>
    </div>





    <div id="messagelearnerModel" class="modal">
<div class="modal-content">
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
               
        
        if($row_chat['msgtype']=="send"){
          if($_SESSION['photo']==null)
          $img="4325945.png";
        else
        $img=$_SESSION['photo'];
      $myname=$_SESSION['userName']." ".$_SESSION['lastName'];
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
            <form method="Post" action ='<?php echo "PartnerList.php?messageidforlarner=$part_email_messag";?>' >
            <input type="text" value="<?php echo $part_email_messag; ?>" name="partner_email_messag" hidden>
            <textarea name="msgcontent" id="0" cols="30" rows="2" placeholder="your message"  required> </textarea>
            <input type="submit" value="Send Message" style="margin-top:3px;">
         
      </form>
            </div>
            
          </div>
        </div>
      </div>
     
    </div>








    

    <div id="messageModel" class="modal">
      <div class="modal-content">
        <span class="close">&times;</span>
        <div class="modal-header">
          <div class="model_header_title">
            <div class="model_header_t1"><?php echo $_SESSION['userName'] ." ".$_SESSION['lastName'];?>.</div>
          </div>
        </div>
        <div class="modal-body">
          <div class="body_content">
            <?php 
               
                $select_querychat="select * from chate where language_learners_email='{$_SESSION['email']}' GROUP BY  language_partners_email DESC;";
                $stmtchat=$db->prepare($select_querychat);
                $resobj=$stmtchat->execute([]);
   if($stmtchat->rowCount()>0)
   {
    while ($row = $stmtchat->fetch(PDO::FETCH_ASSOC)){

        $select_query_learner="select * from language_partners where email='{$row['language_partners_email']}'";
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
           <a href='PartnerList.php?messageidforlarner={$row_learner['email']}'>
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


