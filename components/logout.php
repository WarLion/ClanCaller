<?php
    session_start();
    require '../_database/database.php';
    session_destroy();
	setcookie("user_username","",time() - (86400 * 30), "/");
    header('location:../index.php');
?>