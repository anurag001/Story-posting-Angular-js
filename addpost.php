<?php

$con = mysqli_connect("localhost", "anurag", "anurag1234", "test");

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

if (isset($_POST["title"]) && isset($_POST["story"])) {
    $title = $_POST["title"];
    $story = $_POST["story"];
    
    if ($title != "" && $story != "") {
        $query = mysqli_query($con, "INSERT INTO stories(title,story) 
VALUES ('$title','$story')");
        if ($query) {
           echo "Your story is posted successfully";
        } else {
           echo "Error in posting your stories";
        }
    } else {
        echo "Please provide both the fields";
    }
}
?>

