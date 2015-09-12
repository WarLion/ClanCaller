the first step is to copy all files to your ftp server and go to the address www.youdomain.com/install/
and follow all the steps 

after the installation is complete you need to access your ftp and on the new file on www.youdomain.com/_database/database.php

add your clan name and info

//add your clan name	
$clananame = ''; 	
//the script url	
$url = 'http://www.yourpage.com/clanwars_script';	


//email adreess
$from = ''; //email where is from ej admin@yourpage.com

also to recieve new registration to your email edit 
this files
yourdomain.com/components/registration.php 
yourdomain.com/components/update_user.php 

in this area 
//----------------------------------------------------------------------------							   
$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = '';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = '';                 // SMTP username
$mail->Password = '';                           // SMTP password
$mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 465;     							   

//-----------------------------------------------------------------------------

  
thats it the installation process will take just a few seconds its a much easier and clean way to install the script 

enjoy



if you find a problem you can send me a message on BAND 
clanwar script
http://band.us/n/FREuhy7Y
