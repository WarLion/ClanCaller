<?php include 'components/authentication.php' ?> 
<?php include 'components/session-check.php' ?>
<?php include 'controllers/base/head.php' ?>
<?php include 'controllers/navigation/first-navigation.php' ?> 
   <div class="container">				
				<h2 class="text-center profile-text profile-name">Top Hitters of the Month</h2>
                
 <?php
$month = 9;
$year = 2015;
	 $sql = "SELECT log_username, SUM(log_score) FROM war_log WHERE log_status='score' && YEAR(log_end_time) = '$year' AND MONTH(log_end_time) = '$month' GROUP BY log_username ORDER BY SUM(log_score) DESC";
    $result = mysqli_query($database,$sql) or die(mysqli_error($database));
	if( mysqli_num_rows($result) > 0) {?>
<div class="col-md-4">
<div class="panel panel-primary" style="border-radius: 19px;">
        <div class="panel-heading text-center "  style=" border-radius: 19px 19px 0px 0px;">Top 10 Hitters Sep</div>
		 <div class="panel-body">
  <!-- Table -->
  <table class="table">
<?php 
$i=1;
while($rws = mysqli_fetch_array($result)){
	$num = $i++;
if ($current_user == $rws['log_username']){
	$color = 'style="background-color:#e8e7e7;"';
}else{
	$color ='';
}
	?>
    
    <tr <?php echo $color;?>>
    	<td><?php echo $num;?></td>
        <td><?php if($num==1){?><img src="imagenes/trophy.png" height="30" /><?php }elseif($num==2){?><img src="imagenes/trophy2.png" height="30" /> <?php }elseif($num==3){?><img src="imagenes/trophy3.png" height="30" /> <?php }?> <a href="profile.php?user_username=<?php echo $rws['log_username'];?>" style="font-weight:bold;"><?php echo $rws['log_username'];?></a></td>
        <td ><?php echo $rws['SUM(log_score)'];?> <i class="fa fa-star"></i></td>
    </tr>
    <?php }?>  
  </table>
  		</div>
</div>
</div>
<?php }?>           
<!------------------------------------------------>
<?php
$month = 10;
$year = 2015;
	 $sql = "SELECT log_username, SUM(log_score) FROM war_log WHERE log_status='score' && YEAR(log_end_time) = '$year' AND MONTH(log_end_time) = '$month' GROUP BY log_username ORDER BY SUM(log_score) DESC";
    $result = mysqli_query($database,$sql) or die(mysqli_error($database));
	if( mysqli_num_rows($result) > 0) {?>
<div class="col-md-4">
<div class="panel panel-primary" style="border-radius: 19px;">
        <div class="panel-heading text-center "  style="border-radius: 19px 19px 0px 0px;">Top 10 Hitters Oct</div>
		 <div class="panel-body">
  <!-- Table -->
  <table class="table">
<?php 
$i=1;
while($rws = mysqli_fetch_array($result)){
	$num = $i++;
if ($current_user == $rws['log_username']){
	$color = 'style="background-color:#e8e7e7;"';
}else{
	$color ='';
}	
	?>
    <tr <?php echo $color;?>>
    	<td><?php echo $num;?></td>
        <td><?php if($num==1){?><img src="imagenes/trophy.png" height="30" /><?php }elseif($num==2){?><img src="imagenes/trophy2.png" height="30" /> <?php }elseif($num==3){?><img src="imagenes/trophy3.png" height="30" /> <?php }?> <a href="profile.php?user_username=<?php echo $rws['log_username'];?>" style="font-weight:bold;"><?php echo $rws['log_username'];?></a></td>
        <td ><?php echo $rws['SUM(log_score)'];?> <i class="fa fa-star"></i></td>
    </tr>
    <?php }?>  
  </table>
  		</div>
</div>
</div>
<?php }?>           
<!------------------------------------------------>
<?php
$month = 11;
$year = 2015;
	 $sql = "SELECT log_username, SUM(log_score) FROM war_log WHERE log_status='score' && YEAR(log_end_time) = '$year' AND MONTH(log_end_time) = '$month' GROUP BY log_username ORDER BY SUM(log_score) DESC";
    $result = mysqli_query($database,$sql) or die(mysqli_error($database));
	if( mysqli_num_rows($result) > 0) {?>
<div class="col-md-4">
<div class="panel panel-primary" style="border-radius: 19px;">
        <div class="panel-heading text-center "  style="border-radius: 19px 19px 0px 0px;">Top 10 Hitters Nov</div>
		 <div class="panel-body">
  <!-- Table -->
  <table class="table">
<?php 
$i=1;
while($rws = mysqli_fetch_array($result)){
	$num = $i++;
if ($current_user == $rws['log_username']){
	$color = 'style="background-color:#e8e7e7;"';
}else{
	$color ='';
}	
	?>
    <tr <?php echo $color;?>>
    	<td><?php echo $num;?></td>
        <td><?php if($num==1){?><img src="imagenes/trophy.png" height="30" /><?php }elseif($num==2){?><img src="imagenes/trophy2.png" height="30" /> <?php }elseif($num==3){?><img src="imagenes/trophy3.png" height="30" /> <?php }?> <a href="profile.php?user_username=<?php echo $rws['log_username'];?>" style="font-weight:bold;"><?php echo $rws['log_username'];?></a></td>
        <td ><?php echo $rws['SUM(log_score)'];?> <i class="fa fa-star"></i></td>
    </tr>
    <?php }?>  
  </table>
  		</div>
</div>
</div>
<?php }?>           
           
</div> 

