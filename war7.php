<!-- second call ----->
    <?PhP if($caller['user_username6']){?>
	<div class="col-md-2 col-sm-4 col-xs-6  text-center" style="padding:20px;">
		<?php  if ($caller['user_username7'] == NULL){
				if ($caller['user_username6'] !== $current_user || $user['user_title'] >= 3){	
					if ($caller['user_username5'] !== $current_user || $user['user_title'] >= 3){
						if ($caller['user_username4'] !== $current_user || $user['user_title'] >= 3){
							if ($caller['user_username3'] !== $current_user || $user['user_title'] >= 3){
								if ($caller['user_username2'] !== $current_user || $user['user_title'] >= 3){
						if ($caller['user_username1'] !== $current_user || $user['user_title'] >= 3){
			if ($calls['calls'] != 2 || $user['user_title'] >= 3){?>
 <a href="callit.php?e=<?php echo $i;?>&a=7" class="btn btn-success"  style="margin-top:80px;">Call it</a>
        
        <?php } } } }}}} }else{?>
            <ul class="list-unstyled">
                    <li><p class="user_title" style="text-align: center; font-size:11;">Called by</p></li>
                    <li><p  class="user_title" style="text-align: center; font-size:18; color:#FFF;"><?php echo $caller['user_username7'];?></p></li>
         <?php    
		 $user_score = $caller['user_username7']; // change for # of calls      
         $sql_score = "SELECT * FROM score WHERE war_enemy = '$caller_enemy' && enemy_enemynumber = '$war_enemynumber' && user_username ='$user_score' LIMIT 1";
        $result_score = mysqli_query($database,$sql_score) or die(mysqli_error($database));
        while($score = mysqli_fetch_array($result_score)){ 
          ?>  
                    <li><a href="#myModal4<?php echo $i;?>" data-toggle="modal"><img src="imagenes/th/<?php echo $score['score'];?>.png" width="80" /></a></li>
   <!-- timer -->
           <?php 
		   if ($score['score'] == 0){
		   $log_user = $caller['user_username7'];
		   $log_clan = $rws['war_enemy'];
		$time = "SELECT log_end_time FROM war_log WHERE log_username='$log_user' && log_enemy_number = '".$i."' && log_clanname='$log_clan'";
            $timer = mysqli_query($database,$time) or die(mysqli_error($database));
            while($tim = mysqli_fetch_array($timer)){ 	   
           
		   
		   ?>
                    <div data-countdown="<?php echo $tim['log_end_time'];?>" style=" font-weight:bold; color:red;"></div>				
					<?php } }?>  
   <!-- end timer -->                      
          <!-- popup -->

<div class="modal fade bs-example-modal-sm" id="myModal4<?php echo $i;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
                          <?php if ($caller['user_username6'] == $current_user){?>
            			 <form action="planner.php" method="post" enctype="multipart/form-data" id="UploadForm">
                            <input type="hidden" name="enemy" value="<?php echo $i;?>"/>
                            <input type="hidden" name="enemyname" value="<?php echo $rws['war_enemy'];?>"/>
                            <input type="hidden" name="war_size" value="<?php echo $war_size;?>"/>
                            <input type="hidden" name="war_warid" value="<?php echo $current_war;?>"/>
                            <button class="btn btn-success btn-xs" data-style="zoom-in" type="submit"  id="SubmitButton" value="Upload" style="margin-top:10;" />Plan your attack!</button></form> 
                            <?php }?>
                        <?php }else{?>
                        <a href="<?php echo $score['plan'];?>"><img src="<?php echo $score['plan'];?>" height="95" class="img-thumbnail"/></a>
                         <?php if ($caller['user_username7'] == $current_user){?>
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
                   <?php if ($score['plan'] == 'userfiles/screenshoots/noplan.jpg'){?>
                   		<?php if ($caller['user_username7'] == $current_user){?>
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
                    <?php if ($caller['user_username7'] == $current_user  || $user['user_title'] >= 4){?>
                    <?PhP if($caller['user_username8'] == NULL  || $user['user_title'] >= 4){?>
                        <form action="components/delete-caller.php?e=<?php echo $i; ?>&e2=<?php echo $rws['war_enemy'];?>" method="post" enctype="multipart/form-data" id="UploadForm">
                        <input type="hidden" name="war_warid" value="<?php echo $current_war;?>"/>
                        <input type="hidden" name="war_size" value="<?php echo $war_size;?>"/>
                            <input type="hidden" name="user_call" value="user_username7"/>
                            <input type="hidden" name="user_callit" value="<?php echo $caller['user_username7'];?>"/>
                            <input type="hidden" name="current_username" value="<?php echo $current_user;?>"/>  
                        <button class="btn btn-danger btn-xs" data-style="zoom-in" type="submit"  id="SubmitButton" value="Upload" style="margin-top:10;" onclick="return confirm('Are you sure you want to delete the call on Enemy <?php echo $i; ?> by <?php echo $caller['user_username7'];?>?')"/>Delete</button>
                        </form>
                    <?php }?>
                    <?php }?>
            </ul> 
        <?php  }?>   
	</div>
    <?php }?>
     <!---end second call ---> 