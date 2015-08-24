<?php
    ini_set("display_errors",1);
    session_start();
    if(isset($_POST)){
        require '../_database/database.php';
		$user_username = $_GET['user_username'];
        $user_title=$_REQUEST['user_title'];
        $sql3="UPDATE user SET user_title='$user_title' WHERE user_username='$user_username'";
            mysqli_query($database,$sql3)or die(mysqli_error($database));
            header("location:../profile.php?user_username=".$user_username);
    }    
?>