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
    header("Location: loginLF.php");
    exit();
}

// Retrieve email from session
$email = $_SESSION['email'];

// Initialize variables
$first_name = "";
$last_name = "";
$city = "";
$location = "";
$photo = "";
$update_success_message = "";
$update_error_message = "";

// Retrieve user information from the database
$sql = "SELECT * FROM language_learners WHERE email = '$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $first_name = $row['first_name'];
    $last_name = $row['last_name'];
    $city = $row['city'];
    $location = $row['location'];
    $photo = $row['photo'];
} else {
    // Handle if no user found with the provided email
    echo "No user found with the provided email";
}

// Update User Information
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_info'])) {
    // Initialize update error message
    $update_error_message = "";

    // Handle photo upload if file is present
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $photo_tmp_name = $_FILES['photo']['tmp_name'];
        $photo_name = $_FILES['photo']['name'];
        $photo_destination = "../homePage/uploads/$photo_name"; // Adjusted destination path

        // Move uploaded file to desired destination
        if (!move_uploaded_file($photo_tmp_name, $photo_destination)) {
            $update_error_message .= "Error uploading photo. ";
        } else {
            // Update the photo field in the database
            $photo_update_sql = "UPDATE language_learners SET photo = '$photo_name' WHERE email = '$email'";
            if ($conn->query($photo_update_sql) !== TRUE) {
                $update_error_message .= "Error updating photo. ";
            }
        }
    }

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

    // Validate city
    if (!preg_match("/^[a-zA-Z]*$/", $_POST['city'])) {
        $update_error_message .= "Error updating user information. ";
    } else {
        $new_city = $_POST['city'];
    }

    // If there are no validation errors, update the user's information in the database
    if (empty($update_error_message)) {
        $new_location = $_POST['location'];

        // Update the user's information in the database
        $update_info_sql = "UPDATE language_learners SET first_name = '$new_first_name', last_name = '$new_last_name', city = '$new_city', location = '$new_location' WHERE email = '$email'";
        if ($conn->query($update_info_sql) === TRUE) {
            // Update successful
            $update_success_message = "User information updated successfully.";
            // Refresh user information
            $first_name = $new_first_name;
            $last_name = $new_last_name;
            $city = $new_city;
            $location = $new_location;
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
    $check_password_sql = "SELECT password FROM language_learners WHERE email = '$email'";
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
                $update_password_sql = "UPDATE language_learners SET password = '$hashed_new_password' WHERE email = '$email'";
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
    $delete_sql = "DELETE FROM language_learners WHERE email = '$email'";

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






<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css"
        integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'> <!--to use icons -->
    <link rel="shortcut icon" href="../homePage/Logo white .jpeg" type="image/x-icon">
    <link rel="stylesheet" href="LearnerProfile.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <header>
        <div class="logo">
            <img src="../homePage/logo bule.jpeg">
            <h1>Talk Tandem</h1>
        </div>

        <nav class="mainMenu">
            <ul>
                <li><a href="LearnerProfile.php">Home</a></li>

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
                        <a href="PartnerList.html">Language Partners</a>
                        <a href="PreviousSession.php">Previous Session</a>
                        <a href="CuSession.php">Current Session</a>
                        <a href="RateReviews .php">Rate and review</a>
                    </div>
                </li>

                <li><a href="LearnerProfile.php">Manage Profile</a></li>

                <li><a href="signOutL.php">Sign Out</a></li>
            </ul>
        </nav>

    </header>


    <div class="container light-style flex-grow-1 container-p-y">

        <h4 class="font-weight-bold py-3 mb-4">
            Manage Profile
        </h4>
        <div class="card overflow-hidden">
            <div class="row no-gutters row-bordered row-border-light">
                <!-- Sidebar -->
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
                                                <img src="<?php echo $photo ? "../homePage/$photo" : '../LearnerPages/4325945.png'; ?>"id="profile-photo" class="d-block ui-w-80">
                                            </a>
                                            <span class="upload-text" style="color: white;">Upload New Photo</span>
                                            <input type="file" class="account-settings-fileinput" name="photo"
                                                accept="image/*" style="display: none; ">
                                        </label>
                                    </div>

                                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                        <!-- First name -->
                                        <div class="form-group" style="margin-top: -3%;">
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
                                        <!-- email -->
                                        <div class="form-group">
                                            <label class="form-label">Email</label>
                                            <input type="text" class="form-control" name="email"
                                                value="<?php echo $email; ?>">
                                        </div>
                                        <!-- City -->
                                        <div class="form-group">
                                            <label class="form-label">City</label>
                                            <input type="text" class="form-control" name="city"
                                                value="<?php echo $city; ?>">
                                        </div>
                                        <!-- Location -->
                                        <div class="form-group">
                                            <label class="form-label">Location</label>
                                            <input type="text" class="form-control" name="location"
                                                value="<?php echo $location; ?>">
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
    <script>
        // Function to handle click event on profile photo
        document.getElementById('upload-photo-link').addEventListener('click', function () {
            document.getElementById('photo-upload-input').click();
        });


    </script>



</body>

</html>
