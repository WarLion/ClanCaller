<?php
    session_start();
    include '../_database/database.php';
    if(isset($_REQUEST['signup_button'])){
        $user_email=$_REQUEST['user_email'];
        $user_firstname=$_REQUEST['user_firstname'];
        $user_username=$_REQUEST['user_username'];
		$user_password_nocript =$_REQUEST['user_password'];
        $user_password=(md5($user_password_nocript));
		$secret_email=$_REQUEST['user_email_get'];
		$user_th=$_REQUEST['user_th'];
        $sql="INSERT INTO user(user_firstname,user_email,user_username,user_password,user_avatar,user_th,user_email_get) VALUES('$user_firstname','$user_email','$user_username','$user_password','default.jpg','$user_th','$secret_email')";
        mysqli_query($database,$sql) or die(mysqli_error($database));
        $_SESSION['user_username'] = $user_username;
		
		
	require '../assets/mail/PHPMailerAutoload.php';
    $message = file_get_contents('../assets/mail/template.html'); 
	$message = str_replace('%firstname%', $user_firstname, $message);
    $message = str_replace('%username%', $user_username, $message); 
	$message = str_replace('%th%', $user_th, $message);
    $mail = new PHPMailer(); $mail->IsSMTP(); // This is the SMTP mail server 

$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = $email_Host;  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = $email_Username;                 // SMTP username
$mail->Password = $email_Password;                           // SMTP password
$mail->SMTPSecure = $email_SMTPSecure;                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = $email_Port;                                    // TCP port to connect to

$mail->From = $admin_email;
$mail->FromName = $clananame.' WebPage';
$mail->addAddress($user_email, $user_firstname);     // Add a recipient
$mail->Subject = 'Your Account Information';
$mail->MsgHTML($message);
$mail->IsHTML(true); 
$mail->CharSet="utf-8";
//$mail->AltBody(strip_tags($message)); 
if(!$mail->Send()) {  
echo "Mailer Error: " . $mail->ErrorInfo;
}else{
$mail2 = new PHPMailer(); 
$mail2->IsSMTP(); // This is the SMTP mail server
$mail2->Host = $email_Host;  // Specify main and backup SMTP servers
$mail2->SMTPAuth = true;                               // Enable SMTP authentication
$mail2->Username = $email_Username;                 // SMTP username
$mail2->Password = $email_Password;                           // SMTP password
$mail2->SMTPSecure = $email_SMTPSecure;                            // Enable TLS encryption, `ssl` also accepted
$mail2->Port = $email_Port;                                       // TCP port to connect to

$mail2->From = $admin_email;
$mail2->FromName = $clananame.' WebPage';
$mail2->addAddress($admin_email, 'WarLion');     // Add a recipient
//$mail2->addBCC('');  //copy to

$mail2->Subject = 'A new Member just register on the '.$clananame.' ClanWars page ';
$mail2->Body    = 'A new member is waiting approval to get access to the page <br> Username: <strong>'.$user_username.'</strong><br>
<a href="'.$url.'profile.php?user_username='.$user_username.'">Edit Profile</a>';
$mail2->AltBody = 'This is the body in plain text for non-HTML mail clients';

if($mail2->send()) {
    header('Location: ../home.php');
}		

}		
    }
?>
