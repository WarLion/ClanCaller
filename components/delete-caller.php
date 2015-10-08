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
		date_default_timezone_set("America/Mexico_City");
		$time = date('h:i:s');
        $sql1="UPDATE caller SET ".$user_call."='' WHERE war_enemy='$war_enemy' AND war_enemynumber = '$war_enemynumber'";
		$sql2="DELETE FROM score WHERE user_username='$temp' AND enemy_enemynumber = '$war_enemynumber'";
		$sql3="INSERT INTO war_log SET log_clanname='$war_enemy',log_username='$temp', log_enemy_number = '$war_enemynumber', log_status = 'delete', log_as_user ='$current_username',log_time='$time'";
		$sql4="UPDATE war_log SET log_end_time='', status ='0' WHERE log_username='$temp' AND log_clanname='$war_enemy' AND  log_enemy_number = '$war_enemynumber'";
			$r1 = mysqli_query($database,$sql1);
			$r2 = mysqli_query($database,$sql2); 
			$r3 = mysqli_query($database,$sql3); 
			$r4 = mysqli_query($database,$sql4); 
			$sqlResult = $r1 && $r2 && $r3 && $r4;
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