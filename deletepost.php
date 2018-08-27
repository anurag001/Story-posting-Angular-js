<?php

$con = mysqli_connect("localhost", "anurag", "anurag1234", "test");

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

if (isset($_POST["id"]) && $_POST["id"] != "") {
    $id = $_POST["id"];


    $query = mysqli_query($con, "delete from stories where id=$id");
    if ($query) {
        echo "Story is deleted successfully";
    } else {
        echo "Error in deletion";
    }
} else {
    echo "Invalid id";
}

?>

