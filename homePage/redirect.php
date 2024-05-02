<?php
if(isset($_GET['page'])) {
    $page = $_GET['page'];
    header("Location: $page");
    exit;
} else {
    // If page parameter is not set, redirect to a default page or display an error message.
    header("Location: error.php");
    exit;
}
?>
