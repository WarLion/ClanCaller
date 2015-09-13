<?php
    ini_set("display_errors",1);
    session_start();
    if(isset($_POST)){
        require '../_database/database.php';
		$war_enemynumber = $_GET['e'];
		$war_enemy = $_GET['e2'];
		$war_warid=$_REQUEST['war_warid'];
		$war_size=$_REQUEST['war_size'];
		$user_call = $_REQUEST['user_call'];
		$temp=$_REQUEST['user_callit'];
		$current_username = $_REQUEST['current_username'];
        $sql3="UPDATE caller SET ".$user_call."='' WHERE war_enemy='$war_enemy' AND war_enemynumber = '$war_enemynumber'";
		$sql4="DELETE FROM score WHERE user_username='$temp' AND enemy_enemynumber = '$war_enemynumber'";
		$sql5="INSERT INTO war_log SET log_clanname='$war_enemy',log_username='$temp', log_enemy_number = '$war_enemynumber', log_status = 'delete', log_as_user ='$current_username'";
			$r2 = mysqli_query($database,$sql3);
			$r1 = mysqli_query($database,$sql4); 
			$r3 = mysqli_query($database,$sql5); 
			$sqlResult = $r1 && $r2 && $r3;
			if(!$sqlResult){
				//sqlResult = 0, thus there was a problem
				mysqli_rollback($database);
				echo "error contact your admin";
			}else{
				//sqlResult = 1, no problem
				mysqli_commit($database);
				header('location:../war.php?war_details='.$war_warid.'&war_size='.$war_size);
			}
			mysqli_close($database);
			/*		
            mysqli_query($database,$sql3)or die(mysqli_error($database));
            header('location:../war.php?war_details='.$war_warid.'&war_size='.$war_size); */
    }    
?>