<?php
    session_start();
    require '_database/database.php';
	if (isset($_SESSION['user_username'])) {
        header("location:home.php");
    }
?>