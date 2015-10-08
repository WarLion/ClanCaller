<?php include 'components/authentication.php' ?>     
<?php include 'components/session-check.php' ?>
<?php include 'controllers/base/head.php' ?>
<?php include 'controllers/navigation/first-navigation.php' ?>  
<div style="padding-bottom:30px;">	
    
    <h1 class="text-center profile-name">Welcome Back <?php echo $current_user;?></h1>
    <div class="container">
<!--     <div id="cookies" class="col-md-12">
 <div class="alert alert-success">
    <a  class="close" id="hide">&times;</a>
    <img src="imagenes/trophy.gif" width="30" /> Starting today begins the results of the month to see who is the best clasher, do not let them win, to win you have to make your calls and add your results to accumulate your stars. Good luck everyone.
  </div>
   </div>  
   </div> 

    
 <script>   
  $(document).ready(function() {
    $("#hide").click(function() {
        $("#cookies").slideUp(1000);
    }); // don't forget the semicolon here
});
</script> -->

<div class="container">
<div class="col-md-4 col-sm-6">
<div class="col-md-12">
<div class="panel panel-primary" style="border:solid #CCC 1px; border-radius: 19px;">
        <div class="panel-heading text-center "  style=" background-color:#093; border-radius: 19px 19px 0px 0px; border:solid #063 1px;">Top 3 Hitters <?php echo date('M');?><a href="#" data-toggle="collapse" data-target="#col-izq-5" style="font-weight:bold;"><span class="pull-right fa fa-remove"></span></a></div>
		 <div id="col-izq-5" class="collapse in panel-body">
  <!-- Table -->
  <table class="table">
 <?php
$month = date('n');
$year = date('Y');
	 $sql = "SELECT log_username, SUM(log_score) FROM war_log WHERE log_status='score' && YEAR(log_end_time) = '$year' AND MONTH(log_end_time) = '$month' GROUP BY log_username ORDER BY SUM(log_score) DESC LIMIT 3";
    $result = mysqli_query($database,$sql) or die(mysqli_error($database));
	$i=1;
    while($rws = mysqli_fetch_array($result)){
		$num = $i++;
if ($current_user == $rws['log_username']){
	$color = 'style="background-color:#e8e7e7;"';
}else{
	$color ='';
}			
		if ($rws['SUM(log_score)'] !=NULL){?>
    <tr <?php echo $color;?>>
        <td><?php if($num==1){?><img src="imagenes/trophy.png" height="30" /><?php }elseif($num==2){?><img src="imagenes/trophy2.png" height="30" /> <?php }elseif($num==3){?><img src="imagenes/trophy3.png" height="30" /> <?php }?>  <a href="profile.php?user_username=<?php echo $rws['log_username'];?>" style="font-weight:bold;"><?php echo $rws['log_username'];?></a></td>
        <td ><?php echo $rws['SUM(log_score)'];?> <i class="fa fa-star"></i></td>
    </tr>
    <?php } }?>  
  </table>
  		</div>
                <div class="text-center">
        <a href="top_month.php" class="btn btn-primary btn-xs">View All</a>
        </div>
</div>
</div>
<div class="col-md-12">
<div class="panel panel-primary" style="border-radius: 19px;">
        <div class="panel-heading text-center "  style="border-radius: 19px 19px 0px 0px; border:solid #FFF 1px;">Top 3 Attackers all time<a href="#" data-toggle="collapse" data-target="#col-izq-1" style="font-weight:bold;"><span class="pull-right fa fa-remove"></span></a></div>
		 <div id="col-izq-1" class="collapse in panel-body">
  <!-- Table -->
  <table class="table">
 <?php
 	
    $sql = "SELECT user_username, SUM(score) FROM score GROUP BY user_username ORDER BY SUM(score) DESC LIMIT 3";
    $result = mysqli_query($database,$sql) or die(mysqli_error($database));
	$i=1;
    while($rws = mysqli_fetch_array($result)){
		$num = $i++;
if ($current_user == $rws['user_username']){
	$color = 'style="background-color:#e8e7e7;"';
}else{
	$color ='';
}			?>
    <tr <?php echo $color;?>>
        <td><?php if($num==1){?><img src="imagenes/trophy.png" height="30" /><?php }elseif($num==2){?><img src="imagenes/trophy2.png" height="30" /> <?php }elseif($num==3){?><img src="imagenes/trophy3.png" height="30" /> <?php }?>  <a href="profile.php?user_username=<?php echo $rws['user_username'];?>" style="font-weight:bold;"><?php echo $rws['user_username'];?></a></td>
        <td ><?php echo $rws['SUM(score)'];?> <i class="fa fa-star"></i></td>
    </tr>
    <?php }	 
	?>  
  </table>
  		</div>
</div>
</div>
</div>

<div class="col-md-3 col-sm-6">
<div class="panel panel-primary" style="border-radius: 19px;">
        <div class="panel-heading text-center "  style="border-radius: 19px 19px 0px 0px; border:solid #FFF 1px;">5 Best Hitters Current War<a href="#" data-toggle="collapse" data-target="#col-izq-3" style="font-weight:bold;"><span class="pull-right fa fa-remove"></span></a></div>
		 <div id="col-izq-3" class="collapse in panel-body">
  <!-- Table -->
  <table class="table">
 <?php
        $sql = "SELECT * FROM war_table order by war_warid DESC LIMIT 1";
        $result = mysqli_query($database,$sql) or die(mysqli_error($database));
        while($rws = mysqli_fetch_array($result)){  
 	$war_enemy = $rws['war_enemy'];
    $sql = "SELECT user_username, SUM(score) FROM score WHERE war_enemy='$war_enemy' GROUP BY user_username ORDER BY SUM(score) DESC LIMIT 5";
    $result = mysqli_query($database,$sql) or die(mysqli_error($database));
	$i=1;
    while($rws2 = mysqli_fetch_array($result)){
		$num = $i++;
if ($current_user == $rws2['user_username']){
	$color = 'style="background-color:#e8e7e7;"';
}else{
	$color ='';
}			
		if ($rws2['SUM(score)'] !=NULL){
		?>
    <tr <?php echo $color;?>>
        <td><?php if($num==1){?><img src="imagenes/trophy.png" height="30" /><?php }elseif($num==2){?><img src="imagenes/trophy2.png" height="30" /> <?php }elseif($num==3){?><img src="imagenes/trophy3.png" height="30" /> <?php }?> <a href="profile.php?user_username=<?php echo $rws2['user_username'];?>" style="font-weight:bold;"><?php echo $rws2['user_username'];?></a></td>
        <td ><?php echo $rws2['SUM(score)'];?> <i class="fa fa-star"></i></td>
    </tr>
    <?php } }	} 
	?>  
  </table>
  		</div>

</div>
</div>

<div class="col-md-5 col-sm-6">
<div class="panel panel-primary" style="border-radius: 19px;">
        <div class="panel-heading text-center "  style="border-radius: 19px 19px 0px 0px; border:solid #FFF 1px;"><?php echo $current_user;?> these are your calls!<a href="#" data-toggle="collapse" data-target="#col-izq-2" style="font-weight:bold;"><span class="pull-right fa fa-remove"></span></a></div>
		 <div id="col-izq-2" class="collapse in panel-body">
<?Php
  $user_name = $current_user;
   $sql2 = "SELECT * FROM score WHERE user_username='$user_name' AND war_enemy = '$war_enemy' ORDER BY score_id LIMIT 2";
    $result2 = mysqli_query($database,$sql2) or die(mysqli_error($database));
    while($userlog = mysqli_fetch_array($result2,MYSQLI_BOTH)) {
  ?>                                       
                                         
                                         
                                         <div class="col-md-2 col-sm-12 col-xs-12 text-center">
                                         Enemy<br />
                                         <strong><?php echo $userlog['enemy_enemynumber'];?></strong>
                                         </div>
                                        <div class="col-md-5 col-sm-6 col-xs-6 text-center">
                                        <?php if($userlog['score'] == NULL){?>
                                        <a href="#myModal<?php echo $userlog['enemy_enemynumber'];?>" data-toggle="modal" onClick="return confirm('are you ready to imput your score on enemy <?php echo $userlog['enemy_enemynumber'];?>?')">
                                        <img src="imagenes/th/<?php if($userlog['score'] == NULL){echo 'none';}else{ echo $userlog['score'];}?>.png" width="90px" /> 
                                        </a>
                                        <?php }else{?>
                                        <img src="imagenes/th/<?php if($userlog['score'] == NULL){echo 'none';}else{ echo $userlog['score'];}?>.png" width="90px" /> 
                                        <?php }?>
                                        </div> 
                                        <div class="col-md-5 col-sm-6 col-xs-6 text-center" >
                                        <?php if($userlog['favattack'] == ''){?>
                                        <img src="imagenes/troops/attacks/none.png" width="60px" />  
										<?php }else{?>                              
                                        <img src="imagenes/troops/attacks/<?php echo $userlog['favattack'];?>.png" width="60px" />
                                        <?php }?>
                                        </div>
                                         
                                        
                                                                                                                      

 
 <div class="modal fade bs-example-modal-sm" id="myModal<?php echo $userlog['enemy_enemynumber'];?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <p class="modal-title user_title" style="text-align: center; font-size:18;"><?php echo $war_enemy;?> Enemy - <?php echo $userlog['enemy_enemynumber'];?></p>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
          <div class="row">
			<div class="col-md-12 text-center"> 	
            	<div class="form-group float-label-control">
                <?php
				        $sql = "SELECT * FROM war_table order by war_warid DESC LIMIT 1";
        $result = mysqli_query($database,$sql) or die(mysqli_error($database));
        while($rws = mysqli_fetch_array($result)){ ?>
                    <label for="">Score</label>	
                <form action="components/update_score_home.php" method="POST">
                   <input type="image" src="imagenes/th/0.png" width="120" />
                   <input type="hidden" name="stars" value="0"/>
                   <input type="hidden" name="war_enemy" value="<?php echo $war_enemy;?>"/>
                   <input type="hidden" name="user_username" value="<?php echo $current_user;?>"/>
                   <input type="hidden" name="enemy_enemynumber" value="<?php echo $userlog['enemy_enemynumber'];?>"/>
                   <input type="hidden" name="current_username" value="<?php echo $current_user;?>"/>                    
                </form>
                <form action="components/update_score_home.php" method="POST">
                   <input type="image" src="imagenes/th/1.png" width="120" />
                   <input type="hidden" name="stars" value="1"/>
                   <input type="hidden" name="war_enemy" value="<?php echo $war_enemy;?>"/>
                   <input type="hidden" name="user_username" value="<?php echo $current_user;?>"/>
                   <input type="hidden" name="enemy_enemynumber" value="<?php echo $userlog['enemy_enemynumber'];?>"/>
                   <input type="hidden" name="current_username" value="<?php echo $current_user;?>"/>                  
                </form>   
                <form action="components/update_score_home.php" method="POST">
                   <input type="image" src="imagenes/th/2.png" width="120" />
                   <input type="hidden" name="stars" value="2"/>
                   <input type="hidden" name="war_enemy" value="<?php echo $war_enemy;?>"/>
                   <input type="hidden" name="user_username" value="<?php echo $current_user;?>"/>
                   <input type="hidden" name="enemy_enemynumber" value="<?php echo $userlog['enemy_enemynumber'];?>"/>
                   <input type="hidden" name="current_username" value="<?php echo $current_user;?>"/>                  
                </form>
                <form action="components/update_score_home.php" method="POST">
                   <input type="image" src="imagenes/th/3.png" width="120" />
                   <input type="hidden" name="stars" value="3"/>
                   <input type="hidden" name="war_enemy" value="<?php echo $war_enemy;?>"/>
                   <input type="hidden" name="user_username" value="<?php echo $current_user;?>"/>
                   <input type="hidden" name="enemy_enemynumber" value="<?php echo $userlog['enemy_enemynumber'];?>"/>
                   <input type="hidden" name="current_username" value="<?php echo $current_user;?>"/>                  
                </form> 
                <?php }?>
                </div>
        	</div>
          </div>
        </div>        
        

      </div>
    </div>
  </div>
</div>
<?php }?> 
 <!--   popup -->           
  		</div>
</div>
</div>
<!--- current war start--->
<!-- war log start --->
<div class="col-md-12 col-sm-12 col-xs-12">
		<?php include '_database/database.php';
        $sql = "SELECT * FROM war_table order by war_warid DESC LIMIT 1";
        $result = mysqli_query($database,$sql) or die(mysqli_error($database));
        while($rws = mysqli_fetch_array($result)){ 
					$war_stars = $rws['war_size'];
					$war_stars_total = $war_stars * 3;			
					$war_enemy = $rws['war_enemy'];
					$sql_score = "SELECT SUM(score) FROM score WHERE war_enemy='$war_enemy'";
                    $result_score = mysqli_query($database,$sql_score) or die(mysqli_error($database));
                    while($score = mysqli_fetch_array($result_score)){ 
					$score_total = $score['SUM(score)'];
        ?>
       <?php if($rws['war_enemy']){?> 
    <div class="panel panel-primary" style="border-radius: 19px; background-color:#CCC;">
        <div class="panel-heading text-center profile-text profile-profession"  style="border-radius: 19px 19px 0px 0px; border:solid #FFF 1px;"><img src="imagenes/logo.png" height="30" /> vs <?php echo $rws['war_enemy']; ?></div>
            <div class="panel-body">
                <div class="col-md-2 col-sm-2 col-xs-4 text-center">
<?php $sql = "SELECT SUM(max_score) FROM (SELECT war_enemy, MAX(score) AS max_score FROM score WHERE war_enemy ='$war_enemy' GROUP BY enemy_enemynumber) AS total";
$result = mysqli_query($database,$sql) or die(mysqli_error($database));
while($res = mysqli_fetch_array($result)){ 
$porcent = ($res['SUM(max_score)'] * 100) / $war_stars_total; 
 ?>    

               
               	 <strong><?php if($res['SUM(max_score)'] == NULL){ echo '0';}else { echo $res['SUM(max_score)'];}?> <span class="fa fa-star"></span></strong>
                </div>
                <div class="col-md-8 col-sm-8 col-xs-8">
                    <div class="progress">
                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?php echo $res['SUM(max_score)'];?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $porcent;?>%">
                        </div>
                    </div>
                </div>  
                <div class="col-md-2 col-sm-2 col-xs-12 text-center">
               	 <a href="war.php?war_details=<?php echo $rws['war_warid']; ?>&war_size=<?php echo $rws['war_size']; ?>" class="btn btn-primary">Details</a>
                 </div>
                </div>                                              
            </div>
<?php } }?>         

        <?php  } } ?> 
         
      </div> 
<!-- war log start --->
<div class="row"></div>
 <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top:-15; top:15;">
<div class="row">
    <div class="panel panel-primary" role="tab" id="headingOne" style="border-radius: 19px 19px 19px 19px;  border:solid #CCC 1px;  background-color:#333;">
        <div class="panel-heading text-center profile-text profile-profession"  style="border-radius: 19px 19px 19px 19px; background-color:#333; height:40px; border:#333; font-size:16px; font-family: supercellfont;"> <a role="button" data-toggle="collapse" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne"><strong>Ended Wars</strong></a></div>
  <div id="collapseOne" class="collapse" >
<!-- war log start --->
		<?php include '_database/database.php';
         $sql = "SELECT * FROM war_table order by war_warid DESC LIMIT 1, 5";
        $result = mysqli_query($database,$sql) or die(mysqli_error($database));
        while($rws = mysqli_fetch_array($result)){ 
		$war_enemy_name = $rws['war_enemy'];
					$war_stars = $rws['war_size'];
					$war_stars_total = $war_stars * 3;		
		        ?>
<?php if($rws['war_enemy']){?>
            <div class="panel-body" style=" border:solid #333 1px; background-color:#ccc;">
                <div class="col-md-2 col-sm-12 text-center">
                	<strong> <?php echo $clananame;?> vs <?php echo $rws['war_enemy']; ?></strong>
                </div>
                <div class="col-md-2 col-sm-2 col-xs-12 text-center">
<?php $sql2 = "SELECT SUM(max_score) FROM (SELECT war_enemy, MAX(score) AS max_score FROM score WHERE war_enemy ='$war_enemy_name' GROUP BY enemy_enemynumber) AS total";
$result2 = mysqli_query($database,$sql2) or die(mysqli_error($database));
while($res = mysqli_fetch_array($result2)){  
$porcent = ($res['SUM(max_score)'] * 100) / $war_stars_total; 
?>                  
               	 <strong><?php if($res['SUM(max_score)'] == ''){ echo '0';}else { echo $res['SUM(max_score)'];}?> <span class="fa fa-star"></span></strong>
                </div>
                <div class="col-md-4 col-sm-5 col-xs-12">
                    <div class="progress">
                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?php echo $res['SUM(max_score)'];?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $porcent;?>%">
<?php }?>                         
                        </div>
                    </div>
                </div>  
                <div class="col-md-2 col-sm-3 col-xs-12 text-center">
               	 <strong><?php echo $rws['war_size'] * 3; ?> <span class="fa fa-star"></span> Total</strong>
                </div>
                <div class="col-md-2 col-sm-2 col-xs-12 text-center">
               	 <a href="war_ended.php?war_details=<?php echo $rws['war_warid']; ?>&war_size=<?php echo $rws['war_size']; ?>" class="btn btn-info">Details</a>
<?php 
$sqluser = "SELECT * FROM user WHERE user_username = '$current_user'";
$resultuser = mysqli_query($database,$sqluser) or die(mysqli_error($database));
while($user = mysqli_fetch_array($resultuser)){  

		if($user['user_title'] >= 5) {?>                  
                 <a href="components/delwar.php?id=<?php echo $rws['war_warid']; ?>" class="btn btn-danger" onClick="return confirm('Are you sure you want to delete this log?')">Delete</a>
<?php } }?>                 
                 </div>
                </div>                                              
            


   <?php  } }?>
         <div style="border-radius: 0px 0px 19px 19px;  border:solid #CCC 1px; background-color:#333; height:20px;"></div>
</div>
        </div>
                                                                
</div>
</div>

<!-- war log end --->

</div>
</div>
