<?php
session_start(); 
$user_email = $_SESSION['email']; 


$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "projectdb"; 


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $partner = $_POST["partner"];
    $rating = $_POST["rating"];
    $comment = $_POST["comment"];

    
    $sql = "INSERT INTO user_reviews (username, partner, rating, comment, language_Learner_email) VALUES ('$username', '$partner', '$rating', '$comment', '$user_email')";
    if ($conn->query($sql) === TRUE) {
        echo '<script>openModal();</script>';
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}


if(isset($_POST['partner'])) {
    $partner = $_POST['partner'];
    $sql = "SELECT * FROM user_reviews WHERE language_Learner_email = '$user_email' AND partner = '$partner'";
} else {
    $sql = "SELECT * FROM user_reviews WHERE language_Learner_email = '$user_email'";
}

$result = $conn->query($sql);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Talk Tandem Website Reviews</title>

    <link rel="stylesheet" href="RateReviews.css">
    <style>
        
    </style>
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

                <li class="dropdown">
                    <a href="HomePageLerner.php#Request">Request</a>
                    <div class="dropdown-content">
                        <a href="HomePageLerner.php#new-Request">New</a>
                        <a href="HomePageLerner.php#Current">Current</a>
                    </div> 
                </li>
                <li class="dropdown">
                <a href="#">View</a>
                <div class="dropdown-content">
                    <a href="PartnerList.php">Language Partners</a>
                    <a href="PreviousSession.php">Previous Session</a>
                    <a href="CuSession.php">Current Session</a>
                    <a href="RateReviews.php">Rate and review</a>
                </div>
                </li>
                
                <li><a href="LearnerProfile.php">Manage Profile</a></li>
             
                <li><a href="../homePage/HomePage.php">Sign Out</a></li>
            </ul> 
        </nav>
    </header>
    <div class="container">
        <h1>Talk Tandem Website Reviews</h1>


        <form id="reviewForm" method="post">
            <h2>Write a Review</h2>
            <label for="username">Your Name:</label>
            <input type="text" id="username" name="username" required>
            <label for="partner">Partner Name:</label>
            <input type="text" id="partner" name="partner" required>
            <label for="rating">Rating (1-5) "5 is the best":</label>
            <input type="number" id="rating" name="rating" min="1" max="5" required>
            <label for="comment">Your Review:</label>
            <textarea id="comment" name="comment" rows="4" required></textarea>
            <input type="submit" value="Submit Review">
        </form>


        <div class="reviews">
            <h2>Previous Reviews and Ratings</h2>
            <?php
            
            if ($result->num_rows > 0) {
                
                while($row = $result->fetch_assoc()) {
                    echo '<div class="review">';
                    echo '<strong>' . $row["username"] . '</strong> <span class="partner-label">For:</span> <span class="partner">' . $row["partner"] . '</span>';
                    echo '<span class="rating">Rating: ' . $row["rating"] . '</span>';
                    echo '<p>"' . $row["comment"] . '"</p>';
                    echo '</div>';
                }
            } else {
                echo "<p>No reviews found.</p>";
            }
            ?>
        </div>

        
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
    <p class="copyright">© 2024 Talk Tandem. All rights reserved.</p>
    </footer>
    </footer>

 
    <script>
      
        var modal = document.getElementById('myModal');

    
        function openModal() {
            modal.style.display = 'block';
        }

        
        function closeModal() {
            modal.style.display = 'none';
        }
    </script>
</body>
</html>

<?php

$conn->close();
?>
