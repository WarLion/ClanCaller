<?php
    session_start();
    if(isset($_REQUEST['login_button'])||$_REQUEST['auto']==1){
        require '../_database/database.php';
        $username_1=  mysqli_real_escape_string($database,$_REQUEST['username']);
		$username=htmlspecialchars($username_1);
		$rememberme = $_REQUEST['rememberme'];
        $user_passwordnoencript=  mysqli_real_escape_string($database,$_REQUEST['password']);
		$password=htmlspecialchars(md5($user_passwordnoencript)); // Encrypted Password			
        if($username == '') {
            $errmsg_arr[] = 'Username missing';
            $errflag = true;
        }
        if($password == '') {
            $errmsg_arr[] = 'Password missing';
            $errflag = true;
        }
        if($errflag) {
            $_SESSION['ERRMSG_ARR'] = $errmsg_arr;
            session_write_close();
            header("location: authentication-check.php");
            exit();
        }		
        $sql="SELECT user_username,user_password FROM user WHERE user_username='$username'AND user_password='$password'";
        $result=  mysqli_query($database,$sql) or die(mysqli_errno());
        $trws= mysqli_num_rows($result);
        if($trws==1){
            $rws=  mysqli_fetch_array($result);
			
				if ($rememberme=="on"){
				$user_name=$rws['user_username'];
				setcookie("user_username",$user_name,time() + (86400 * 30), "/");
				}else{
					if ($rememberme=="off"){
					$_SESSION['user_username']=$rws['user_username'];
					}
				}
            header("location:../home.php");    
         }
        else {
            $errmsg_arr[] = 'user name and password not found';
            $errflag = true;
            if($errflag) {
                $_SESSION['ERRMSG_ARR'] = $errmsg_arr;
                session_write_close();
                header("location: ../components/authentication-check.php");
                exit();
            }
        }
    }
?>