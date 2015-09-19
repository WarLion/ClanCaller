<?php include 'components/authentication.php' ?> 
<?php include 'components/session-check.php' ?>
<?php include 'controllers/base/head.php' ?>
<?php include 'controllers/navigation/first-navigation.php' ?> 
<div class="container">				
				<?php
                    include '_database/database.php';
                    $current_war = $_GET['war_details'];
                    $sql = "SELECT * FROM war_table WHERE war_warid='$current_war'";
                    $result = mysqli_query($database,$sql) or die(mysqli_error($database));
                    while($rws = mysqli_fetch_array($result)){ 
					
					$war_stars = $rws['war_size'];
					$war_stars_total = $war_stars * 3;
					$enemy_name = $rws['war_enemy'];
					
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
        <span class="text-center profile-name" style="font-size:22;"><?php echo $res['SUM(max_score)'];?></span><br />
        </div>
        <div class="col-md-6 col-xs-6">
                <div class="progress">
              <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?php echo $res['SUM(max_score)'];?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $res['SUM(max_score)'];?>%">
                <span class="sr-only">40% Complete (success)</span>
              </div>
            </div>
<?php }?>              
        </div>
        <div class="col-md-3 col-xs-3">
        <span class="text-center profile-name" style="font-size:22;"><?php echo $war_stars_total;?></span><br />
        </div>      
    </div>   
    <?php }?>
    <div class="text-right"><a href="warstats.php?warid=<?php echo $current_war;?>" class="btn btn-success">view stats</a></div>
    <div class="col-xs-12" style="margin-top:20px; margin-bottom:20px; padding-bottom:20px;">  
    
				<?php $war_size = $_GET['war_size']; $loopvalue = $war_size; $i=1; while ($i <= $loopvalue) { ?>
                
<div class="col-md-12" style="border-radius: 20px; background-image:url(imagenes/back_panel.png); margin-top: 22px; padding-bottom:20px; padding-top:20px;">
    <div class="row">


<div class="col-xs-12 col-sm-6 col-md-3 col-lg-2 text-center"><h1><?php echo $i; ?></h1></div>
    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-2 text-center">
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
    <a href="userfiles/screenshoots/<?php echo $caller_th['call_base'];?>"><img class="img-responsive  text-center" src="imagenes/map.png" width="50" style="position: absolute; top: 0px; left: 100px;"/></a>            
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
    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-2 text-center">

        
         <?php   if ($caller['user_username1'] == NULL){?>
                
        
            <?php }else{?>
                <ul class="list-unstyled">
                    <li><strong>Called by</strong></li>
                    <li><h4><?php echo $caller['user_username1'];?></h4></li>
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
        <h4 class="modal-title" id="myModalLabel">Stars <?php echo $rws['war_enemy'];?> <?php echo $i;?></h4>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
          <div class="row">
			<div class="col-md-6">
            	 <div class="row">
                 <label for=""><?php echo $score['user_username'];?>`s attack plan</label>	
                 	<div class="col-md-12" style="padding-bottom:10;">
            			<a href="<?php echo $score['plan'];?>"><img src="<?php echo $score['plan'];?>" height="95" class="img-thumbnail"/></a>
                    </div>
                  </div>                
            </div>
            	 
			<div class="col-md-6"> 	
                     <?php if ($score['favattack']){?>
                     <label for=""><?php echo $score['user_username'];?>`s attack Style</label>	
                 	<div class="col-md-12">
            			 <img src="imagenes/troops/attacks/<?php echo $score['favattack'];?>.png" width="120" />
                    </div>
                  <?php }?>  
        	</div>
          </div>
        </div>        
        

      </div>
    </div>
  </div>
</div>
 <!--   popup -->                    
                   <?php if ($score['plan'] == 'userfiles/screenshoots/noplan.jpg'){?>
                   		<?php if ($caller['user_username1'] == $current_user){?>
                    <?php } }?>
           <?php }?>         
                    
                        <?php if ($caller['user_username1'] == $current_user){?>
                        <?PhP if($caller['user_username2'] == NULL){?>
                        	<div style="margin-top:20px; margin-bottom:-30px;">
                            </div>
                            <?php }?>
                        <?php }?>
                </ul>
            <?php  }?>   
              
    </div>
	<!-- end caller 1-->
    
    <!-- second call ----->
<!-- second call ----->
    <?PhP if($caller['user_username1']){?>
	<div class="col-xs-12 col-sm-6 col-md-3 col-lg-2 text-center">
		<?php  if ($caller['user_username2'] == NULL){
			if ($caller['user_username1'] !== $current_user){
			?>
        
        <?php } }else{?>
            <ul class="list-unstyled">
                <li><strong>Called by</strong></li>
                <li><h4><?php echo $caller['user_username2'];?></h4></li>
         <?php    
		 $user_score = $caller['user_username2']; // change for # of calls      
         $sql_score = "SELECT * FROM score WHERE war_enemy = '$caller_enemy' && enemy_enemynumber = '$war_enemynumber' && user_username ='$user_score' LIMIT 1";
        $result_score = mysqli_query($database,$sql_score) or die(mysqli_error($database));
        while($score = mysqli_fetch_array($result_score)){ 
          ?>  
                    <li><a href="#myModal2<?php echo $i;?>" data-toggle="modal"><img src="imagenes/th/<?php echo $score['score'];?>.png" width="80" /></a></li>
          <!-- popup -->

<div class="modal fade bs-example-modal-sm" id="myModal2<?php echo $i;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Stars <?php echo $rws['war_enemy'];?> <?php echo $i;?></h4>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
          <div class="row">
			<div class="col-md-6">
            	 <div class="row">
                 <label for=""><?php echo $score['user_username'];?>`s attack plan</label>	
                 	<div class="col-md-12" style="padding-bottom:10;">
            			<a href="<?php echo $score['plan'];?>"><img src="<?php echo $score['plan'];?>" height="95" class="img-thumbnail"/></a>
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

                   <input type="image" src="imagenes/th/0.png" width="120" />
                   <input type="hidden" name="stars" value="0"/>
                   <input type="hidden" name="war_enemy" value="<?php echo $rws['war_enemy'];?>"/>
                   <input type="hidden" name="user_username" value="<?php echo $user_score;?>"/>
                   <input type="hidden" name="enemy_enemynumber" value="<?php echo $i;?>"/>
                   <input type="hidden" name="war_detail" value="<?php echo $current_war;?>"/>
                   <input type="hidden" name="war_size" value="<?php echo $rws['war_size'];?>"/>                    

                   <input type="image" src="imagenes/th/1.png" width="120" />
                   <input type="hidden" name="stars" value="1"/>
                   <input type="hidden" name="war_enemy" value="<?php echo $rws['war_enemy'];?>"/>
                   <input type="hidden" name="user_username" value="<?php echo $user_score;?>"/>
                   <input type="hidden" name="enemy_enemynumber" value="<?php echo $i;?>"/>
                   <input type="hidden" name="war_detail" value="<?php echo $current_war;?>"/>
                   <input type="hidden" name="war_size" value="<?php echo $rws['war_size'];?>"/>                   

                   <input type="image" src="imagenes/th/2.png" width="120" />
                   <input type="hidden" name="stars" value="2"/>
                   <input type="hidden" name="war_enemy" value="<?php echo $rws['war_enemy'];?>"/>
                   <input type="hidden" name="user_username" value="<?php echo $user_score;?>"/>
                   <input type="hidden" name="enemy_enemynumber" value="<?php echo $i;?>"/>
                   <input type="hidden" name="war_detail" value="<?php echo $current_war;?>"/>
                   <input type="hidden" name="war_size" value="<?php echo $rws['war_size'];?>"/>                   

                   <input type="image" src="imagenes/th/3.png" width="120" />
                   <input type="hidden" name="stars" value="3"/>
                   <input type="hidden" name="war_enemy" value="<?php echo $rws['war_enemy'];?>"/>
                   <input type="hidden" name="user_username" value="<?php echo $user_score;?>"/>
                   <input type="hidden" name="enemy_enemynumber" value="<?php echo $i;?>"/>
                   <input type="hidden" name="war_detail" value="<?php echo $current_war;?>"/>
                   <input type="hidden" name="war_size" value="<?php echo $rws['war_size'];?>"/>                   
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
                   		<?php if ($caller['user_username2'] == $current_user){?>

                    <?php } }?>   
    <?php }?>            
                    <?php if ($caller['user_username2'] == $current_user){?>
                    	<?PhP if($caller['user_username3'] == NULL){?>

                        <?php }?>
                    <?php }?>
            </ul> 
        <?php  }?>   
	</div>
    <?php }?>
     <!---end second call ---> 
     <!---end second call ---> 
	<!-- third call ----->
<!-- second call ----->
    <?PhP if($caller['user_username2']){?>
	<div class="col-xs-12 col-sm-6 col-md-3 col-lg-2 text-center">
		<?php  if ($caller['user_username3'] == NULL){
			if ($caller['user_username2'] !== $current_user){
					if ($caller['user_username1'] !== $current_user){
			?>        


        <?php } } }else{?>
            <ul class="list-unstyled">
                <li><strong>Called by</strong></li>
                <li><h4><?php echo $caller['user_username3'];?></h4></li>
         <?php    
		 $user_score = $caller['user_username3']; // change for # of calls      
         $sql_score = "SELECT * FROM score WHERE war_enemy = '$caller_enemy' && enemy_enemynumber = '$war_enemynumber' && user_username ='$user_score' LIMIT 1";
        $result_score = mysqli_query($database,$sql_score) or die(mysqli_error($database));
        while($score = mysqli_fetch_array($result_score)){ 
          ?>  
                    <li><a href="#myModal3<?php echo $i;?>" data-toggle="modal"><img src="imagenes/th/<?php echo $score['score'];?>.png" width="80" /></a></li>
          <!-- popup -->

<div class="modal fade bs-example-modal-sm" id="myModal3<?php echo $i;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Stars <?php echo $rws['war_enemy'];?> <?php echo $i;?></h4>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
          <div class="row">
			<div class="col-md-6">
            	 <div class="row">
                 <label for=""><?php echo $score['user_username'];?>`s attack plan</label>	
                 	<div class="col-md-12" style="padding-bottom:10;">
            			<a href="<?php echo $score['plan'];?>"><img src="<?php echo $score['plan'];?>" height="95" class="img-thumbnail"/></a>
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
                   <input type="image" src="imagenes/th/0.png" width="120" />
                   <input type="image" src="imagenes/th/1.png" width="120" />
                   <input type="image" src="imagenes/th/2.png" width="120" />
                   <input type="image" src="imagenes/th/3.png" width="120" />

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
                   		<?php if ($caller['user_username3'] == $current_user){?>

                    <?php } }?>          
    <?php }?>            
                    <?php if ($caller['user_username3'] == $current_user){?>
                    	<?PhP if($caller['user_username4'] == NULL){?>

                        <?php }?>
                    <?php }?>
            </ul> 
        <?php  }?>   
	</div>
    <?php }?>
     <!---end second call --->    
     <!---end third call --->
	<!-- forth call ----->
<!-- second call ----->
    <?PhP if($caller['user_username3']){?>
	<div class="col-xs-12 col-sm-6 col-md-3 col-lg-2 text-center">
		<?php if ($caller['user_username4'] == NULL){
				if ($caller['user_username3'] !== $current_user){
					if ($caller['user_username2'] !== $current_user){
						if ($caller['user_username1'] !== $current_user){
			?>

        
        <?php } } } }else{?>
            <ul class="list-unstyled">
                <li><strong>Called by</strong></li>
                <li><h4><?php echo $caller['user_username4'];?></h4></li>
         <?php    
		 $user_score = $caller['user_username4']; // change for # of calls      
         $sql_score = "SELECT * FROM score WHERE war_enemy = '$caller_enemy' && enemy_enemynumber = '$war_enemynumber' && user_username ='$user_score' LIMIT 1";
        $result_score = mysqli_query($database,$sql_score) or die(mysqli_error($database));
        while($score = mysqli_fetch_array($result_score)){ 
          ?>  
                    <li><a href="#myModal4<?php echo $i;?>" data-toggle="modal"><img src="imagenes/th/<?php echo $score['score'];?>.png" width="80" /></a></li>
          <!-- popup -->

<div class="modal fade bs-example-modal-sm" id="myModal4<?php echo $i;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Stars <?php echo $rws['war_enemy'];?> <?php echo $i;?></h4>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
          <div class="row">
			<div class="col-md-6">
            	 <div class="row">
                 <label for=""><?php echo $score['user_username'];?>`s attack plan</label>	
                 	<div class="col-md-12" style="padding-bottom:10;">
            			<a href="<?php echo $score['plan'];?>"><img src="<?php echo $score['plan'];?>" height="95" class="img-thumbnail"/></a>
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

                   <input type="image" src="imagenes/th/0.png" width="120" />

                   <input type="image" src="imagenes/th/1.png" width="120" />
 
                   <input type="image" src="imagenes/th/2.png" width="120" />

                   <input type="image" src="imagenes/th/3.png" width="120" />

                </div>
        	</div>
          </div>
        </div>        
        

      </div>
    </div>
  </div>
</div>
 <!--   popup -->
          
    <?php }?>            

         
        <?php  }?>   
	</div>
    <?php }?>
     <!---end second call --->     
     <!---end forth call --->  
     
     
     
     
 <?php   }?> 

    </div>

</div>
	<?php $i++;};?>                 
        
  			<?php }?>
               
</div> 

