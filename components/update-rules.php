<?php
    ini_set("display_errors",1);
    session_start();
    if(isset($_POST)){
        require '../_database/database.php';
        $user_username=$_REQUEST['user_username'];
		$rule =htmlspecialchars($_REQUEST['rule_txt']);
		$rule_txt = addslashes($rule);
        $sql3="UPDATE rules SET user_username='$user_username',rule_txt='$rule_txt' WHERE rules_id=1";
            mysqli_query($database,$sql3)or die(mysqli_error($database));
            header("location:../edit-rules.php?status=success");
    }    
?>