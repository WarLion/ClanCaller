<?php
 if(!loggedin())
{
	header("location:index.php");
}

    require '_database/database.php';
    $user_username = mysqli_real_escape_string($database,$_REQUEST['user_username']);

?>