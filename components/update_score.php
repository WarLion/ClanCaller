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
		$current_username = $_REQUEST['current_username'];
        $sql3="UPDATE score SET score='$stars' WHERE war_enemy='$enemy' && user_username = '$user' && enemy_enemynumber = '$enemy_number'";
		$sql5="INSERT INTO war_log SET log_clanname='$enemy',log_username='$user', log_score='$stars', log_enemy_number = '$enemy_number', log_status = 'Score', log_as_user ='$current_username'";
			$r1 = mysqli_query($database,$sql3);
			$r2 = mysqli_query($database,$sql5); 
			$sqlResult = $r1 && $r2;
			if(!$sqlResult){
				mysqli_rollback($database);
				echo "error contact your admin";
			}else{
				mysqli_commit($database);
            header('location:../war.php?war_details='.$war_detail.'&war_size='.$war_size);
			}
			mysqli_close($database);	
	}
?>