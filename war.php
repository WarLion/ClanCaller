<?php include 'components/authentication.php' ?> 
<?php include 'components/session-check.php' ?>
<?php include 'controllers/base/head.php' ?>
<?php include 'controllers/navigation/first-navigation.php' ?> 
<?php include 'controllers/base/style.php' ?>
<div class="container">				
				<?php
                    include '_database/database.php';
                    $sql_user = "SELECT * FROM user WHERE user_username='$current_user'";
                    $result_user = mysqli_query($database,$sql_user) or die(mysqli_error($database));
                    while($user = mysqli_fetch_array($result_user)){ 


                    $current_war = $_GET['war_details'];
                    $sql = "SELECT * FROM war_table WHERE war_warid='$current_war'";
                    $result = mysqli_query($database,$sql) or die(mysqli_error($database));
                    while($rws = mysqli_fetch_array($result)){ 
					
					$war_stars = $rws['war_size'];
					$war_stars_total = $war_stars * 3;
					$enemy_name = $rws['war_enemy'];
					
					$sql_call = "SELECT user_username1, user_username2, user_username3, user_username4, count(*) as 'calls' FROM caller WHERE war_enemy = '$enemy_name' && user_username1 = '$current_user' || user_username2 = '$current_user' || user_username3 = '$current_user' || user_username4 = '$current_user' ORDER BY caller_id";
					$result_call = mysqli_query($database,$sql_call) or die(mysqli_error($database));
					while($calls = mysqli_fetch_array($result_call)){ 
						 
					$sql_score = "SELECT SUM(score) FROM score WHERE war_enemy='$enemy_name'";
                    $result_score = mysqli_query($database,$sql_score) or die(mysqli_error($database));
                    while($score = mysqli_fetch_array($result_score)){ 
					
					$score_total = $score['SUM(score)'] 
					?> 

    <h1 class="text-center profile-name" style="margin-top:35;"><?php echo $clananame;?> vs <?php echo $rws['war_enemy'];?></h1><br />
    <div class="col-md-12">
        <div class="col-md-3 col-xs-3 text-right">
<?php $sql = "SELECT SUM(max_score) FROM (SELECT war_enemy, MAX(score) AS max_score FROM score WHERE war_enemy ='$enemy_name' GROUP BY enemy_enemynumber) AS total";
$result = mysqli_query($database,$sql) or die(mysqli_error($database));
while($res = mysqli_fetch_array($result)){ ?>         
        <span class="text-center profile-name" style="font-size:22;"><?php if($res['SUM(max_score)'] == ''){ echo '0';}else { echo $res['SUM(max_score)'];}?></span><br />
        </div>
        <div class="col-md-6 col-xs-6">
                <div class="progress">
              <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?php echo $res['SUM(max_score)'];?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $res['SUM(max_score)'];?>%">
                <span class="sr-only"><?php echo $res['SUM(max_score)'];?> Stars</span>
              </div>
            </div>
<?php }?>              
        </div>
        <div class="col-md-3 col-xs-3">
        <span class="text-center profile-name" style="font-size:22;"><?php echo $war_stars_total;?></span><br />
        </div>      
    </div>   
    <?php }?>

    <div class="col-xs-12" style="margin-top:20px; margin-bottom:20px; padding-bottom:20px;">  
        <div class="text-right">
            <a href="warstats.php?warid=<?php echo $current_war;?>" class="btn btn-success">view stats</a> 
           <a href="#logwar" data-toggle="modal" class="btn btn-info">War Log</a>
        </div>
				<?php $war_size = $_GET['war_size']; $loopvalue = $war_size; $i=1; while ($i <= $loopvalue) { ?>
                    
<div class="col-md-12" style="border-radius: 20px; background-image:url(imagenes/back_panel.png); margin-top: 22px; padding-bottom:20px; padding-top:20px;">
    <div class="row">

<div class="visible-xs col-xs-3"></div> 
<div class="col-xs-6 col-sm-4 col-md-4"><p class="user_title" style="font-size:16;">Enemy - <?php echo $i; ?></p>
        <div style="position: relative; left: 0; top: 0;">
<?php 
		$caller_enemy = $rws['war_enemy'];
        $sql_caller_th = "SELECT * FROM caller WHERE war_enemy = '$caller_enemy' && war_enemynumber = '$i'";
        $result_caller_th = mysqli_query($database,$sql_caller_th) or die(mysqli_error($database));
        while($caller_th = mysqli_fetch_array($result_caller_th)){?>        
             <?php $sql_maxscore = "SELECT MAX(score) FROM score WHERE war_enemy = '$caller_enemy' && enemy_enemynumber = '$i'";
        $result_maxscore = mysqli_query($database,$sql_maxscore) or die(mysqli_error($database));
        while($maxscore = mysqli_fetch_array($result_maxscore)){           
            if ($caller_th['call_th'] !== 'noselect'){?>
            <img  class="img-responsive text-center" src="imagenes/th/<?php echo $caller_th['call_th'];?><?php echo $maxscore['MAX(score)'];?>.png" width="100" height="100" style="position: relative; top: 0; left: 25;"/>
			<?php if ($maxscore['MAX(score)'] >= 0){?>
            <img class="img-responsive  text-center" src="imagenes/th/star<?php echo $maxscore['MAX(score)'];?>.png" width="100" style="position: absolute; top: 10px; left: 25px;"/>
            <?php } }?>
            
            
            <?php if($caller_th['call_base'] !== 'noscreen.jpg'){?>
    <a href="#map<?php echo $i;?>" data-toggle="modal"><img class="img-responsive  text-center" src="imagenes/map.png" width="50" style="position: absolute; top: 0px; left: 100px;"/></a>  
       
     <div class="modal fade bs-example-modal-lg" id="map<?php echo $i;?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><img src="imagenes/close.png" width="20" height="20" /></button>
        <p class="user_title" style="font-size:18; text-align: left;">Enemy - <?php echo $i; ?> - Base</p>
      </div>
      <div class="modal-body">
        <img class="img-responsive center-block" src="userfiles/screenshoots/<?php echo $caller_th['call_base'];?>"/></a> 
      </div>
      <div class="modal-footer" style="text-align:center;">
      <a href="userfiles/screenshoots/<?php echo $caller_th['call_base'];?>" class="btn btn-primary">Full screen</a>
      </div>
    </div>
  </div>
</div>      
            <?php } }?>
<?php  } ?>  
        </div>
    </div>
        <?php 
        $caller_enemy = $rws['war_enemy'];
        $war_enemynumber = $i;
        $sql_caller = "SELECT * FROM caller WHERE war_enemy = '$caller_enemy' && war_enemynumber = '$war_enemynumber'";
        $result_caller = mysqli_query($database,$sql_caller) or die(mysqli_error($database));
        while($caller = mysqli_fetch_array($result_caller)){ ?>    
    <!-- caller 1-->
    <div class="col-xs-6 col-sm-4 col-md-2 text-center" style="padding:20px;">

        
         <?php   if ($caller['user_username1'] == NULL){
         			if ($calls['calls'] != 2 || $user['user_title'] >= 3){?>
                <a href="firstcall.php?e=<?php echo $i;?>" class="btn btn-success">Call It First</a>
        
            <?php } }else{?>
                <ul class="list-unstyled">
                    <li><p class="user_title" style="text-align: center; font-size:11;">Called by</p></li>
                    <li><p  class="user_title" style="text-align: center; font-size:18; color:#FFF;"><?php echo $caller['user_username1'];?></p></li>
         <?php    
		 $user_score = $caller['user_username1'];       
         $sql_score = "SELECT * FROM score WHERE war_enemy = '$caller_enemy' && enemy_enemynumber = '$war_enemynumber' && user_username ='$user_score' LIMIT 1";
        $result_score = mysqli_query($database,$sql_score) or die(mysqli_error($database));
        while($score = mysqli_fetch_array($result_score)){ 
          ?>          
          
                    <li><a href="#myModal<?php echo $i;?>" data-toggle="modal"><img src="imagenes/th/<?php echo $score['score'];?>.png" width="80" /></a></li>
          <!-- popup -->

<div class="modal fade bs-example-modal-sm" id="myModal<?php echo $i;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <p class="modal-title user_title" style="text-align: center; font-size:18;"><?php echo $rws['war_enemy'];?> Enemy - <?php echo $i;?></p>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
          <div class="row">
			<div class="col-md-6">
            	 <div class="row">
                 <label for=""><?php echo $score['user_username'];?>`s attack plan</label>	
                 	<div class="col-md-12" style="padding-bottom:10;">
                    <?php if ($score['plan'] == 'userfiles/screenshoots/noplan.jpg') {?>
                    <?php if ($caller['user_username1'] == $current_user){?>
            			 <form action="planner.php" method="post" enctype="multipart/form-data" id="UploadForm">
                            <input type="hidden" name="enemy" value="<?php echo $i;?>"/>
                            <input type="hidden" name="enemyname" value="<?php echo $rws['war_enemy'];?>"/>
                            <input type="hidden" name="war_size" value="<?php echo $war_size;?>"/>
                            <input type="hidden" name="war_warid" value="<?php echo $current_war;?>"/>
                            <button class="btn btn-success btn-xs" data-style="zoom-in" type="submit"  id="SubmitButton" value="Upload" style="margin-top:10;" />Plan your attack!</button> </form> 
                            <?Php }?>
                        <?php }else{?>
                        <a href="<?php echo $score['plan'];?>"><img src="<?php echo $score['plan'];?>" height="95" class="img-thumbnail"/></a>
                        <?php if ($caller['user_username1'] == $current_user){?>
            			 <p><form action="planner.php" method="post" enctype="multipart/form-data" id="UploadForm">
                            <input type="hidden" name="enemy" value="<?php echo $i;?>"/>
                            <input type="hidden" name="enemyname" value="<?php echo $rws['war_enemy'];?>"/>
                            <input type="hidden" name="war_size" value="<?php echo $war_size;?>"/>
                            <input type="hidden" name="war_warid" value="<?php echo $current_war;?>"/>
                            <button class="btn btn-success btn-xs" data-style="zoom-in" type="submit"  id="SubmitButton" value="Upload" style="margin-top:10;" />edit your plan</button> </form>    </p> 
                            <?php }?>                    
                        <?php }?>
                    </div>
                  </div> 
                    <?php if ($score['favattack']){?>
            	 <div class="row">
                 	<div class="col-md-12">
            			 <img src="imagenes/troops/attacks/<?php echo $score['favattack'];?>.png" width="120" />
                    </div>
                  </div>
                  <?php }?>                 
            </div>
            	 
			<div class="col-md-6"> 	
            	<div class="form-group float-label-control">
                    <label for="">Score</label>	
                <form action="components/update_score.php" method="POST">
                   <input type="image" src="imagenes/th/0.png" width="120" />
                   <input type="hidden" name="stars" value="0"/>
                   <input type="hidden" name="war_enemy" value="<?php echo $rws['war_enemy'];?>"/>
                   <input type="hidden" name="user_username" value="<?php echo $user_score;?>"/>
                   <input type="hidden" name="enemy_enemynumber" value="<?php echo $i;?>"/>
                   <input type="hidden" name="war_detail" value="<?php echo $current_war;?>"/>
                   <input type="hidden" name="war_size" value="<?php echo $rws['war_size'];?>"/>
                   <input type="hidden" name="current_username" value="<?php echo $current_user;?>"/>                    
                </form>
                <form action="components/update_score.php" method="POST">
                   <input type="image" src="imagenes/th/1.png" width="120" />
                   <input type="hidden" name="stars" value="1"/>
                   <input type="hidden" name="war_enemy" value="<?php echo $rws['war_enemy'];?>"/>
                   <input type="hidden" name="user_username" value="<?php echo $user_score;?>"/>
                   <input type="hidden" name="enemy_enemynumber" value="<?php echo $i;?>"/>
                   <input type="hidden" name="war_detail" value="<?php echo $current_war;?>"/>
                   <input type="hidden" name="war_size" value="<?php echo $rws['war_size'];?>"/> 
                   <input type="hidden" name="current_username" value="<?php echo $current_user;?>"/>                  
                </form>   
                <form action="components/update_score.php" method="POST">
                   <input type="image" src="imagenes/th/2.png" width="120" />
                   <input type="hidden" name="stars" value="2"/>
                   <input type="hidden" name="war_enemy" value="<?php echo $rws['war_enemy'];?>"/>
                   <input type="hidden" name="user_username" value="<?php echo $user_score;?>"/>
                   <input type="hidden" name="enemy_enemynumber" value="<?php echo $i;?>"/>
                   <input type="hidden" name="war_detail" value="<?php echo $current_war;?>"/>
                   <input type="hidden" name="war_size" value="<?php echo $rws['war_size'];?>"/> 
                   <input type="hidden" name="current_username" value="<?php echo $current_user;?>"/>                  
                </form>
                <form action="components/update_score.php" method="POST">
                   <input type="image" src="imagenes/th/3.png" width="120" />
                   <input type="hidden" name="stars" value="3"/>
                   <input type="hidden" name="war_enemy" value="<?php echo $rws['war_enemy'];?>"/>
                   <input type="hidden" name="user_username" value="<?php echo $user_score;?>"/>
                   <input type="hidden" name="enemy_enemynumber" value="<?php echo $i;?>"/>
                   <input type="hidden" name="war_detail" value="<?php echo $current_war;?>"/>
                   <input type="hidden" name="war_size" value="<?php echo $rws['war_size'];?>"/> 
                   <input type="hidden" name="current_username" value="<?php echo $current_user;?>"/>                  
                </form> 
                </div>
        	</div>
          </div>
        </div>        
        

      </div>
    </div>
  </div>
</div>
 <!--   popup --> 
 <!--------- war log modal --------------->
     <div class="modal fade bs-example-modal-lg" id="logwar" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><img src="imagenes/close.png" width="20" height="20" /></button>
        <p class="user_title" style="font-size:18; text-align: left;"><?php echo $enemy_name;?> War Log</p>
      </div>
      <div class="modal-body text-center" style="padding:30px;">
<?php  
		$caller_enemy = $rws['war_enemy'];
		$sql_log = "SELECT * FROM war_log WHERE log_clanname = '$caller_enemy' order by log_id ASC";
        $result_log = mysqli_query($database,$sql_log) or die(mysqli_error($database));
        while($log = mysqli_fetch_array($result_log)){ ?>  
         
         
         <?php 
		 if($log['log_status'] != 'Score'){
			 if($log['log_username'] != $log['log_as_user']){?>
			<?php echo $log['log_as_user'];?> as <?php echo $log['log_username'];?>, <?php echo $log['log_status'];?> Enemy <?php echo $log['log_enemy_number'];?> <br />
			<?php }else{?>
			<?php echo $log['log_username'];?> <?php echo $log['log_status'];?> Enemy <?php echo $log['log_enemy_number'];?><br />
			<?php }
		 }else{
		?>
        <?php
			 if($log['log_username'] != $log['log_as_user']){?>
			<?php echo $log['log_as_user'];?> as <?php echo $log['log_username'];?>, add <?php echo $log['log_score'];?> stars to Enemy <?php echo $log['log_enemy_number'];?><br />
			<?php }else{?>
			<?php echo $log['log_as_user'];?> add <?php echo $log['log_score'];?> stars to Enemy <?php echo $log['log_enemy_number'];?><br />
			<?php }  ?>      	
        <?php }?>
        
        
        
<?php }?>        
      </div>
    </div>
  </div>
</div>  
<!--------- end war log modal --------------->                             
                   <?php if ($score['plan'] == 'userfiles/screenshoots/noplan.jpg'){?>
                   		<?php if ($caller['user_username1'] == $current_user){?>
                     <li>
                            <form action="planner.php" method="post" enctype="multipart/form-data" id="UploadForm">
                            <input type="hidden" name="enemy" value="<?php echo $i;?>"/>
                            <input type="hidden" name="enemyname" value="<?php echo $rws['war_enemy'];?>"/>
                            <input type="hidden" name="war_size" value="<?php echo $war_size;?>"/>
                            <input type="hidden" name="war_warid" value="<?php echo $current_war;?>"/>
                            <button class="btn btn-success btn-xs" data-style="zoom-in" type="submit"  id="SubmitButton" value="Upload" style="margin-top:10;" />Plan your attack!</button>
                            </form>                     </li>
                    <?php } }?>
           <?php }?>         
                    
                        <?php if ($caller['user_username1'] == $current_user || $user['user_title'] >= 4){?>
                        <?PhP if($caller['user_username2'] == NULL || $user['user_title'] >= 4){?>
                        	<div style="margin-top:20px; margin-bottom:-30px;">
                            <form action="components/delete-caller.php?e=<?php echo $i; ?>&e2=<?php echo $rws['war_enemy'];?>" method="post" enctype="multipart/form-data" id="UploadForm">
                            <input type="hidden" name="war_warid" value="<?php echo $current_war;?>"/>
                            <input type="hidden" name="war_size" value="<?php echo $war_size;?>"/>
                            <input type="hidden" name="user_call" value="user_username1"/>
                            <input type="hidden" name="current_username" value="<?php echo $current_user;?>"/>
                            <input type="hidden" name="user_callit" value="<?php echo $caller['user_username1'];?>"/>
                            <button class="btn btn-danger btn-xs" data-style="zoom-in" type="submit"  id="SubmitButton" value="Upload" style="margin-top:10;" onclick="return confirm('Are you sure you want to delete the call on Enemy <?php echo $i; ?> by <?php echo $caller['user_username1'];?>?')"/>Delete</button>
                            </form>
                            </div>
                            <?php }?>
                        <?php }?>
                </ul>
            <?php  }?>   
              
    </div>
	<!-- end caller 1-->
    
    <!-- second call ----->
<?php include 'war2.php' ?>
     <!---end second call ---> 
	<!-- third call ----->
<?php include 'war3.php' ?>    
     <!---end third call --->
	<!-- forth call ----->
<?php include 'war4.php' ?>      
     <!---end forth call --->  
     
     
     
     
 <?php   }?> 

    </div>

</div>
	<?php $i++;};?>                 
        
  			<?php } } }?>
               
</div> 

