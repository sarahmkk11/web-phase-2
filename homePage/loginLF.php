<?php
session_start();

if (isset($_SESSION['userName'])) {
  // User already logged in, redirect to HomePageLerner.php
  header("Location:../LearnerPages/HomePageLerner.php");
  exit;
}
?>


<!DOCTYPE html>
<html>

<!---------------------HEAD---------------------------->

<head>
  <title>TalkTandem | Login</title>
  <link rel="stylesheet" type="text/css" href="SignUp-login.css">
  <link rel="shortcut icon" href="Logo white .jpeg" type="image/x-icon">
</head>

<!---------------------BODY---------------------------->

<body>

<script>
            // Check if there is an error message in the URL
            var urlParams = new URLSearchParams(window.location.search);
            var error = urlParams.get('error');
            if (error) {
                // Display the error message as an alert
                alert(error);
            }
        </script>

        
  <div class="container">

    <h1>Login</h1>
    <form method="POST" action="loginL.php">
      <div class="form-group">
        <label for="Email">Email:</label>
        <input type="text" id="Email" name="Email" placeholder="Enter your Email" required>
      </div>
      <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" placeholder="Enter your password" required>
      </div>

      <input type="submit" value="Login">
      <h5>Don't have an account? <a href="SignUpLF.php">SignUp</a></h5>

    </form>
  </div>

  

</body>

</html>