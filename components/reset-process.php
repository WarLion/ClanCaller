<?php
    ini_set("display_errors",1);
    if(isset($_POST)){
		require '../_database/database.php';
	 $encrypt      = mysqli_real_escape_string($database,$_POST['encrypt']);
    $password     = mysqli_real_escape_string($database,$_POST['password']);
	$password2     = mysqli_real_escape_string($database,$_POST['password2']);
	if($password == $password2){
	
    $query = "SELECT user_id FROM user where md5(90*13+user_id)='".$encrypt."'";
//    echo $query;
    $result = mysqli_query($database,$query);
    $Results = mysqli_fetch_array($result);
    if(count($Results)>=1)
    {
        $query = "update user set user_password='".md5($password)."' where user_id='".$Results['user_id']."'";
        mysqli_query($database,$query);
//        echo $query;

        header("location: ../index.php?pass=success");
    }
    else
    {
        header('location: ../forget.php?no_user');
    }
}
else
{
	header('location: ../reset.php?encrypt='.$encrypt.'&action=reset&pass=x');
   
   } 
	}else{
		 header("location: ../index.php");
	}
?>

           