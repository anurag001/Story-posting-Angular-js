<?php

$con = mysqli_connect("localhost", "anurag", "anurag1234", "test");

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

if (isset($_POST["title"]) && isset($_POST["story"]) && isset($_POST["id"])) {
    $title = $_POST["title"];
    $story = $_POST["story"];
    $id = $_POST["id"];

    if ($title != "" && $story != "" && $id != "") {
        $query = mysqli_query($con, "UPDATE stories SET title='$title',story='$story' WHERE id=$id");
        if ($query) {
           echo "Your post is updated successfully";
        } else {
           echo "Error in updation of your post";
        }
    } else {
        echo "Please provide both the fields";
    }
}

?>

