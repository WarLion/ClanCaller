<?php
    ini_set("display_errors",1);
    session_start();
    if(isset($_POST)){
	require '../_database/database.php';
$name = $_REQUEST['name'];
$email_address = $_REQUEST['email'];
$message = $_REQUEST['message'];
$bug_type = $_REQUEST['bug_type'];

        $sql3="INSERT INTO bugs SET name='$name',email='$email_address', message = '$message', type ='$bug_type' ";
            mysqli_query($database,$sql3)or die(mysqli_error($database));
$to = $from; // Add your email address inbetween the '' replacing yourname@yourdomain.com - This is where the form will send a message to.
$email_subject = "$bug_type - $clananame Website From:  $name";
$email_body = "You have received a new message from Bug Report form.\n\n"."Here are the details:\n\nName: $name\n\nEmail: $email_address\n\nType: $bug_type\n\nMessage:\n$message";
$headers = "From: noreply@$clananame.com"; // This is the email address the generated message will be from. We recommend using something like noreply@yourdomain.com.
$headers .= "Reply-To: $email_address" .
    'X-Mailer: PHP/' . phpversion();	
mail($to,$email_subject,$email_body,$headers);					
   header("location:../bugs.php?send"); 
		
           
			 
			
   }
?>