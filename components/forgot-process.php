<?php
    ini_set("display_errors",1);
    if(isset($_POST)){
	$username = $_REQUEST['username'];
	require '../_database/database.php';
	$sql3="SELECT * FROM user WHERE user_username='$username'";
        $result = mysqli_query($database,$sql3);
        $user = mysqli_fetch_array($result);
			
 if(count($user)>=1){
	header("location:../forget.php?no_user"); 
	$user_email = $user['user_email'];	
	$name = $user['user_firstname'];
	$user_username = $user['user_username'];
	$password = $user['user_password'];
				
	$to = $user_email;
	$email_subject = "Password Request From Halo Website";
	$email_body = "You have received a new message from Halo Website.\n\n"."Here are the info of your account:\n\nName: $name\n\nUsername: $user_username\n\nPassword: $password\n\n";
	$headers = "From: Halo-WarClans@halo-clan.com\n"; 
	$headers .= "Reply-To: admin@halo-clan.com" .
		'X-Mailer: PHP/' . phpversion();	
	mail($to,$email_subject,$email_body,$headers);	
	header("location:../forget.php?send");
	die();
}else{
	header("location:../forget.php?no_user"); 
}
   } 
?>

           