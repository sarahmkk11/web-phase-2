<?php
session_start(); // Start the session to access session variables

// Step 1: Connect to the MySQL database
$servername = "localhost";
$username = "root"; // Your MySQL username
$password = ""; // Your MySQL password
$dbname = "projectdb"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get language partner email from session
if (isset($_SESSION['email'])) {
    $language_partner_email = $_SESSION['email'];
} else {
    // If session variable not set, handle accordingly (redirect, error message, etc.)
    echo "Language partner email not found in session.";
    exit; // Stop further execution
}

// Step 2: Execute query to select reviews for the language partner email
$sql = "SELECT * FROM user_reviews WHERE language_partners_email = '$language_partner_email'";
$result = $conn->query($sql);

// Step 3: Fetch and display reviews
if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        echo '<div class="review">';
        echo '<strong>' . $row["partner"] . '</strong>'; // Assuming "partner" corresponds to partner name
        echo '<span class="rating">Rating: ' . $row["rating"] . '</span>';
        echo '<p>"' . $row["comment"] . '"</p>';
        echo '</div>';
    }
} else {
    echo "No reviews found for language partner with email: $language_partner_email";
}

// Close connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'> <!--to use icons -->
    <link rel="shortcut icon" href="Logo white .jpeg" type="image/x-icon">
    <link rel="stylesheet" href="viewReviews.css">
    <title>View Reviews</title>
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
             
                <li><a href="../homePage/HomePage.php">Sign Out</a></li>
            </ul> 
        </nav>
    </header>

    <div class="container">
        <!-- Display existing reviews -->
        <div class="reviews">
            <h1>Previous Reviews and Ratings</h1>
            
        </div>

        <!-- The Modal -->
        <div id="myModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal()">&times;</span>
                <p>Thank you for your rating! We appreciate your opinion 💌</p>
            </div>
        </div>
    </div>

    <footer>
        <div class="social-icons">
            <a href="https://www.facebook.com/talktandem" class="icon facebook"><i class="fab fa-facebook"></i></a>
            <a href="https://www.twitter.com/talktandem" class="icon twitter"><i class="fab fa-twitter"></i></a>
            <a href="https://www.instagram.com/talktandem" class="icon instagram"><i class="fab fa-instagram"></i></a>
            <a href="https://www.linkedin.com/talktandem" class="icon linkedin"><i class="fab fa-linkedin"></i></a>
            <a href="mailto:contact@talktandem.com" class="icon email"><i class="far fa-envelope"></i></a>
        </div>
        <p class="copyright">©️ 2024 Talk Tandem. All rights reserved.</p>
    </footer>  

    <script>
        // Get the modal
        var modal = document.getElementById('myModal');

        // Function to display modal
        function openModal() {
            modal.style.display = 'block';
        }

        // Function to close modal
        function closeModal() {
            modal.style.display = 'none';
        }

        // Function to handle form submission
        document.getElementById('reviewForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent the default form submission

            // Get form data
            var username = document.getElementById('username').value;
            var rating = document.getElementById('rating').value;
            var comment = document.getElementById('comment').value;

            // Create review element
            var reviewElement = document.createElement('div');
            reviewElement.classList.add('review');
            reviewElement.innerHTML = '<strong>' + username + '</strong>' +
                                      '<span class="rating">Rating: ' + rating + '</span>' +
                                      '<p>"' + comment + '"</p>';

            // Append review to reviews container
            document.querySelector('.reviews').appendChild(reviewElement);

            // Clear form fields
            document.getElementById('username').value = '';
            document.getElementById('rating').value = '';
            document.getElementById('comment').value = '';

            // Display modal
            openModal();
        });
    </script>
</body>
</html>
