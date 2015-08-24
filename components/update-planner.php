<?php
    ini_set("display_errors",1);
    session_start();
    if(isset($_POST)){
        require '../_database/database.php';
		$temp=$_SESSION['user_username'];
		$enemy = $_REQUEST['enemy'];  
		$enemyname = $_REQUEST['enemyname']; 
		$war_size = $_REQUEST['war_size'];
		$war_warid = $_REQUEST['war_warid'];
		$plan = $_REQUEST['plan'];
        $sql3="UPDATE score SET plan='$plan' WHERE war_enemy= '$enemyname' && enemy_enemynumber='$enemy' && user_username='$temp'";
            mysqli_query($database,$sql3)or die(mysqli_error($database));
            header('location:../war.php?war_details='.$war_warid.'&war_size=' .$_REQUEST['war_size']);
    }    
?>

