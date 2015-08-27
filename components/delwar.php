<?php
    ini_set("display_errors",1);
    session_start();
    if(isset($_GET)){
        require '../_database/database.php';
		$war_id = $_GET['id'];
  $sql3="DELETE FROM war_table WHERE war_warid='$war_id'";
            mysqli_query($database,$sql3)or die(mysqli_error($database));
            header("location:../home.php");
    }    
?>