<?php
    session_start();
function loggedin()
{
	if (isset($_SESSION['user_username']) || isset($_COOKIE['user_username']))
	{
		$loggedin = TRUE;
		return $loggedin;	
	}
}	

if(isset($_COOKIE['user_username'])){
	$current_user = $_COOKIE['user_username'];
	return $current_user;
	
}else if(isset($_SESSION['user_username'])){
		$current_user = $_SESSION['user_username'];
}

    require '_database/database.php';
	$ban_sql = "SELECT * FROM user WHERE user_username='$current_user'";
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