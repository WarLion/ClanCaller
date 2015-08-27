<?php include 'components/authentication.php' ?>     
<?php include 'components/session-check.php' ?>
<?php include 'controllers/base/head.php' ?>
<?php include 'controllers/navigation/first-navigation.php' ?>  
<?php include 'controllers/base/style.php' ?>
<?php $current_user = $_SESSION['user_username'];?>   
<div style="padding-bottom:30px;">	
    
    <div class="text-center logo"><a href="index.php"><img src="imagenes/logo.png" width="117" height="109" /></a></div>
    
<div class="container" style="padding-top:0px;">


<!--- current war start--->
<!-- war log start --->
		<?php include '_database/database.php';
        $current_user = $_SESSION['user_username'];
        $sql = "SELECT * FROM war_table order by war_warid DESC LIMIT 1";
        $result = mysqli_query($database,$sql) or die(mysqli_error($database));
        while($rws = mysqli_fetch_array($result)){ 
					$war_enemy = $rws['war_enemy'];
					$sql_score = "SELECT SUM(score) FROM score WHERE war_enemy='$war_enemy'";
                    $result_score = mysqli_query($database,$sql_score) or die(mysqli_error($database));
                    while($score = mysqli_fetch_array($result_score)){ 
					$score_total = $score['SUM(score)']
        ?>
       <?php if($rws['war_enemy']){?> 
<h2 class="text-center profile-text profile-profession">Current War</h2>
    <div class="col-md-12">
        
<div class="row">
    <div class="panel panel-primary" style="border-radius: 19px; background-color:#CCC;">
        <div class="panel-heading text-center profile-text profile-profession"  style="border-radius: 19px 19px 0px 0px; border:solid #FFF 1px;"><img src="imagenes/logo.png" height="30" /> vs <?php echo $rws['war_enemy']; ?></div>
            <div class="panel-body">
                <div class="col-md-2 col-sm-12 text-center" style="font-family: supercellfont;">
                	<strong>Active</strong>
                </div>
                <div class="col-md-2 col-sm-2 col-xs-12 text-center">
<?php $sql = "SELECT SUM(max_score) FROM (SELECT war_enemy, MAX(score) AS max_score FROM score WHERE war_enemy ='$war_enemy' GROUP BY enemy_enemynumber) AS total";
$result = mysqli_query($database,$sql) or die(mysqli_error($database));
while($res = mysqli_fetch_array($result)){  ?>    

               
               	 <strong><?php if($res['SUM(max_score)'] == NULL){ echo '0';}else { echo $res['SUM(max_score)'];}?> <span class="fa fa-star"></span></strong>
                </div>
                <div class="col-md-4 col-sm-5 col-xs-12">
                    <div class="progress">
                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?php echo $res['SUM(max_score)'];?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $res['SUM(max_score)'];?>%">
                        </div>
                    </div>
                </div>  
                <div class="col-md-2 col-sm-3 col-xs-12 text-center">
               	 <strong><?php echo $rws['war_size'] * 3; ?> <span class="fa fa-star"></span> Total</strong>
                </div>
                <div class="col-md-2 col-sm-2 col-xs-12 text-center">
               	 <a href="war.php?war_details=<?php echo $rws['war_warid']; ?>&war_size=<?php echo $rws['war_size']; ?>" class="btn btn-primary">Details</a>
                 </div>
                </div>                                              
            </div>
        </div>

                                                      
</div>
<?php } }?>         

        <?php  } } ?> 
         
       
<!-- war log start --->
<div class="row"></div>
 <div class="col-md-12" style="margin-top:-15; top:15;">
<div class="row">
    <div class="panel panel-primary" style="border-radius: 19px 19px 0px 0px;  border:solid #CCC 1px;">
        <div class="panel-heading text-center profile-text profile-profession"  style="border-radius: 19px 19px 0px 0px; background-color:#333; height:40px; border:#333; font-size:16px; font-family: supercellfont;"><strong>Ended Wars</strong></div>

<!-- war log start --->
		<?php include '_database/database.php';
        $current_user = $_SESSION['user_username'];
         $sql = "SELECT * FROM war_table order by war_warid DESC LIMIT 1, 20";
        $result = mysqli_query($database,$sql) or die(mysqli_error($database));
        while($rws = mysqli_fetch_array($result)){ 
		$war_enemy_name = $rws['war_enemy'];
		        ?>
<?php if($rws['war_enemy']){?>
            <div class="panel-body" style=" border:solid #333 1px; background-color:#ccc;">
                <div class="col-md-2 col-sm-12 text-center">
                	<strong> <?php echo $clananame;?> vs <?php echo $rws['war_enemy']; ?></strong>
                </div>
                <div class="col-md-2 col-sm-2 col-xs-12 text-center">
<?php $sql2 = "SELECT SUM(max_score) FROM (SELECT war_enemy, MAX(score) AS max_score FROM score WHERE war_enemy ='$war_enemy_name' GROUP BY enemy_enemynumber) AS total";
$result2 = mysqli_query($database,$sql2) or die(mysqli_error($database));
while($res = mysqli_fetch_array($result2)){  ?>                  
               	 <strong><?php if($res['SUM(max_score)'] == ''){ echo '0';}else { echo $res['SUM(max_score)'];}?> <span class="fa fa-star"></span></strong>
                </div>
                <div class="col-md-4 col-sm-5 col-xs-12">
                    <div class="progress">
                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?php echo $res['SUM(max_score)'];?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $res['SUM(max_score)'];?>%">
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
                 <a href="components/delwar.php?id=<?php echo $rws['war_warid']; ?>" class="btn btn-danger">Delete</a>
<?php } }?>                 
                 </div>
                </div>                                              
            

</div>
        </div>
   <?php  } }?>
        

                                                                
</div>

<!-- war log end --->

</div>
</div>