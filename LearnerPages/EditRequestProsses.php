<?php
session_start();

$language_err = $level_err = $start_date_err = $duration_err = "";

if(isset($_POST['Save_Changes'])){

    $servername= "localhost";
    $username= "root" ;
    $password= "";
    $dbname= "projectdb" ;
    
    if (!$connection= mysqli_connect($servername,$username,$password)) 
    die("Connection failed: " . mysqli_connect_error());
    
    if(!$database= mysqli_select_db($connection, $dbname))
    die("Could not open database failed: " . mysqli_connect_error());

    
       

        $id =  $_POST['idReq'];
        $language = $_POST['lang'];
        $level = $_POST['level'];
        $start_date = $_POST['start-date'];
        $duration = $_POST['duration'];

       
        echo $start_date ;
     

    

      if (empty($_POST['lang'])) {
          $language_err = "Please choose a language";
      } else {
          $language = $_POST['lang'];
      }
  
      if (empty($_POST['level'])) {
          $level_err = "Please choose a level";
      } else {
          $level = $_POST['level'];
      }
  
      if (empty($_POST['start-date'])) {
          $start_date_err = "Please choose a start date";
      } else {
          $start_date = $_POST['start-date'];
      }
  
      if (empty($_POST['duration'])) {
          $duration_err = "Please choose a session duration";
      } else {
          $duration = $_POST['duration'];
      }


      $email =  $_SESSION['imail'];
      $language = $_SESSION['lang'];
      $level = $_SESSION['level'];
      $start_date = $_SESSION['start-date'];
      $duration = $_SESSION['duration'];
        $sql = "UPDATE `requests` SET `language`='$language',`level`='$level',`schedule_Time`='$start_date',`session_duration`='$duration', WHERE `email` = '$email'";
    
        echo 'done0';
        $query = mysqli_query($connection,$sql);
        echo 'done01';
      
     
       if( $query ){
        echo 'done1111';}
    


        $_SESSION['editDone'] = "Edited successful!";
    header("Location: http://localhost/LearnerPages\EditRequest.php");
    
}//end line 6
    else{
        echo 'fail';
        header("Location: http://localhost/Projectdb/editingRequest.php?id=$id");
        }
   
//}

?> 