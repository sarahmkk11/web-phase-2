<?php
// Connect to your MySQL database
$servername = "localhost"; // Change this to your database server name
$username = "root"; // Change this to your database username
$password = ""; // Change this to your database password
$dbname = "projectdb"; // Change this to your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $partner = $_POST["partner"];
    $rating = $_POST["rating"];
    $comment = $_POST["comment"];

    // Insert the new review into the database
    $sql = "INSERT INTO user_reviews (username, partner, rating, comment) VALUES ('$username', '$partner', '$rating', '$comment')";
    if ($conn->query($sql) === TRUE) {
        echo '<script>openModal();</script>';
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Fetch data from the database
$sql = "SELECT * FROM user_reviews";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Talk Tandem Website Reviews</title>
    <!-- Include your CSS stylesheets -->
    <link rel="stylesheet" href="RateReviews.css">
    <style>
        /* Your additional CSS styles here */
    </style>
</head>
<body>
    <header>
         <div class="logo">
            <img src="../homePage/logo bule.jpeg" alt="Logo">
            <h1>Talk Tandem</h1>
        </div>

        <nav class="mainMenu">
            <ul>
                <li><a href="HomePageNative.php">Home</a></li>
                <li class="dropdown">
                    <a href="#">Requests</a>
                    <div class="dropdown-content">
                        <a href="LearningRequestList.php">Request List</a>
                        <a href="HomePageNative.php##view_Request">Request Status</a>
                        <a href="HomePageNative.php#Accept-Rej">Learner Requests</a>
                    </div>
                </li>
                <li class="dropdown">
                    <a href="#">View</a>
                    <div class="dropdown-content">
                        <a href="PreviousSessions.php">Previous Session</a>
                        <a href="CuSession.php">Current Session</a>
                        <a href="RateReviews.php">Reviews</a>
                    </div>
                </li>
                <li><a href="NativeProfile.php">Manage Profile</a></li>
                <li><a href="../homePage/HomePage.php">Sign Out</a></li>
            </ul>
        </nav>
    </header>
    </header>
    <div class="container">
        <h1>Talk Tandem Website Reviews</h1>

        <!-- Form for submitting reviews -->
        <form id="reviewForm" method="post">
            <h2>Write a Review</h2>
            <label for="username">Your Name:</label>
            <input type="text" id="username" name="username" required>
            <label for="partner">Partner Name:</label>
            <input type="text" id="partner" name="partner" required>
            <label for="rating">Rating (1-5):</label>
            <input type="number" id="rating" name="rating" min="1" max="5" required>
            <label for="comment">Your Review:</label>
            <textarea id="comment" name="comment" rows="4" required></textarea>
            <input type="submit" value="Submit Review">
        </form>

        <!-- Display existing reviews -->
        <div class="reviews">
            <h2>Previous Reviews and Ratings</h2>
            <?php
            // Check if there are any reviews
            if ($result->num_rows > 0) {
                // Output data of each row
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

        <!-- The Modal -->
        <div id="myModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal()">&times;</span>
                <p>Thank you for your rating! We appreciate your opinion 💌</p>
            </div>
        </div>
    </div>

    <footer>
        <!-- Your footer content here -->
    </footer>

    <!-- Include your JavaScript code -->
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
    </script>
</body>
</html>

<?php
// Close database connection
$conn->close();
?>
