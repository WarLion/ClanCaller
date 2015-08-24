<?php
    ini_set("display_errors",1);
    session_start();
    if(isset($_POST)){
        require '../_database/database.php';
		$user_username = $_POST['user_username'];
  $sql3="DELETE FROM user WHERE user_username='$user_username' LIMIT 1";
            mysqli_query($database,$sql3)or die(mysqli_error($database));
            header("location:../home.php");
    }    
?>