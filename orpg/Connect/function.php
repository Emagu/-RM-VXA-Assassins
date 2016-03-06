<?php
    function getUser($Ip){
        $Ipmd5 = md5($Ip);
        include("connection.php");
        $query="SELECT `NO` FROM `user` WHERE `IP` = '$Ipmd5';";
        $res = mysqli_query($connect, $query);
        $row = mysqli_fetch_row($res);
        mysqli_close($connect);
        return $row[0];
    }
    function updateUser($ID){
        include("connection.php");
        $datetime = date ("Y-m-d H:i:s" , mktime(date('H')+8, date('i'), date('s'), date('m'), date('d'), date('Y')));
        $query="UPDATE `user` SET lastDate = '$datetime' WHERE `NO` = '$ID';";
        if(mysqli_query($connect, $query)) {
            mysqli_close($connect);
            return "OK,".$ID;   
        }else{
            mysqli_close($connect);
            return "Error,0";  
        } 
    }
    function addUser($Ip){
        include("connection.php");
        $Ipmd5 = md5($Ip);
        $datetime = date ("Y-m-d H:i:s" , mktime(date('H')+8, date('i'), date('s'), date('m'), date('d'), date('Y')));
        $query="INSERT INTO `user` VALUES ('','$Ipmd5','0','$datetime');";
        $id = 0;
        if(mysqli_query($connect, $query)){
            $id = mysqli_insert_id($connect);
            mysqli_close($connect);
            return "OK,".$id;
        }else{
            mysqli_close($connect);
            return "Error".$id;
        }
    }
    function addRoom($ID){
        include("connection.php");
        $query="INSERT INTO `room` VALUES ('','room.$ID','$ID','0');";
        $id = 0;
        if(mysqli_query($connect, $query)){
            $id = mysqli_insert_id($connect);
            mysqli_close($connect);
            return "OK,".$id;
        }else{
            mysqli_close($connect);
            return "Error".$id;
        }
    }
    function getRoom($ID){
        include("connection.php");
        $query="SELECT * FROM `room` WHERE `NO` = $ID;";
        $res = mysqli_query($connect, $query);
        $row = mysqli_fetch_row($res);
        mysqli_close($connect);
        return json_encode($row);
    }
    function enterRoom($userID,$roomID){
        include("connection.php");
        $datetime = date ("Y-m-d H:i:s" , mktime(date('H')+8, date('i'), date('s'), date('m'), date('d'), date('Y')));
        $query="UPDATE `user` SET lastDate = '$datetime' WHERE `NO` = '$userID';";//USER時間覆蓋
        if(mysqli_query($connect, $query)) {
            $query="UPDATE `user` SET RoomID = '$roomID' WHERE `NO` = '$userID';";//USER所在房間覆蓋
            if(mysqli_query($connect, $query)) {
                $query="UPDATE `room` SET Number = Number + 1 WHERE `NO` = '$roomID';";//房間人數改變
                if(mysqli_query($connect, $query)) {
                    return getRoom($roomID);
                }else{
                    mysqli_close($connect);
                    return "Error";
                }
            }else{
                mysqli_close($connect);
                return "Error";
                
            }
        }else{
            mysqli_close($connect);
            return "Error";  
        } 
    }
    function quitRoom($userID,$roomID){
        include("connection.php");
        $datetime = date ("Y-m-d H:i:s" , mktime(date('H')+8, date('i'), date('s'), date('m'), date('d'), date('Y')));
        $query="UPDATE `user` SET lastDate = '$datetime' WHERE `NO` = '$userID';";//USER時間覆蓋
        if(mysqli_query($connect, $query)) {
            $query="UPDATE `user` SET RoomID = '' WHERE `NO` = '$userID';";//USER所在房間覆蓋
            if(mysqli_query($connect, $query)) {
                $query="SELECT `Number` FROM `room` WHERE `NO` = '$roomID';";//room房間人數檢查
                $res = mysqli_query($connect, $query);
                $row = mysqli_fetch_row($res);
                if($row[0] > 1) {
                    $query="UPDATE `room` SET Number = Number - 1 WHERE `NO` = '$roomID';";//房間人數改變
                    if(mysqli_query($connect, $query)) {
                        mysqli_close($connect);
                        return "OK";
                    }else{
                        mysqli_close($connect);
                        return "Error";
                    }
                }else if($row[0] == 1){
                    $query = "DELETE FROM `room` WHERE `NO` = '$roomID';";
                    if(mysqli_query($connect, $query)) {
                        mysqli_close($connect);
                        return "OK";
                    }else{
                        mysqli_close($connect);
                        return "Error";
                    }
                }else{
                    mysqli_close($connect);
                    return "Error";
                }
            }else{
                mysqli_close($connect);
                return "Error";
                
            }
        }else{
            mysqli_close($connect);
            return "Error";  
        } 
    }
?>