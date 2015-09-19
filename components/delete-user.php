<?php
    ini_set("display_errors",1);
    session_start();
    if(isset($_POST)){
        require '../_database/database.php';
		$user_username_user = $_REQUEST['user_username_user'];
  $sql3="DELETE FROM user WHERE user_username='$user_username_user' LIMIT 1";
            mysqli_query($database,$sql3)or die(mysqli_error($database));
            header("location:../home.php");
    }    
?>