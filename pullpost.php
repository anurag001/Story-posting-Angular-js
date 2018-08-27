<?php

$con = mysqli_connect("localhost", "anurag", "anurag1234", "test");

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
//Initialize array variable
$data = array();

$sql = "select * from stories order by id desc";

$result = mysqli_query($con, $sql);

if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
}

echo json_encode($data);

?>

