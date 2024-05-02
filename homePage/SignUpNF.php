<!DOCTYPE html>
<html>

<head>
  <title>TalkTandem | SignUp</title>
  <link rel="stylesheet" type="text/css" href="SignUp-login.css">
  <link rel="shortcut icon" href="Logo white .jpeg" type="image/x-icon">
  
  <script>

    function validateFirstName() {
      var firstName = document.getElementById("firstName").value;
      var firstNameError = document.getElementById("firstNameError");
      if (firstName.trim() === "") {
        firstNameError.innerText = "First name is required";
        return false;
      } else if (!/^[a-zA-Z]+$/.test(firstName)) {
        firstNameError.innerText = "First name should only contain letters";
        return false;
      } else {
        firstNameError.innerText = "";
        return true;
      }
    }

    function validateLastName() {
      var lastName = document.getElementById("lastName").value;
      var lastNameError = document.getElementById("lastNameError");
      if (lastName.trim() === "") {
        lastNameError.innerText = "Last name is required";
        return false;
      } else if (!/^[a-zA-Z]+$/.test(lastName)) {
        lastNameError.innerText = "Last name should only contain letters";
        return false;
      } else {
        lastNameError.innerText = "";
        return true;
      }
    }

    function validateAge() {
      var age = document.getElementById("age").value;
      var ageError = document.getElementById("ageError");
      if (age === "") {
        ageError.innerText = "Age is required";
        return false;
      } else {
        ageError.innerText = "";
        return true;
      }
    }

    function validateGender() {
      var gender = document.querySelector('input[name="gender"]:checked');
      var genderError = document.getElementById("genderError");
      if (!gender) {
        genderError.innerText = "Gender is required";
        return false;
      } else {
        genderError.innerText = "";
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

    function validatePhone() {
      var phone = document.getElementById("phone").value;
      var phoneError = document.getElementById("phoneError");
      if (phone.trim() === "") {
        phoneError.innerText = "Phone is required";
        return false;
      } else {
        var phonePattern = /^\d{10}$/;
        if (!phonePattern.test(phone)) {
          phoneError.innerText = "Please enter a valid 10-digit phone number";
          return false;
        } else {
          phoneError.innerText = "";
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

    function validateShortBio() {
        var shortBio = document.getElementById("short-bio").value;
        var shortBioError = document.getElementById("shortBioError");
        if (shortBio.trim() === "") {
          shortBioError.innerText = "Short Bio is required";
          return false;
        } else {
          shortBioError.innerText = "";
          return true;
        }
      }
      function validateForm() {
      var isFirstNameValid = validateFirstName();
      var isLastNameValid = validateLastName();
      var isEmailValid = validateEmail();
      var isPasswordValid = validatePassword();
      var isCityValid = validateCity();
      var isAgeValid = validateAge();
      var isGenderValid = validateGender();
      var isPhoneValid = validatePhone();
      var isShortBioValid = validateShortBio();

      return isFirstNameValid && isLastNameValid && isEmailValid && isPasswordValid && isCityValid && isAgeValid && isGenderValid && isPhoneValid && isShortBioValid;
      }

  </script>
</head>

<body>
  <h1>Signup</h1>
  <?php
    // Check if an error message is passed through the URL
    if (isset($_GET['error'])) {
      // Display the error message as an alert
      echo "<script>alert('" . $_GET['error'] . "');</script>";
    }
  ?>
  <form method="POST" action="SignUpN.php" onsubmit="return validateForm()" enctype="multipart/form-data">
    <label for="first_name">First Name<span style="color: red;">*</span>:</label>
    <input type="text" id="first_name" name="first_name" oninput="validateFirstName()">
    <span id="firstNameError" class="error"></span><br><br>

    <label for="last_name">Last Name<span style="color: red;">*</span>:</label>
    <input type="text" id="last_name" name="last_name" oninput="validateLastName()">
    <span id="lastNameError" class="error"></span><br><br>

    <label for="age">Select your age<span style="color: red;">*</span>:</label>
    <select id="age" name="age" onchange="validateAge()">
      <option value="">Please select</option>
      <option value="0-17">Under 18</option>
      <option value="18-30">18-30</option>
      <option value="31-50">31-50</option>
      <option value="51-100">51-100</option>
    </select>
    <span id="ageError" class="error"></span><br><br>

    <label for="gender">Gender<span style="color: red;">*</span>:</label>
    <input type="radio" name="gender" value="male" onchange="validateGender()">Male
    <input type="radio" name="gender" value="female" onchange="validateGender()">Female
    <span id="genderError" class="error"></span><br><br>

    <label for="email">Email<span style="color: red;">*</span>:</label>
    <input type="email" id="email" name="email" oninput="validateEmail()">
    <span id="emailError" class="error"></span><br><br>

    <label for="password">Password<span style="color: red;">*</span>:</label>
    <input type="password" id="password" name="password" oninput="validatePassword()">
    <span id="passwordError" class="error"></span><br><br>

    <label for="photo">Photo:</label>
    <input type="file" id="photo" name="photo"><br><br>

    <label for="phone">Phone<span style="color: red;">*</span>:</label>
    <input type="text" id="phone" name="phone" oninput="validatePhone()">
    <span id="phoneError" class="error"></span><br><br>

    <label for="city">City<span style="color: red;">*</span>:</label>
    <input type="text" id="city" name="city" oninput="validateCity()">
    <span id="cityError" class="error"></span><br><br>

    <label for="short-bio">Short Bio<span style="color: red;">*</span>:</label>
    <input type="text" id="short-bio" name="short-bio" oninput="validateShortBio()">
    <span id="shortBioError" class="error"></span><br><br>

    <input type="submit" value="Sign Up">
    <h5>Already have an account? <a href="loginN.html">Login</a></h5>
  </form>
</body>

</html>