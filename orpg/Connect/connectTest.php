<?php
    //echo $_SERVER['HTTP_CLIENT_IP'].",".$_SERVER['HTTP_X_FORWARDED_FOR'].",".$_SERVER['REMOTE_ADDR'];
    if(!empty($_SERVER['HTTP_CLIENT_IP'])){
       $myip = $_SERVER['HTTP_CLIENT_IP'];
    }else if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
       $myip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }else{
       $myip= $_SERVER['REMOTE_ADDR'];
    }
    include("function.php");
    $ID = getUser($myip);
    if($ID){
        echo updateUser($ID);
    }else{
        echo addUser($myip);  
    }
?>