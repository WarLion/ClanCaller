<?php include 'components/authentication.php' ?>
<?php include 'components/session-check.php' ?>
<?php include 'controllers/base/head.php' ?>
<?php include 'controllers/navigation/first-navigation.php' ?>   
<?php 
	$user_username = $_GET['user_username'];         
    $sql = "SELECT * FROM user where user_username='$user_username'";
    $result = mysqli_query($database,$sql) or die(mysqli_error($database)); 
    $rws = mysqli_fetch_array($result);
?>         
    <div class="container">
    <h4 class="text-center profile-text profile-name">Edit User</h4>
	   <div class="no-gutter row"> 
           <div class="col-md-12">
               <div class="panel panel-default" id="sidebar">
                   <div class="panel-body">                
           
<?php include 'controllers/form/edit-users-form.php' ?>
                   </div>
               </div>
           </div>
        </div>
    </div>
    