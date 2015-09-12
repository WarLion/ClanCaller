<?php include 'components/authentication.php' ?>
<?php include 'components/session-check.php' ?>
<?php include 'controllers/base/head.php' ?>
<?php include 'controllers/base/style.php' ?> 	
<?php include 'controllers/navigation/first-navigation.php' ?>          
     <div class="container" style="padding-top:50px;">
    <h1 class="text-center profile-text profile-name">CLan Info</h1>
	   <div class="no-gutter row"> 
           <div class="col-md-12">
               <div class="panel panel-default" id="sidebar">
                   <div class="panel-body">                     

<form class="form-inline" action="clan_info.php?u" method="post" autocomplete="off">
    <div class="row">     
        <div class="col-lg-12" style="z-index: 9;">
            <div class="form-group">
            <label>Total Points:</label>
           	 <input type="text" class="form-control input-lg" placeholder="First Name" name="user_firstname" required>
            </div>
            <div class="form-group">
            <label>Members:</label>
<?php $sql_call = "SELECT count(user_username) as 'max' FROM user WHERE user_title <> 0";
					$result_call = mysqli_query($database,$sql_call) or die(mysqli_error($database));
					while($calls = mysqli_fetch_array($result_call)){        ?>   
                    <input type="text" class="form-control input-lg" placeholder="<?php echo $calls['max'];?>/50" name="user_firstname" value="<?php echo $calls['max'];?>">  
<?php }?>             
            </div>
        </div>        
    </div>
    Total Points: 22642
    Members: 43/50
    Type: Invite Only
    Required Trophies: 2000
    Wars Won: 139
    Wars Lost: 18
    Wars Tied: 5
</form>

                   </div>
               </div>
           </div>
        </div>
    </div>