<!DOCTYPE html>
<html>

<head>
  <title>TalkTandem | SignUp</title>
  <link rel="stylesheet" type="text/css" href="SignUp-login.css">
  <link rel="shortcut icon" href="Logo white .jpeg" type="image/x-icon">
 
  <script>
    function validatefirst_name() {
      var first_name = document.getElementById("first_name").value;
      var first_nameError = document.getElementById("first_nameError");
      if (first_name.trim() === "") {
        first_nameError.innerText = "First name is required";
        return false;
      } else if (!/^[a-zA-Z]+$/.test(first_name)) {
        first_nameError.innerText = "First name should only contain letters";
        return false;
      } else {
        first_nameError.innerText = "";
        return true;
      }
    }

    function validatelastt_name() {
      var lastt_name = document.getElementById("lastt_name").value;
      var lastt_nameError = document.getElementById("lastt_nameError");
      if (lastt_name.trim() === "") {
        lastt_nameError.innerText = "Last name is required";
        return false;
      } else if (!/^[a-zA-Z]+$/.test(lastt_name)) {
        lastt_nameError.innerText = "Last name should only contain letters";
        return false;
      } else {
        lastt_nameError.innerText = "";
        return true;
      }
    }

    function validateEmail() {
      var email = document.getElementById("email").value;
      var emailError = document.getElementById("emailError");
      if (email.trim() === "") {
        emailError.innerText = "Email is required";
        return false;
      } else {
        var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailPattern.test(email)) {
          emailError.innerText = "Please enter a valid email address";
          return false;
        } else {
          emailError.innerText = "";
          return true;
        }
      }
    }

    function validatePassword() {
      var password = document.getElementById("password").value;
      var passwordError = document.getElementById("passwordError");
      if (password.trim() === "") {
        passwordError.innerText = "Password is required";
        return false;
      } else {
        var passwordStrengthPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^\da-zA-Z]).{8,}$/;
        if (!passwordStrengthPattern.test(password)) {
          passwordError.innerText = "The password must be at least eight characters long, with at least one capital, one lowercase, one number, and one special character.";
          return false;
        } else {
          passwordError.innerText = "";
          return true;
        }
      }
    }

    function validateCity() {
      var city = document.getElementById("city").value;
      var cityError = document.getElementById("cityError");
      if (city.trim() === "") {
        cityError.innerText = "City is required";
        return false;
      } else if (!/^[a-zA-Z\s]+$/.test(city)) {
        cityError.innerText = "City should only contain letters";
        return false;
      } else {
        cityError.innerText = "";
        return true;
      }
    }

    function validateLocation() {
      var location = document.getElementById("location").value;
      var locationError = document.getElementById("locationError");
      if (location.trim() === "") {
        locationError.innerText = "Location is required";
        return false;
      } else {
        locationError.innerText = "";
        return true;
      }
    }

    function validateForm() {
      var isfirst_nameValid = validatefirst_name();
      var islastt_nameValid = validatelastt_name();
      var isEmailValid = validateEmail();
      var isPasswordValid = validatePassword();
      var isCityValid = validateCity();
      var isLocationValid = validateLocation();

      return isfirst_nameValid && islastt_nameValid && isEmailValid && isPasswordValid && isCityValid && isLocationValid;
    }
  </script>
</head>

<body>
  <h1 class="signup-heading">Signup</h1>

  <?php
    // Check if an error message is passed through the URL
    if (isset($_GET['error'])) {
      // Display the error message as an alert
      echo "<script>alert('" . $_GET['error'] . "');</script>";
    }
  ?>
  
  <form method="POST" action="signUpL.php" onsubmit="return validateForm()" enctype="multipart/form-data">

    <label for="first_name" class="required-label">First Name:</label>
    <input type="text" id="first_name" name="first_name" class="input-field" oninput="validatefirst_name()">
    <span id="first_nameError" class="error"></span><br><br>

    <label for="last_name" class="required-label">Last Name:</label>
    <input type="text" id="last_name" name="last_name" class="input-field" oninput="validatelastt_name()">
    <span id="last_nameError" class="error"></span><br><br>

    <label for="email" class="required-label">Email:</label>
    <input type="email" id="email" name="email" class="input-field" oninput="validateEmail()">
    <span id="emailError" class="error"></span><br><br>

    <label for="password" class="required-label">Password:</label>
    <input type="password" id="password" name="password" class="input-field" oninput="validatePassword()">
    <span id="passwordError" class="error"></span><br><br>

    <label for="photo">Photo:</label>
    <input type="file" id="photo" name="photo"><br><br>

    <label for="city" class="required-label">City:</label>
    <input type="text" id="city" name="city" class="input-field" oninput="validateCity()">
    <span id="cityError" class="error"></span><br><br>

    <label for="location" class="required-label" >Location:</label>
    <input type="text" id="location" name="location" class="input-field" oninput="validateLocation()">
    <span id="locationError" class="error"></span><br><br>

    <input type="submit" value="Sign Up">
    <h5>Already have an account? <a href="loginL.html">Login</a></h5>
  </form>
</body>

</html>

