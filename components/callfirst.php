<?php
    ini_set("display_errors",1);
    session_start();
	$temp=$_REQUEST['user_callit'];	
    if(isset($_POST)){
        require '../_database/database.php';
        $Destination = '../userfiles/screenshoots';
		$war_enemy=$_REQUEST['war_enemy'];
		$war_enemynumber = $_GET['enemy'];
		$screenshoot = $_REQUEST['screenshoot'];;
        if(!isset($_FILES['ImageFile']) || !is_uploaded_file($_FILES['ImageFile']['tmp_name'])){
            $NewImageName= $screenshoot;
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
        $sql5="UPDATE caller SET call_base='$NewImageName' WHERE war_enemynumber = '$war_enemynumber' && war_enemy = '$war_enemy'";
        $sql6="INSERT INTO caller (call_base) VALUES ('$NewImageName')  WHERE war_enemynumber = '$war_enemynumber' && war_enemy = '$war_enemy'";
        $result = mysqli_query($database,"SELECT * FROM caller WHERE war_enemynumber = '$war_enemynumber' && war_enemy = '$war_enemy'");
        if( mysqli_num_rows($result) > 0) {
            if(!empty($_FILES['ImageFile']['name'])){
                mysqli_query($database,$sql5)or die(mysqli_error($database));
                header("location:../war.php?war_details=$temp1&war_size=$war_size");
            }
        } 
        else {
            mysqli_query($database,$sql6)or die(mysqli_error($database));
            header("location:../war.php?war_details=$temp1&war_size=$war_size");
        }  
		$war_size = $_GET['war_size'];
		$temp1 = $_GET['war_details'];
		$call_th=$_REQUEST['call_th'];
		$user_favattack = $_REQUEST['user_favattack'];	
		$user_call = $_REQUEST['user_call'];	
		$current_username = $_REQUEST['current_username'];
        $sql3="UPDATE caller SET call_th='$call_th', call_base='$NewImageName',".$user_call."='$temp' WHERE war_enemynumber = '$war_enemynumber' && war_enemy = '$war_enemy'";
		$sql4="INSERT INTO score SET war_enemy='$war_enemy',user_username='$temp', enemy_enemynumber = '$war_enemynumber', favattack = '$user_favattack'";
		$sql5="INSERT INTO war_log SET log_clanname='$war_enemy',log_username='$temp', log_enemy_number = '$war_enemynumber', log_status = 'call', log_as_user ='$current_username'";
			$r2 = mysqli_query($database,$sql3);
			$r1 = mysqli_query($database,$sql4); 
			$r3 = mysqli_query($database,$sql5); 
			$sqlResult = $r1 && $r2 && $r3;
			if(!$sqlResult){
				mysqli_rollback($database);
				echo "error contact your admin";
			}else{
				mysqli_commit($database);
				 header("location:../war.php?war_details=$temp1&war_size=$war_size");
			}
			mysqli_close($database);		
			
			
			
			
			
			
			
			
			
           
    }    
?>