the first step is upload the files on your server 
go to your url 
yourdomain.com/clanwars/install

and follow the steps 

after the installation you need to delete the foldel install from your ftp

go and edit 
_database/database.php
with your information 

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

    the log in access and password for you site 
    
    login to the site using 
    username: Admin
    password: Administrator
    
