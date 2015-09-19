<?php include 'components/authentication.php' ?> 
<?php include 'controllers/base/head.php' ?>
<?php include 'controllers/navigation/first-navigation.php' ?> 
     <div class="container" style="padding-top:50px;">
    <h1 class="text-center profile-text profile-name">Enemy Clan</h1>
	   <div class="no-gutter row"> 
           <div class="col-md-12">
                           
<?php          
    $sql = "SELECT * FROM user where user_username='$current_user'";
    $result = mysqli_query($database,$sql) or die(mysqli_error($database)); 
    $rws = mysqli_fetch_array($result);
?>             
<?php 
if ($title_user >= 3){
		include ("controllers/form/createwar-form.php"); 
    }else {
	?> <div class="panel panel-default" id="sidebar">
                   <div class="panel-body">   
                   <center>
    <h2>You dont have access only Eldesr, Co-leaders and Leaders can create Wars</h2>
    </center>
    </div>
               </div>
    <?php	
	}

?>
                   
           </div>
        </div>
    </div>