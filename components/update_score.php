<?php
    ini_set("display_errors",1);
    session_start();
    if(isset($_POST)){
		require '../_database/database.php';
        $stars = $_POST['stars'];
	    $enemy = $_POST['war_enemy'];
	    $user = $_POST['user_username'];
	    $enemy_number = $_POST['enemy_enemynumber'];
		$war_detail=$_POST['war_detail'];
		$war_size=$_POST['war_size'];	
        $sql3="UPDATE score SET score='$stars' WHERE war_enemy='$enemy' && user_username = '$user' && enemy_enemynumber = '$enemy_number'";
            mysqli_query($database,$sql3)or die(mysqli_error($database));
            header('location:../war.php?war_details='.$war_detail.'&war_size='.$war_size);
    }    
?>