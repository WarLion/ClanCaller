<?php
    session_start();
	if(!isset($_SESSION['user_username']))
{
header("location:login.php");
}
    require '_database/database.php';
    $user_username=$_SESSION['user_username'];
	$ban_sql = "SELECT * FROM user WHERE user_username='$user_username'";
    $checkband_result = mysqli_query($database,$ban_sql);
    while($checkban = mysqli_fetch_array($checkband_result,MYSQLI_BOTH)) {
		
		$ban = $checkban['user_title'];	
		if ($ban == 0){
			 header("location:ban.php");
		}
		if ($ban == 1){
			 header("location:awaiting.php");
		}

	}
?>