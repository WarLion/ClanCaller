<?php
    ini_set("display_errors",1);
    session_start();
    $temp=$_SESSION['user_username'];
    if(isset($_POST)){
        require '../_database/database.php';
        $Destination = '../userfiles/background-images';
        $Destination = '../userfiles/avatars';
        if(!isset($_FILES['ImageFile']) || !is_uploaded_file($_FILES['ImageFile']['tmp_name'])){
            $NewImageName= 'default.png';
            move_uploaded_file($_FILES['ImageFile']['tmp_name'], "$Destination/$NewImageName");
        }
        else{
            $RandomNum   = rand(0, 9999999999);
            $ImageName = str_replace(' ','-',strtolower($_FILES['ImageFile']['name']));
            $ImageType = $_FILES['ImageFile']['type'];
            $ImageExt = substr($ImageName, strrpos($ImageName, '.'));
            $ImageExt = str_replace('.','',$ImageExt);
            $ImageName = preg_replace("/\.[^.\s]{3,4}$/", "", $ImageName);
            $NewImageName = $ImageName.'-'.$RandomNum.'.'.$ImageExt;
            move_uploaded_file($_FILES['ImageFile']['tmp_name'], "$Destination/$NewImageName");
        }
        $sql5="UPDATE user SET user_avatar='$NewImageName' WHERE user_username = '$temp'";
        $sql6="INSERT INTO user (user_avatar) VALUES ('$NewImageName') WHERE user_username = '$temp'";
        $result = mysqli_query($database,"SELECT * FROM user WHERE user_username = '$temp'");
        if( mysqli_num_rows($result) > 0) {
            if(!empty($_FILES['ImageFile']['name'])){
                mysqli_query($database,$sql5)or die(mysqli_error($database));
                header("location:../edit-profile.php?user_username=$temp");
            }
        } 
        else {
            mysqli_query($database,$sql6)or die(mysqli_error($database));
            header("location:../edit-profile.php?user_username=$temp");
        }  
        $user_firstname=$_REQUEST['user_firstname'];
        $user_email=$_REQUEST['user_email'];
        $user_password=$_REQUEST['user_password'];
		$user_favtroop=$_REQUEST['user_favtroop'];
		$user_favattack=$_REQUEST['user_favattack'];
		$user_th=$_REQUEST['user_th'];
		$user_bk=$_REQUEST['user_bk'];
		$user_aq=$_REQUEST['user_aq'];
        $sql3="UPDATE user SET user_firstname='$user_firstname',user_email='$user_email',user_password='$user_password',user_favtroop='$user_favtroop',user_favattack='$user_favattack',user_th='$user_th',user_bk='$user_bk',user_aq='$user_aq' WHERE user_username = '$temp'";
            mysqli_query($database,$sql3)or die(mysqli_error($database));
            header("location:../edit-profile.php?user_username=$temp&request=profile-update&status=success");
    }    
?>