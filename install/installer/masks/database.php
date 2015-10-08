<?php
	$hostname  = '{hostname}';
	$database = '{database}';
	$user  =  '{username}';
	$password =  '{password}'; 
	$prefix = "";
    $database=mysqli_connect($hostname,$user,$password,$database);
	
	//page options
	$clananame = 'clan'; /// clan name
	$url =''; //your url
	
	// email option
	$email_Host = '';  // Specify main and backup SMTP servers
	$email_Username = '';                 // SMTP username
	$email_Password = '';                           // SMTP password
	$email_SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
	$email_Port = 465;  	
	$admin_email =''; /// admin email 
?>