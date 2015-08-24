<?php session_start();
    require '_database/database.php';
	$title_user = $rws['user_title'];
	if ($title_user == 3 || $title_user == 4){
        header("location:home.php");
    }
?>