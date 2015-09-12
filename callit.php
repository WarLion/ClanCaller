<?php include 'components/authentication.php' ?>     
<?php include 'components/session-check.php' ?>
<?php include 'controllers/base/head.php' ?>
<?php include 'controllers/base/style.php' ?>
<?php include 'controllers/navigation/first-navigation.php' ?>   
<?php
 $enemy_number = $_GET['e'];
 $enemy_attack = $_GET['a'];
                    include '_database/database.php';
                    $sql = "SELECT * FROM war_table ORDER BY war_warid DESC LIMIT 1";
                    $result = mysqli_query($database,$sql) or die(mysqli_error($database));
                    while($rws = mysqli_fetch_array($result)){  
						$caller_enemy = $rws['war_enemy'];
						$sql_caller_th = "SELECT * FROM caller WHERE war_enemy = '$caller_enemy' && war_enemynumber = '$enemy_number'";
						$result_caller_th = mysqli_query($database,$sql_caller_th) or die(mysqli_error($database));
						while($caller_th = mysqli_fetch_array($result_caller_th)){  
							$sql_maxscore = "SELECT MAX(score) FROM score WHERE war_enemy = '$caller_enemy' && enemy_enemynumber = '$enemy_number'";
							$result_maxscore = mysqli_query($database,$sql_maxscore) or die(mysqli_error($database));
							while($maxscore = mysqli_fetch_array($result_maxscore)){ 						     
									
					?> 

<form action="components/callfirst.php?enemy=<?php echo $enemy_number;?>&war_details=<?php echo $rws['war_warid'];?>&war_size=<?php echo $rws['war_size'];?>" method="post" enctype="multipart/form-data" id="UploadForm">
<input type="hidden" name="war_enemy" value="<?php echo $rws['war_enemy'];?>"/>
<input type="hidden" name="call_th" value="<?php echo $caller_th['call_th'];?>"/>
<div class="container" style="padding-top:50px;">
    <h1 class="text-center profile-name" style="margin-top:35;">First Call Enemy <?php echo $enemy_number;?> <br /><small> <?php echo $rws['war_enemy'];?> </small></h1>
    <div class="col-md-12 panel" style="border-radius: 20px; margin-top:20px; margin-bottom:20px; padding-bottom:20px; padding-top:20px;"> 
    <div class="col-md-12 text-right"> <img src="imagenes/close.png" width="20" height="20" onclick="goBack()" style="cursor:pointer;"/><script>function goBack() {window.history.back();}</script></div> 
        <div class="col-md-12">
            <div class="col-md-6 text-center">
		<?php if ($caller_th['call_th'] !== 'noselect'){?>            
                    <label for="">Enemy TownHall Lv <?php echo strtoupper($caller_th['call_th']);?></label>
            <img  class="img-responsive text-center" src="imagenes/th/<?php echo $caller_th['call_th'];?><?php echo $maxscore['MAX(score)'];?>.png" width="100" height="100" style="position: relative; top: 0; left: 25;"/>
			<?php if ($maxscore['MAX(score)'] >= 0){?>
            <img class="img-responsive  text-center" src="imagenes/th/star<?php echo $maxscore['MAX(score)'];?>.png" width="100" style="position: absolute; top: 30px; left: 40px;"/>
         <?php } }else{?>  
 <div class="form-group float-label-control">
                    <label for="">Enemy TownHall Lv</label>
                    <div class="cc-selector-2">
                   		 <input type="hidden" name="call_th" value="noselect"/>
                        <input id="th7" type="radio" name="call_th" value="th7" style="display:none" />
                        <label class="favattack-cc th7" for="th7"></label>
                        <input id="th8" type="radio" name="call_th" value="th8" style="display:none" />
                        <label class="favattack-cc th8" for="th8"></label>
                        <input id="th9" type="radio" name="call_th" value="th9" style="display:none" />
                        <label class="favattack-cc th9"for="th9"></label>
                        <input id="th10" type="radio" name="call_th" value="th10"  style="display:none"/>
                        <label class="favattack-cc th10"for="th10"></label>   
                     </div>
             	</div>                     
         <?php }?>                
            </div>
            <div class="col-md-6">
            	<div class="col-md-6">             
                <?php 
				$war_enemy = $rws['war_enemy'];
                    $sql2 = "SELECT * FROM caller WHERE war_enemy = '$war_enemy' && war_enemynumber = '$enemy_number'";
                    $result2 = mysqli_query($database,$sql2) or die(mysqli_error($database));
                    while($rws2 = mysqli_fetch_array($result2)){
						?>	
                        <label>Current Base </label>			
                <img src="userfiles/screenshoots/<?php echo $rws2['call_base'];?>" class="img-responsive center-block">
                <input class="form-control" type="hidden" name="screenshoot" value="<?php echo $rws2['call_base'];?>"/>
                </div>
                
               
                <div class="col-md-6"> 
                <div class="form-group float-label-control">
<?php if($rws2['call_base'] == 'noscreen.jpg'){;?>                
<div class="form-group float-label-control">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<label data-toggle="tooltip" title="Here you can upload a screenshot of the enemy base!">Base screenshoot <span class="badge"><span class="fa fa-info"></span></span></label>

<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
});
</script>
    <input name="ImageFile" type="file" id="uploadFile"/>
    
    <div class="col-md-6">
        <div class="shortpreview" id="uploadImagePreview">
             <div id="imagePreview"></div>
        </div>
    </div>
</div>   
<?php }?> 
 <?php }?>            	</div>   
                </div>
               
                               
            </div>
            <div class="row">
            	<div class="col-md-12">
                    <div class="form-group float-label-control">
                        <label for="">Your Attack</label>
                            <div class="cc-selector-2">
                                <input id="goho" type="radio" name="user_favattack" value="goho" style="display:none" />
                                <label class="favattack-cc goho" for="goho"></label>
                                <input id="gohoc" type="radio" name="user_favattack" value="gohoc" style="display:none" />
                                <label class="favattack-cc gohoc"for="gohoc"></label>
                                <input id="lalo" type="radio" name="user_favattack" value="golalo"  style="display:none"/>
                                <label class="favattack-cc lalo"for="lalo"></label>
                                <input id="gowipe" type="radio" name="user_favattack" value="gowipe" style="display:none" />
                                <label class="favattack-cc gowipe" for="gowipe"></label>
                                <input id="gowiwi" type="radio" name="user_favattack" value="gowiwi" style="display:none" />
                                <label class="favattack-cc gowiwi"for="gowiwi"></label>
                                <input id="lalonion" type="radio" name="user_favattack" value="lalonion"  style="display:none"/>
                                <label class="favattack-cc lalonion" for="lalonion"></label>  
                                <input id="dragons" type="radio" name="user_favattack" value="dragons"  style="display:none"/>
                                <label class="favattack-cc dragons" for="dragons"></label>   
                                <input id="other" type="radio" name="user_favattack" value="other"  style="display:none"/>
                                <label class="favattack-cc other" for="other"></label>                                                                        
                            </div>             
                    </div>
               </div>                 	
            </div>      
        </div>
    <div class="row">
     <?php
	$sql_user2 = "SELECT * FROM user WHERE user_username='$current_user'";
	$result_user2 = mysqli_query($database,$sql_user2) or die(mysqli_error($database));
	while($user2 = mysqli_fetch_array($result_user2)){ 	 
	  if ($user2['user_title'] >= 3){?>
    <input type="hidden" name="user_call" value="user_username<?php echo $enemy_attack;?>"/>
    <label class="col-sm-2 col-xs-4 control-label">Call it as</label>
        <div class="col-sm-4 col-xs-6">
            <select class="form-control" name="user_callit">
                <option value="<?php echo $_SESSION['user_username'];?>"><?php echo $_SESSION['user_username'];?></option>
                <option value="Other">Other</option>
                <?php $sql_user = "SELECT * FROM user ORDER BY user_username ASC";
                $result_user = mysqli_query($database,$sql_user) or die(mysqli_error($database));
                while($user = mysqli_fetch_array($result_user)){ ?>   
                <option value="<?php echo $user['user_username'];?>"><?php echo $user['user_username'];?></option>
                <?php }?>
            </select>      
        </div>
        <?php }else{?>
		 <input type="hidden" name="user_call" value="user_username<?php echo $enemy_attack;?>"/>
         <input type="hidden" name="user_callit" value="<?php echo $_SESSION['user_username'];?>"/>        
        <?php } }?> 
	</div>   
        <div class="col-md-12 text-right">
            <button class="btn btn-primary ladda-button" data-style="zoom-in" type="submit"  id="SubmitButton" value="Upload" />Make the Call</button>
        </div>          
    </div>
</div>
</form>
<?php } } }?>