<?php
    session_start();
    include '../_database/database.php';
    if(isset($_REQUEST['signup_button'])){
        $user_email=$_REQUEST['user_email'];
        $user_firstname=$_REQUEST['user_firstname'];
        $user_username=$_REQUEST['user_username'];
        $user_password=$_REQUEST['user_password'];
		$user_th=$_REQUEST['user_th'];
        $sql="INSERT INTO user(user_firstname,user_email,user_username,user_password,user_avatar,user_th) VALUES('$user_firstname','$user_email','$user_username','$user_password','default.jpg','$user_th')";
        mysqli_query($database,$sql) or die(mysqli_error($database));
        $_SESSION['user_username'] = $user_username;
        header('Location: ../edit-profile.php');
    }
?>
