<?php
    $roomID = $_GET['roomID'];
    $userID = $_GET['playerID'];
    include("function.php");
    echo getRoom($roomID);
?>