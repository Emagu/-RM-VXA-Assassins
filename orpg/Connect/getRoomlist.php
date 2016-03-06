<?php
    include("connection.php");
    $query="SELECT * FROM `room`;";
    $result = mysqli_query($connect, $query);
    $Data = Array();
    while($row = mysqli_fetch_row($result)){
		array_push($Data,$row);
    }
    echo json_encode($Data);
?>