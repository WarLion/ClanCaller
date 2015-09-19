<?php
    ini_set("display_errors",1);
    session_start();
    if(isset($_POST)){
		$user_username_user = $_REQUEST['user_username_user'];
        $user_title=$_REQUEST['user_title'];
		$user_email=$_REQUEST['user_email'];		
        require '../_database/database.php';
		$sql3="UPDATE user SET user_title='$user_title', user_username = '$user_username_user'  WHERE user_username='$user_username_user'";
	mysqli_query($database,$sql3)or die(mysqli_error($database));
	require '../assets/mail/PHPMailerAutoload.php';
    $message = file_get_contents('../assets/mail/edit_user.html'); 
	$message = str_replace('%user_username%', $user_username, $message);
	$message = str_replace('%url%', $url, $message);
	$message = str_replace('%clananame%', $clananame, $message);
    $mail = new PHPMailer(); $mail->IsSMTP(); // This is the SMTP mail server 

$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = '';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = '';                 // SMTP username
$mail->Password = '';                           // SMTP password
$mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 465;                                    // TCP port to connect to

$mail->From = $from;
$mail->FromName = $clananame.' WebPage';
$mail->addAddress($user_email);     // Add a recipient
$mail->Subject = $clananame.' ClanWars Information';
$mail->MsgHTML($message);
$mail->IsHTML(true); 
$mail->CharSet="utf-8";
//$mail->AltBody(strip_tags($message)); 
if($mail->send()) {
    header('Location: ../profile.php?user_username='.$user_username_user);
}		
				

    }  
?>