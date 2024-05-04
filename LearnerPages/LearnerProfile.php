
<?php
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
} else {
    echo "Connection successful"; 
}

// Check if 'email' key is set in $_SESSION array
if(isset($_SESSION['email'])) {
    // User is logged in, retrieve their email from the session
    $email = $_SESSION['email'];
    // Now you can safely use $email variable to fetch user data from the database and display their profile
} else {
    // User is not logged in, redirect to the login page or display an error message
    header("Location: loginLF.php");
    exit();
}


$sql = "SELECT * FROM language_learners WHERE email = '$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $first_name = $row['first_name'];
    $last_name = $row['last_name'];
    $city = $row['city'];
    $location = $row['location'];
    
} else {
    // If no user found with the provided email, handle it accordingly
    echo "No user found with the provided email";
}

// Change Password
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['change_password'])) {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_new_password = $_POST['confirm_new_password'];

    // Retrieve current password from the database
    $password_sql = "SELECT password FROM language_learners WHERE email = '$email'";
    $password_result = $conn->query($password_sql);

    if ($password_result->num_rows > 0) {
        $row = $password_result->fetch_assoc();
        $stored_password = $row['password'];
        
        // Verify current password
        if (password_verify($current_password, $stored_password)) {
            // Check if new password matches the confirm password
            if ($new_password === $confirm_new_password) {
                // Hash the new password
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

                // Update the password in the database
                $update_password_sql = "UPDATE language_learners SET password = '$hashed_password' WHERE email = '$email'";
                if ($conn->query($update_password_sql) === TRUE) {
                    echo "Password changed successfully";
                } else {
                    echo "Error changing password: " . $conn->error;
                }
            } else {
                echo "New password and confirm password do not match";
            }
        } else {
            echo "Current password is incorrect";
        }
    } else {
        echo "Error: Unable to retrieve current password";
    }
}

// Delete Account
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_account'])) {
    // Delete the account from the database
    $delete_sql = "DELETE FROM language_learners WHERE email = '$email'";
    if ($conn->query($delete_sql) === TRUE) {
        // Perform any additional cleanup or logout operations here
        echo "Account deleted successfully";
    } else {
        echo "Error deleting account: " . $conn->error;
    }
}

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
                <li><a href="#">Home</a></li>

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
                    <a href="PreviousSession.html">Previous Session</a>
                    <a href="CuSession.html">Current Session</a>
                    <a href="RateReviews .html">Rate and review</a>
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

                <div class="col-md-9">
                    <div class="tab-content">

                        <!--        profile photo       -->

                        <div class="tab-pane fade active show" id="account-general">
                            <div class="card-body media align-items-center">
                                <div class="media-body ml-4">
                                    <!-- Display learner's information here -->
                                    <div class="form-group">
                                        <label class="form-label">First name</label>
                                        <input type="text" class="form-control mb-1" value="<?php echo $first_name; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Last Name</label>
                                        <input type="text" class="form-control" value="<?php echo $last_name; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">E-mail</label>
                                        <input type="text" class="form-control mb-1" value="<?php echo $email; ?>">
                                        <div class="alert alert-warning mt-3">
                                            Your email is not confirmed. Please check your inbox.<br>
                                            <a href="javascript:void(0)">Resend confirmation</a>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">City</label>
                                        <input type="text" class="form-control" value="<?php echo $city; ?>">
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">Location</label>
                                        <input type="text" class="form-control" value="<?php echo $location; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Change PASSWORD  -->

                        <div class="tab-pane fade" id="account-change-password">
                            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                <div class="card-body pb-2">
                                    <div class="form-group">
                                        <label class="form-label">Current password</label>
                                        <input type="password" class="form-control" name="current_password" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">New password</label>
                                        <input type="password" class="form-control" name="new_password" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">confirm new password</label>
                                        <input type="password" class="form-control" name="confirm_new_password" required>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary" name="change_password">Change
                                    Password</button>
                            </form>
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
            <a href="https://www.instagram.com/talktandem" class="icon instagram"><i
                    class="fab fa-instagram"></i></a>
            <a href="https://www.linkedin.com/talktandem" class="icon linkedin"><i class="fab fa-linkedin"></i></a>
            <a href="mailto:contact@talktandem.com" class="icon email"><i class="far fa-envelope"></i></a>
        </div>
        <p class="copyright">© 2024 Talk Tandem. All rights reserved.</p>
    </footer>
</body>

</html>
