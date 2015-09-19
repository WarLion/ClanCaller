<?php
    ini_set("display_errors",1);
    if(isset($_POST)){
	$username = htmlspecialchars($_REQUEST['username']);
	require '../_database/database.php';
	$sql3="SELECT * FROM user WHERE user_username='$username'";
        $result = mysqli_query($database,$sql3);
        $user = mysqli_fetch_array($result);
			
 if(count($user)>=1){
	header("location:../forget.php?no_user"); 
	$encrypt = md5(90*13+$user['user_id']);
    $message = "Your password reset link send to your e-mail address.";
	$user_email = $user['user_email'];	
	$name = $user['user_firstname'];
	$user_username = $user['user_username'];
				
	$to = $user_email;
	$email_body = 'Hi, <br/> <br/>Your UserName is '.$user['user_username'].' <br><br>Click here to reset your password <a href="'.$url.'/reset.php?encrypt='.$encrypt.'&action=reset">'.$url.'/reset.php?encrypt='.$encrypt.'&action=reset</a><br>if the link dont work please copy and paste it in your browser';
	$headers = "From: $from\n"; 
	$headers .= "Reply-To: $from";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
	mail($to,$email_subject,$email_body,$headers);	
	header("location:../forget.php?send");
	die();
}else{
	header("location:../forget.php?no_user"); 
}
   } 
?>

           