<?php
    session_start();
    include '../_database/database.php';
    if(isset($_REQUEST['signup_button'])){
        $user_email=$_REQUEST['user_email'];
        $user_firstname=$_REQUEST['user_firstname'];
        $user_username=$_REQUEST['user_username'];
        $user_passwordnoencript=mysqli_real_escape_string($database,$_REQUEST['user_password']);
		$user_password=md5($user_passwordnoencript); // Encrypted Password	
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
	$message = str_replace('%clananame%', $clananame, $message);
	$message = str_replace('%url%', $url, $message);
    $mail = new PHPMailer(); $mail->IsSMTP(); // This is the SMTP mail server 
                               // TCP port to connect to
							   
			// EDIT this ifmormation with your server smtp (email to the new member)
			
//----------------------------------------------------------------------------							   
$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = '';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = '';                 // SMTP username
$mail->Password = '';                           // SMTP password
$mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 465;     							   

//-----------------------------------------------------------------------------

$mail->From = $from;
$mail->FromName = $clananame.'WebPage';
$mail->addAddress($user_email, $user_firstname);     // Add a recipient
$mail->Subject = 'Your Account Information';
$mail->MsgHTML($message);
$mail->IsHTML(true); 
$mail->CharSet="utf-8";
//$mail->AltBody(strip_tags($message)); 
if(!$mail->Send()) {  
echo "Mailer Error: " . $mail->ErrorInfo;
}else{
	
	
			// EDIT this ifmormation with your server smtp (email to the admin)
			
//----------------------------------------------------------------------------		
$mail2 = new PHPMailer(); 
$mail2->IsSMTP(); // This is the SMTP mail server
$mail2->Host = '';  // Specify main and backup SMTP servers
$mail2->SMTPAuth = true;                               // Enable SMTP authentication
$mail2->Username = '';                 // SMTP username
$mail2->Password = '';                           // SMTP password
$mail2->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
$mail2->Port = 465;                                    // TCP port to connect to

//----------------------------------------------------------------------------	

$mail2->From = $from;
$mail2->FromName = $clananame.'WebPage';
$mail2->addAddress($from, 'Admin '.$clananame);     // Add a recipient
//$mail2->addBCC(''); //add a copy to member 

$mail2->Subject = 'A new Member just register on the '.$clananame.' ClanWars page ';
$mail2->Body    = 'A new member is waiting approval to get access to the page <br> Username: <strong>'.$user_username.'</strong><br>
<a href="'.$url.'profile.php?user_username='.$user_username.'">Edit Profile</a>';
$mail2->AltBody = 'A new member is waiting approval to get access to the page\n 
Username: '.$user_username;

if($mail2->send()) {
    header('Location: ../home.php');
}		

}		
    }
?>
