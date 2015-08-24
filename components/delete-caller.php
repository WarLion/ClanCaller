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
		$temp=$_SESSION['user_username'];
        $sql3="UPDATE caller SET ".$user_call."='' WHERE war_enemy='$war_enemy' AND war_enemynumber = '$war_enemynumber'";
		$sql4="DELETE FROM score WHERE user_username='$temp' AND enemy_enemynumber = '$war_enemynumber'";
			$r2 = mysqli_query($database,$sql3);
			$r1 = mysqli_query($database,$sql4); 
			$sqlResult = $r1 && $r2;
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