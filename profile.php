<?php include 'components/authentication.php' ?> 
<?php include 'components/session-check-profile.php' ?>
<?php include 'controllers/base/head.php' ?>
<?php include 'controllers/navigation/first-navigation.php' ?> 
<?php include 'controllers/base/style.php' ?>
    <script>
        $.growl("<?php echo $dialogue; ?> ", {
            animate: {
                enter: 'animated zoomInDown',
                exit: 'animated zoomOutUp'
            }								
        });
    </script>
<?php 
    $current_user = $_SESSION['user_username'];
    $user_username = mysqli_real_escape_string($database,$_REQUEST['user_username']);
    $profile_username=$rws['user_username'];
?>
<?php
    $url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
?>
<div class="profile">
	<div class="row clearfix">
		<!-- <div class="col-md-12 column"> -->
            <div>
                <center>
                    <img src="userfiles/avatars/<?php echo $rws['user_avatar'];?>" class="img-responsive profile-avatar">
                </center>
                <h1 class="text-center profile-text profile-name"><?php echo $rws['user_username'];?><br /><small><?php User_Title($rws['user_title']);?></small></h1>
                <h3 class="text-center profile-text profile-profession">

<?php echo $rws['user_slogan'];?>
</h2>
                <br>
                <div class="pull-right">
<?php	
 $sql2 = "SELECT * FROM user WHERE user_username='$current_user'";
    $result2 = mysqli_query($database,$sql2);
    while($row = mysqli_fetch_array($result2,MYSQLI_BOTH)) {	
$title_user = $row['user_title'];
		if ($title_user == 4 || $title_user == 5 || $title_user == 6){
				$admin_leader = $rws['user_title'];	
			if ($admin_leader < 5){    ?>            
                <a href="edit-users.php?user_username=<?php echo $rws['user_username'];?>" class="btn btn-primary"><span class="fa fa-edit"> Edit User</span></a><?php }}}?>
                <?php if ($rws['user_username'] == $current_user){?>
               <a href="edit-profile.php" class="btn btn-primary"><span class="fa fa-edit"> Edit Profile</span></a>
                <?php }?>
                </div>
                <div class="panel-group white" id="panel-profile">
                    <div class="panel panel-default">
                        <div id="panel-element-info" class="panel-collapse collapse in">
                            <div class="panel-body">
                                <div class="col-md-4 col-sm-4 column">
                                    <p class="user_title" style="text-align: center; font-size:18;">Personal Information</p>
                                    <hr>


                                    <div class="col-md-4">
                                        <p class="profile-details"><i class="fa fa-user"></i> Name</p>
                                    </div>
                                    <div class="col-md-6">                                    
                                        <p class="profile-text profile-name" style="font-size:20;"><?php echo $rws['user_firstname'];?></p>
                                    </div>
<?php
if ($rws['user_email']){
    if ($rws['user_email_get'] == 1){
?>   
                                    <div class="col-md-4">
                                        <p class="profile-details"><i class="fa fa-envelope"></i> Email</p>
                                    </div>
                                    <div class="col-md-6">                                    
                                        <p><a class="profile-text profile-name" href="mailto:<?php echo $rws['user_email'];?>">E-mail</a> </p>
                                    </div>
<?php } ?>
<?php
    if ($rws['user_email_get'] == 2 && $title_user >=5){
?>   
                                    <div class="col-md-4">
                                        <p class="profile-details"><i class="fa fa-envelope"></i> Email</p>
                                    </div>
                                    <div class="col-md-6">                                    
                                        <p><a class="profile-text profile-name" href="mailto:<?php echo $rws['user_email'];?>">email</a> </p>
                                    </div>
<?php } }?>

                                </div>
                                <div class="col-md-8 col-sm-8 column">
                                    <p class="user_title" style="text-align: center; font-size:18;">Game Information</p>
                                    <hr>
                                    <div class="col-md-4 col-sm-4 col-xs-6 text-center">
                                        <p class="profile-details"><i class="fa fa-plus"></i> TownHall Lv</p>  
<?php
    if ($rws['user_th']){
?>                                                                          
                                        <img src="imagenes/th/<?php echo $rws['user_th'];?>.png" width="100px" />
 <?php }else{ ?>   
                                         <img src="imagenes/th/noselect.png" width="100px" />
 <?php }?>                                       
                                    </div>  
                                    <div class="col-md-4 col-sm-4 col-xs-6 text-center">
                                        <p class="profile-details"><i class="fa fa-plus"></i> Favorite troop</p>
                                        <img src="imagenes/troops/troops/<?php echo $rws['user_favtroop'];?>.png" width="100px" />
                                    </div> 
                                    <div class="col-md-4 col-sm-4 col-xs-12 text-center">
                                        <p class="profile-details"><i class="fa fa-plus"></i> Favorite attack</p>                                           
                                        <img src="imagenes/troops/attacks/<?php echo $rws['user_favattack'];?>.png" width="130px" />
                                    </div>                                                                                                                                                    
                                </div>   
                            </div>


						<div class="panel-body">
                                <div class="col-md-6 col-sm-12">
                                    <p class="user_title" style="text-align: center; font-size:15;">Your War log</p>
                                    <hr>


                                    <div class="col-md-12 col-sm-12">
                                    <p class="profile-details"><i class="fa fa-plus"></i>Current war</p> 
                                        <div class="col-md-3 col-sm-3 col-xs-12 text-center">
<?php                                        
 $sql = "SELECT * FROM war_table ORDER BY war_warid DESC LIMIT 1";
    $result = mysqli_query($database,$sql) or die(mysqli_error($database));
    while($warlog = mysqli_fetch_array($result,MYSQLI_BOTH)) { 
	$enemy_name1 = $warlog['war_enemy'];
?>	                                       
                                        <a href="war.php?war_details=<?php echo $warlog['war_warid'];?>&war_size=<?php echo $warlog['war_size']; ?>" class="btn btn btn-primary ladda-button">details</a><hr class="visible-xs" />
<?php }?>                                       
                                        </div>    
                                        
                                        
  <?Php
  $user_name = $rws['user_username'];
   $sql2 = "SELECT * FROM score WHERE user_username='$user_name' AND war_enemy = '$enemy_name1' ORDER BY score_id LIMIT 2";
    $result2 = mysqli_query($database,$sql2) or die(mysqli_error($database));
    while($userlog = mysqli_fetch_array($result2,MYSQLI_BOTH)) {
  ?>                                       
                                         
                                         
                                         
                                        <div class="col-md-2 col-sm-2 col-xs-6 text-center">
                                        <img src="imagenes/th/<?php echo $userlog['score'];?>.png" width="80px" />  
                                        </div> 
                                        <div class="col-md-2 col-sm-2 col-xs-6 text-center" >
                                        <?php if($userlog['favattack'] == ''){?>
                                        <img src="imagenes/troops/attacks/none.png" width="80px" />  
										<?php }else{?>                              
                                        <img src="imagenes/troops/attacks/<?php echo $userlog['favattack'];?>.png" width="80px" />
                                        <?php }?>                                           
                                        </div>                                                                                 
 
 <?php }?>                             
                                                                                  
                                        
                                    </div>
                                  <?php if($rws['user_title'] >= 2){ ?>
                             
                                    <div class="col-md-12  col-sm-12">
                                    <p class="profile-details"><i class="fa fa-plus"></i>Last war</p> 
                                      
                                        
<?php                                        
 $sql3 = "SELECT * FROM war_table ORDER BY war_warid DESC LIMIT 1,1";
    $result3 = mysqli_query($database,$sql3) or die(mysqli_error($database));
    while($warlog3 = mysqli_fetch_array($result3,MYSQLI_BOTH)) { 
	$enemy_name = $warlog3['war_enemy'];
	
?>	   								<div class="col-md-3 col-sm-3 col-xs-12 text-center">
                                     <p><?php echo $enemy_name;?>-Ended</p><hr class="visible-xs" /> 
                                     </div>                                                 
<?Php
   $sql3 = "SELECT * FROM score WHERE user_username='$user_name' AND war_enemy = '$enemy_name' ORDER BY score_id LIMIT 2";
    $result3 = mysqli_query($database,$sql3) or die(mysqli_error($database));
    while($userlog3 = mysqli_fetch_array($result3,MYSQLI_BOTH)) {
  ?>            
                                        <div class="col-md-2 col-sm-2 col-xs-6 text-center">
                                        <img src="imagenes/th/<?php echo $userlog3['score'];?>.png" width="80px" />  
                                        </div> 
                                        <div class="col-md-2 col-sm-2 col-xs-6 text-center" >
                                        <?php if($userlog3['favattack'] == ''){?>
                                        <img src="imagenes/troops/attacks/none.png" width="80px" />  
										<?php }else{?>                              
                                        <img src="imagenes/troops/attacks/<?php echo $userlog3['favattack'];?>.png" width="80px" />
                                        <?php }?>                                           
                                        </div>                                             
                                        
                                        
  <?Php
	}
  ?>    
           
 <?php } ?> 
   </div>                                    
                                    <div class="col-md-12 col-sm-12">
<?php                                        
 $sql3 = "SELECT * FROM war_table ORDER BY war_warid DESC LIMIT 2,1";
    $result3 = mysqli_query($database,$sql3) or die(mysqli_error($database));
    while($warlog3 = mysqli_fetch_array($result3,MYSQLI_BOTH)) { 
	$enemy_name = $warlog3['war_enemy'];
	
?>	   								<div class="col-md-3 col-sm-3 col-xs-12 text-center">
                                     <p><?php echo $enemy_name;?>-Ended</p><hr class="visible-xs" /> 
                                     </div>                                                 
<?Php
   $sql3 = "SELECT * FROM score WHERE user_username='$user_name' AND war_enemy = '$enemy_name' ORDER BY score_id LIMIT 2";
    $result3 = mysqli_query($database,$sql3) or die(mysqli_error($database));
    while($userlog3 = mysqli_fetch_array($result3,MYSQLI_BOTH)) {
  ?>            
                                        <div class="col-md-2 col-sm-2 col-xs-6 text-center">
                                        <img src="imagenes/th/<?php echo $userlog3['score'];?>.png" width="80px" />  
                                        </div> 
                                        <div class="col-md-2 col-sm-2 col-xs-6 text-center" >
                                        <?php if($userlog3['favattack'] == ''){?>
                                        <img src="imagenes/troops/attacks/none.png" width="80px" />  
										<?php }else{?>                              
                                        <img src="imagenes/troops/attacks/<?php echo $userlog3['favattack'];?>.png" width="80px" />
                                        <?php }?>                                           
                                        </div>                                          
                                        
                                        
  <?Php
	}
  ?>    
           
 <?php } ?> 
                                    </div>   
                                    <div class="col-md-12 col-sm-12">
<?php                                        
 $sql3 = "SELECT * FROM war_table ORDER BY war_warid DESC LIMIT 3,1";
    $result3 = mysqli_query($database,$sql3) or die(mysqli_error($database));
    while($warlog3 = mysqli_fetch_array($result3,MYSQLI_BOTH)) { 
	$enemy_name = $warlog3['war_enemy'];
	
?>	   								<div class="col-md-3 col-sm-3 col-xs-12 text-center">
                                     <p><?php echo $enemy_name;?>-Ended</p><hr class="visible-xs" /> 
                                     </div>                                                 
<?Php
   $sql3 = "SELECT * FROM score WHERE user_username='$user_name' AND war_enemy = '$enemy_name' ORDER BY score_id LIMIT 2";
    $result3 = mysqli_query($database,$sql3) or die(mysqli_error($database));
    while($userlog3 = mysqli_fetch_array($result3,MYSQLI_BOTH)) {
  ?>            
                                        <div class="col-md-2 col-sm-2 col-xs-6 text-center">
                                        <img src="imagenes/th/<?php echo $userlog3['score'];?>.png" width="80px" />  
                                        </div> 
                                        <div class="col-md-2 col-sm-2 col-xs-6 text-center" >
                                        <?php if($userlog3['favattack'] == ''){?>
                                        <img src="imagenes/troops/attacks/none.png" width="80px" />  
										<?php }else{?>                              
                                        <img src="imagenes/troops/attacks/<?php echo $userlog3['favattack'];?>.png" width="80px" />
                                        <?php }?>                                           
                                        </div>        
                                        
                                        
  <?Php
	}
  ?>              
           
 <?php } ?> 
                                    </div> 
                                   
                                     <?php } ?>     
                                </div>
                                <div class="col-md-5 col-md-offset-1">
                                <p class="user_title" style="text-align: center; font-size:16;">Heroes Level</p>
                                <hr>
                                    <div class="col-md-6 col-sm-6 col-xs-6"">
                                        <p class="profile-details"><i class="fa fa-plus"></i> Barbarian King</p>  
 <div class="royals">
                                           <span class="pull-left">
      <img class="media-object" src="imagenes/troops/heroes/king.png" alt="<?php echo $rws['user_bk'];?>" height="100" />
      <span class="badge badge-success pull-right" style="font-size:16px; top:-25px;"><?php echo $rws['user_bk'];?></span>
  </span>  
  </div>                                
                                    </div>  
									<?php 
									if($rws['user_th'] == 'th9' || $rws['user_th'] == 'th10'){
									?>
                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                        <p class="profile-details"><i class="fa fa-plus"></i> Archer Queen</p>  
 <div class="royals">
                                           <span class="pull-left">
      <img class="media-object" src="imagenes/troops/heroes/queen.png" alt="<?php echo $rws['user_aq'];?>" height="100" />
      <span class="badge badge-success pull-right" style="font-size:16px; top:-25px;"><?php echo $rws['user_aq'];?></span>
  </span>  
  </div>                                         
                                                                          
                                    </div> 
                                     <?php } else { ?>
                                    <div class="col-md-6">
                                        <p class="profile-details"><i class="fa fa-plus"></i> Archer Queen </p>  
                                        <img src="imagenes/troops/heroes/noaq.png" width="100px" />                                   
                                    </div>                                      
									<?php } ?>                                                                                                                       
                                </div>   
                            </div>                            
                        </div>
                    </div>

            </div>                    
                </div>
            </div>
		<!-- </div> -->
	</div>
</div>           