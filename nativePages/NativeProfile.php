<?php
// Start session
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "projectdb";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if 'email' key is set in $_SESSION array
if (!isset($_SESSION['email'])) {
    // User is not logged in, redirect to the login page or display an error message
    header("Location: loginNF.php");
    exit();
}

// Retrieve email from session
$email = $_SESSION['email'];

// Initialize variables
$first_name = "";
$last_name = "";
$age=""; 
$gender="";
$phone ="";
$city = "";
$bio = "";
$photo = "";
$update_success_message = "";
$update_error_message = "";

// Retrieve user information from the database
$sql = "SELECT * FROM language_partners WHERE email = '$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $first_name = $row['first_name'];
    $last_name = $row['last_name'];
    $age = $row['age'];
   $gender =$row['gender'];
   $phone =$row['phone'];
    $city = $row['city'];
    $bio = $row['bio'];
    $photo = $row['photo'];
} else {
    // Handle if no user found with the provided email
    echo "No user found with the provided email";
}

// Update User Information
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_info'])) {
    // Initialize update error message
    $update_error_message = "";

    // Validate first name
    if (!preg_match("/^[a-zA-Z]*$/", $_POST['first_name'])) {
        $update_error_message .= "Error updating user information. ";
    } else {
        $new_first_name = $_POST['first_name'];
    }

    // Validate last name
    if (!preg_match("/^[a-zA-Z]*$/", $_POST['last_name'])) {
        $update_error_message .= "Error updating user information. ";
    } else {
        $new_last_name = $_POST['last_name'];
    }

// Validate age
if (!is_numeric($_POST['age'])) {
    $update_error_message .= "Error updating user information. Age must be a numeric value. ";
} else {
    $new_age = $_POST['age'];
}


// Validate gender
$allowed_genders = array("Male", "Female"); // Add more options if needed
if (!in_array($_POST['gender'], $allowed_genders)) {
    $update_error_message .= "Error updating user information. Invalid gender selected. ";
} else {
    $new_gender = $_POST['gender'];
}
 
// Validate phone
if (!preg_match("/^[0-9]{10}$/", $_POST['phone'])) {
    $update_error_message .= "Error updating user information. Phone number must be a ten-digit number. ";
} else {
    $new_phone = $_POST['phone'];
}

    // Validate city
    if (!preg_match("/^[a-zA-Z]*$/", $_POST['city'])) {
        $update_error_message .= "Error updating user information. ";
    } else {
        $new_city = $_POST['city'];
    }


    // Validate bio
     if (empty($_POST['bio'])) {
    $update_error_message .= "Error updating user information. Bio cannot be empty. ";
     } elseif (strlen($_POST['bio']) > 600) {
    $update_error_message .= "Error updating user information. Bio cannot exceed 600 characters. ";
       } else {
    $new_bio = $_POST['bio'];
         }  
    // If there are no validation errors, update the user's information in the database
    if (empty($update_error_message)) {
        $new_bio = $_POST['bio'];

        // Update the user's information in the database
        $update_info_sql = "UPDATE language_partners SET first_name = '$new_first_name', last_name = '$new_last_name', age= '$new_age' , gender = '$new_gender' ,phone='$new_phone , city = '$new_city', bio = '$new_bio' WHERE email = '$email'";
        if ($conn->query($update_info_sql) === TRUE) {
            // Update successful
            $update_success_message = "User information updated successfully.";
            // Refresh user information
            $first_name = $new_first_name;
            $last_name = $new_last_name;
            $age= $new_age ;
            $gender = $new_gender;
            $phone = $new_phone;
            $city = $new_city;
            $bio = $new_bio;
        } else {
            // Handle error
            $update_error_message = "Error updating user information: " . $conn->error;
        }
    }
    $_SESSION['active_tab'] = 'general';
}

// Update Password
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['change_password'])) {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_new_password = $_POST['confirm_new_password'];

    // Check if current password matches the one in the database
    $check_password_sql = "SELECT password FROM language_partners WHERE email = '$email'";
    $result = $conn->query($check_password_sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashed_password = $row['password'];
        if (password_verify($current_password, $hashed_password)) {
            // Validate new password
            $uppercase = preg_match('@[A-Z]@', $new_password);
            $lowercase = preg_match('@[a-z]@', $new_password);
            $number = preg_match('@[0-9]@', $new_password);
            $specialChars = preg_match('@[^\w]@', $new_password);
            if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($new_password) < 8) {
                $password_change_error_message = "New password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, one number, and one special character.";
            } elseif ($new_password != $confirm_new_password) {
                $password_change_error_message = "New password and confirm password do not match.";
            } else {
                // Update password in the database
                $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);
                $update_password_sql = "UPDATE language_partners SET password = '$hashed_new_password' WHERE email = '$email'";
                if ($conn->query($update_password_sql) === TRUE) {
                    $password_change_success_message = "Password changed successfully.";
                } else {
                    $password_change_error_message = "Error changing password: " . $conn->error;
                }
            }
        } else {
            $password_change_error_message = "Current password is incorrect.";
        }
    } else {
        $password_change_error_message = "Error: No user found.";
    }

    // Store the active tab in a session variable
$_SESSION['active_tab'] = 'change-password';
}

// Delete User Account
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_account'])) {
    // SQL to delete user account
    $delete_sql = "DELETE FROM language_partners WHERE email = '$email'";

    if ($conn->query($delete_sql) === TRUE) {
        // Delete successful
        // Destroy session
        session_destroy();
        // Redirect to home page
        header("Location: ../homePage/HomePage.php");
        exit();
    } else {
        // Handle error
        echo "Error deleting user account: " . $conn->error;
    }
}

// Close database connection
$conn->close();
?>


<!--Website: wwww.codingdung.com-->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="shortcut icon" href="../homePage/Logo white .jpeg" type="image/x-icon">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" hreflink rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous"="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'> <!--to use icons -->
<link rel="stylesheet" href="NativeProfile.css">
<link rel="" href="../LearnerPages/HomePageLerner.css">
</head>

<body>
    <header>
        <div class="logo">
            <img src="../homePage/logo bule.jpeg">
            <h1>Talk Tandem</h1>
        </div>

        <nav class="mainMenu">
            <ul>
                <li><a href="HomePageNative.php">Home</a></li>

                <li class="dropdown">
                    <a href="#">Requests</a>
                    <div class="dropdown-content">
                        <a href="LearningRequestList.php">Request List</a>
                        <a href="HomePageNative.php##view_Request"> Request Status</a>
                        <a href="HomePageNative.php#Accept-Rej">Learner Requests</a>
                    </div> 
                </li>
                <li class="dropdown">
                <a href="#">View</a>
                <div class="dropdown-content">
                    <a href="PreviousSessionsN.php">Previous Session</a>
                    <a href="CuSessionN.php">Current Session</a>
                    <a href="viewReviews.php">Reviews</a>
                </div>
                </li>
                
                <li><a href="NativeProfile.php">Manage Profile</a></li>
             
                <li><a href="signOutN.php">Sign Out</a></li>
            </ul> 
        </nav>
        
    </header>







    <div class="container light-style flex-grow-1 container-p-y">
        <h4 class="font-weight-bold py-3 mb-4">
           Manage Profile
        </h4>
        <div class="card overflow-hidden">
            <div class="row no-gutters row-bordered row-border-light">
                <div class="col-md-3 pt-0">
                    <div class="list-group list-group-flush account-settings-links">
                        <a class="list-group-item list-group-item-action active" data-toggle="list"
                            href="#account-general">General</a>
                        <a class="list-group-item list-group-item-action" data-toggle="list"
                            href="#account-change-password">Change password</a>
                            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                            <button type="submit" class="list-group-item list-group-item-action" name="delete_account"
                                onclick="return confirm('Are you sure you want to delete your account?')">Delete
                                account</button>
                        </form>
                       
                    </div>
                </div>
                <!-- Main content -->
                <div class="col-md-9">
                    <div class="tab-content">

                             <!-- General tab -->
                        <div class="tab-pane fade active show" id="account-general">
                            <div class="card-body media align-items-center">

                              <!-- Display learner's information here -->
                                <div class="media-body ml-4">
                                    <!-- Success message -->
                                    <?php if (!empty($update_success_message)): ?>
                                        <div class="alert alert-success" role="alert">
                                            <?php echo $update_success_message; ?>
                                        </div>
                                    <?php endif; ?>
                                      <!-- Error message -->
                                    <?php if (!empty($update_error_message)): ?>
                                        <div class="alert alert-danger" role="alert">
                                            <?php echo $update_error_message; ?>
                                        </div>
                                    <?php endif; ?>
                                 <!-- Profile photo -->
                                    <div class="form-group">
                                    <label class="btn-outline-primary" style="padding-bottom: 10px;">
                                        <a href="#" id="upload-photo-link">
                                        <img src="<?php echo $photo ? "../homePage/$photo" : '../LearnerPages/4325945.png'; ?>"
                                                    class="d-block ui-w-80">
                                        </a>new photo
                                        <input type="file" class="account-settings-fileinput" style="display: none;">
                                    </label>
                                    </div>
                                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

                             <!-- First name -->
                             <div class="form-group" style="margin-top: 3%;">
                                            <label class="form-label">First Name</label>
                                            <input type="text" class="form-control" name="first_name"
                                                value="<?php echo $first_name; ?>">
                                        </div>
                                        <!-- Last name -->
                                        <div class="form-group">
                                            <label class="form-label">Last Name</label>
                                            <input type="text" class="form-control" name="last_name"
                                                value="<?php echo $last_name; ?>">
                                        </div>
                                        <!-- Age -->
                                        <div class="form-group">
                                            <label class="form-label">Age</label>
                                            <input type="number" class="form-control" name="age"
                                                value="<?php echo $age; ?>">
                                        </div>
                                        <!-- gender -->
                                        <div class="gender-group">
                                            <label class="form-label">Gender</label>
                                            <input type="text" class="form-control" name="gender"
                                                value="<?php echo $gender; ?>">
                                        </div>
                                       <!-- email -->
                                       <div class="form-group">
                                            <label class="form-label">Email</label>
                                            <input type="text" class="form-control" name="email"
                                                value="<?php echo $email; ?>">
                                        </div>
                                        <!-- phone -->
                                        <div class="form-group">
                                            <label class="form-label">Phone number </label>
                                            <input type="text" class="form-control" name="phone"
                                                value="<?php echo $phone; ?>">
                                        </div>

                                        <!-- City -->
                                        <div class="form-group">
                                            <label class="form-label">City</label>
                                            <input type="text" class="form-control" name="city"
                                                value="<?php echo $city; ?>">
                                        </div>
                                        <!-- bio -->
                                        <div class="form-group">
                                            <label class="form-label">Short bio</label>
                                            <input type="text" class="form-control" name="bio"
                                                value="<?php echo $bio; ?>">
                                        </div>
                                        <!-- Update button -->
                                        <button type="submit" class="btn btn-primary" name="update_info">Update
                                            Information</button>
                                    </form>
                                </div>
                            </div>
                        </div>      
                          <!-- Change Password tab -->
                        <div class="tab-pane fade" id="account-change-password">
                            <div class="card-body">
                            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                    <!-- Error message -->
                                    <?php if (!empty($password_change_error_message)): ?>
                                        <div class="alert alert-danger" role="alert">
                                            <?php echo $password_change_error_message; ?>
                                        </div>
                                    <?php endif; ?>
                                    <!-- Success message -->
                                    <?php if (!empty($password_change_success_message)): ?>
                                        <div class="alert alert-success" role="alert">
                                            <?php echo $password_change_success_message; ?>
                                        </div>
                                    <?php endif; ?>
                                    <div class="form-group">
                                        <label class="form-label">Current Password</label>
                                        <input type="password" class="form-control" name="current_password" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">New Password</label>
                                        <input type="password" class="form-control" name="new_password" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Confirm New Password</label>
                                        <input type="password" class="form-control" name="confirm_new_password"
                                            required>
                                    </div>
                                    <button type="submit" class="btn btn-primary" name="change_password">Update
                                        Password</button>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>  

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



<!--  set the active tab -->
<script>
    // Check if there's an active tab stored in session
    var activeTab = "<?php echo isset($_SESSION['active_tab']) ? $_SESSION['active_tab'] : 'general'; ?>";

    // Show the active tab
    $('.nav-link[href="#' + activeTab + '"]').tab('show');

</script>

    <script>
        // Function to hide error and success messages after a certain duration
        function hideMessages() {
            // Select error and success message elements
            var errorMessage = document.querySelector('.alert-danger');
            var successMessage = document.querySelector('.alert-success');

            // Check if error message exists and hide after 5 seconds
            if (errorMessage) {
                setTimeout(function () {
                    errorMessage.style.display = 'none';
                }, 5000); //5000 milliseconds = 5 seconds
            }

            // Check if success message exists and hide after 5 seconds
            if (successMessage) {
                setTimeout(function () {
                    successMessage.style.display = 'none';
                }, 5000); // 5000 milliseconds = 5 seconds
            }
        }

        // Call the hideMessages function when the page is loaded
        window.onload = hideMessages;
    </script>

</body>

</html>
