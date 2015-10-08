<?php 
    require '_database/database.php';
$sql = "SELECT user_title FROM user WHERE user_username = '$current_user'";
    $result = mysqli_query($database,$sql) or die(mysqli_error($database));
    while($rws = mysqli_fetch_array($result,MYSQLI_BOTH)) {	
	$title_user = $rws['user_title'];
	if ($title_user <= 3){
        header("location:home.php");
    }
	}
?>