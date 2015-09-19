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
if (loggedin())
{
	header("location:home.php");
	exit();
}
?>