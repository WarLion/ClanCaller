<?php
    ini_set("display_errors",1);
    session_start();
   if(isset($_GET)){
	   require '../_database/database.php';
    $bug_id = $_GET['delete']; 
	 $sql3="DELETE FROM bugs WHERE bug_id='$bug_id' LIMIT 1";
            mysqli_query($database,$sql3)or die(mysqli_error($database));
            header("location:../bugs.php");



   }?>