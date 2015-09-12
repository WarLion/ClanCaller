<?php include 'components/authentication.php' ?> 
<?php include 'components/session-check.php' ?>
<?php include 'controllers/base/head.php' ?>
<?php include 'controllers/navigation/first-navigation.php' ?> 
<?php include 'controllers/base/style.php' ?>
<?php
	include '_database/database.php';
	$sql = "SELECT * FROM war_table LIMIT 1";
	$result = mysqli_query($database,$sql) or die(mysqli_error($database));
	while($rws = mysqli_fetch_array($result)){	 
?> 

<div class="container">		
    <h1 class="text-center profile-name" style="margin-top:35;"><?php echo $clananame;?><small><br />Statistics</small></h1><br />	
    <div class="text-right"><a href="javascript:history.go(-1)" class="btn btn-success" onMouseOver="self.status=document.referrer;return true">back</a> </div>	
<!-- start statistic page -->
<div class="col-md-12 panel">


<div class="col-md-12" style=" padding-top:20;">
    <label>Attack Styles</label>
    <hr />
<div class="col-md-3"  style="padding:20;">
    <label>3 stars</label>
    <?php
	function porcent_attack($troop, $string_troop){
		include '_database/database.php';
    $sql = "SELECT favattack, count(*) as 'Cnt' FROM score WHERE favattack='$troop' GROUP BY favattack";
    $result = mysqli_query($database,$sql) or die(mysqli_error($database));
    while($rws = mysqli_fetch_array($result)){  
    $sql2 = "SELECT favattack, count(*) as 'Cnt2' FROM score WHERE favattack='$troop' AND Score=3 GROUP BY favattack";
    $result2 = mysqli_query($database,$sql2) or die(mysqli_error($database));
    while($rws2 = mysqli_fetch_array($result2)){
		$x = $rws['Cnt'];
		$y = $rws2['Cnt2'];
		$porcent = ($y * 100) / $x;
		?> 
      <div style="border:solid #999 1px;; padding:3px;">     	  
    <strong><?php echo $string_troop;?></strong> <span class="badge" style="background-color:#090;"><?php echo $porcent;?> %</span></a><br /> 
    <?php echo $rws['Cnt'];?> - Attacks, <?php echo $rws2['Cnt2'];?> - 3 <span class="fa fa-star"></span><span class="fa fa-star"></span><span class="fa fa-star"></span><br />
	</div>
    
    <?php } } }?>   
    <?php porcent_attack('goho','Goho');?>
    <?php porcent_attack('gohoc','Goho Sha');?>
    <?php porcent_attack('golalo','Golalon');?>
    <?php porcent_attack('gowipe','Gowipe');?> 
    <?php porcent_attack('gowiwi','Gowiwi');?>
    <?php porcent_attack('lalonion','Lalonion');?>
    <?php porcent_attack('dragons','Dragons');?>
    <?php porcent_attack('other','Others');?>
</div>
<div class="col-md-3"  style="padding:20;">
    <label>2 star</label>
    <?php
	function porcent_attack4($troop, $string_troop){
	include '_database/database.php';
    $sql3 = "SELECT favattack, count(*) as 'Cnt3' FROM score WHERE favattack='$troop' GROUP BY favattack";
    $result3 = mysqli_query($database,$sql3) or die(mysqli_error($database));
    while($rws3 = mysqli_fetch_array($result3)){  
    $sql4 = "SELECT favattack, count(*) as 'Cnt4' FROM score WHERE favattack='$troop' AND Score =2 GROUP BY favattack";
    $result4 = mysqli_query($database,$sql4) or die(mysqli_error($database));
    while($rws4 = mysqli_fetch_array($result4)){
		$x2 = $rws3['Cnt3'];
		$y2 = $rws4['Cnt4'];
		$porcent = ($y2 * 100) / $x2;
		?> 
      <div style="border:solid #999 1px;; padding:3px;">     	  
    <strong><?php echo $string_troop;?></strong> <span class="badge" style="background-color:#A9C120;">-<?php echo $porcent;?> %</span></a><br /> 
    <?php echo $rws3['Cnt3'];?> - Attacks, <?php echo $rws4['Cnt4'];?> - 2 <span class="fa fa-star"></span><span class="fa fa-star"></span><br />
	</div>
    
    <?php } } }?>   
    <?php porcent_attack4('goho','Goho');?>
    <?php porcent_attack4('gohoc','Goho Sha');?>
    <?php porcent_attack4('golalo','Golalon');?>
    <?php porcent_attack4('gowipe','Gowipe');?> 
    <?php porcent_attack4('gowiwi','Gowiwi');?>
    <?php porcent_attack4('lalonion','Lalonion');?>
    <?php porcent_attack4('dragons','Dragons');?>
    <?php porcent_attack4('other','Others');?>    
</div>  

<div class="col-md-3"  style="padding:20;">
    <label>1 star</label>
    <?php
	function porcent_attack3($troop, $string_troop){
	include '_database/database.php';
    $sql3 = "SELECT favattack, count(*) as 'Cnt3' FROM score WHERE favattack='$troop' GROUP BY favattack";
    $result3 = mysqli_query($database,$sql3) or die(mysqli_error($database));
    while($rws3 = mysqli_fetch_array($result3)){  
    $sql4 = "SELECT favattack, count(*) as 'Cnt4' FROM score WHERE favattack='$troop' AND Score =1 GROUP BY favattack";
    $result4 = mysqli_query($database,$sql4) or die(mysqli_error($database));
    while($rws4 = mysqli_fetch_array($result4)){
		$x2 = $rws3['Cnt3'];
		$y2 = $rws4['Cnt4'];
		$porcent = ($y2 * 100) / $x2;
		?> 
      <div style="border:solid #999 1px;; padding:3px;">     	  
    <strong><?php echo $string_troop;?></strong> <span class="badge" style="background-color:orange;">-<?php echo $porcent;?> %</span></a><br /> 
    <?php echo $rws3['Cnt3'];?> - Attacks, <?php echo $rws4['Cnt4'];?> - 1 <span class="fa fa-star"></span><br />
	</div>
    
    <?php } } }?>   
    <?php porcent_attack3('goho','Goho');?>
    <?php porcent_attack3('gohoc','Goho Sha');?>
    <?php porcent_attack3('golalo','Golalon');?>
    <?php porcent_attack3('gowipe','Gowipe');?> 
    <?php porcent_attack3('gowiwi','Gowiwi');?>
    <?php porcent_attack3('lalonion','Lalonion');?>
    <?php porcent_attack3('dragons','Dragons');?>
    <?php porcent_attack3('other','Others');?>    
</div>   
<div class="col-md-3"  style="padding:20;">
    <label>Fails</label>
    <?php
	function porcent_attack2($troop, $string_troop){
	include '_database/database.php';
    $sql3 = "SELECT favattack, count(*) as 'Cnt3' FROM score WHERE favattack='$troop' GROUP BY favattack";
    $result3 = mysqli_query($database,$sql3) or die(mysqli_error($database));
    while($rws3 = mysqli_fetch_array($result3)){  
    $sql4 = "SELECT favattack, count(*) as 'Cnt4' FROM score WHERE favattack='$troop' AND Score =0 GROUP BY favattack";
    $result4 = mysqli_query($database,$sql4) or die(mysqli_error($database));
    while($rws4 = mysqli_fetch_array($result4)){
		$x2 = $rws3['Cnt3'];
		$y2 = $rws4['Cnt4'];
		$porcent = ($y2 * 100) / $x2;
		?> 
      <div style="border:solid #999 1px;; padding:3px;">     	  
    <strong><?php echo $string_troop;?></strong> <span class="badge" style="background-color:red;">-<?php echo $porcent;?> %</span></a><br /> 
    <?php echo $rws3['Cnt3'];?> - Attacks, <?php echo $rws4['Cnt4'];?> - Fail<br />
	</div>
    
    <?php } } }?>   
    <?php porcent_attack2('goho','Goho');?>
    <?php porcent_attack2('gohoc','Goho Sha');?>
    <?php porcent_attack2('golalo','Golalon');?>
    <?php porcent_attack2('gowipe','Gowipe');?> 
    <?php porcent_attack2('gowiwi','Gowiwi');?>
    <?php porcent_attack2('lalonion','Lalonion');?>
    <?php porcent_attack2('dragons','Dragons');?>
    <?php porcent_attack2('other','Others');?>    
</div> 
<div class="row"></div>
    <label>Members Porcentage</label>
    <hr />
<div class="col-md-3"  style="padding:20;">
    <label>3 Stars</label>
<?php
    $members_sql = "SELECT user_username, count(*) as 'memcount' FROM score GROUP BY user_username ORDER BY memcount ASC";
    $result_members = mysqli_query($database,$members_sql) or die(mysqli_error($database));
    while($mem = mysqli_fetch_array($result_members)){ 
	 $member = $mem['user_username']; 
    $members_sql2 = "SELECT user_username, count(*) as 'memcount2' FROM score WHERE user_username='$member' AND Score = 3 GROUP BY user_username ";
    $result_members2 = mysqli_query($database,$members_sql2) or die(mysqli_error($database));
    while($mem2 = mysqli_fetch_array($result_members2)){
		$a = $mem['memcount'];
		$b = $mem2['memcount2'];
		$porcent_mem = ($b * 100) / $a;
		?> 
      <div style="border:solid #999 1px;; padding:3px;">     	  
   <a href="profile.php?user_username=<?php echo $mem['user_username'];?>" class="list-group-item"> <strong><?php echo $mem['user_username'];?></strong> <span class="badge" style="background-color:#090;"><?php echo $porcent_mem;?> %</span><br /> 
    <?php echo $mem['memcount'];?> - Attacks, <?php echo $mem2['memcount2'];?> - 3 <span class="fa fa-star"></span><span class="fa fa-star"></span><span class="fa fa-star"></span><br /></a>
	</div>
    
    <?php } }?>       
</div> 
<div class="col-md-3"  style="padding:20;">
    <label>2 stars</label>
<?php
    $members_sql = "SELECT user_username, count(*) as 'memcount' FROM score GROUP BY user_username ORDER BY memcount ASC";
    $result_members = mysqli_query($database,$members_sql) or die(mysqli_error($database));
    while($mem = mysqli_fetch_array($result_members)){ 
	 $member = $mem['user_username']; 
    $members_sql2 = "SELECT user_username, count(*) as 'memcount2' FROM score WHERE user_username='$member' AND Score = 2 GROUP BY user_username";
    $result_members2 = mysqli_query($database,$members_sql2) or die(mysqli_error($database));
    while($mem2 = mysqli_fetch_array($result_members2)){
		$a = $mem['memcount'];
		$b = $mem2['memcount2'];
		$porcent_mem = ($b * 100) / $a;
		?> 
      <div style="border:solid #999 1px;; padding:3px;">     	  
    <a href="profile.php?user_username=<?php echo $mem['user_username'];?>" class="list-group-item"><strong><?php echo $mem['user_username'];?></strong> <span class="badge" style="background-color:#A9C120;"><?php echo $porcent_mem;?> %</span><br /> 
    <?php echo $mem['memcount'];?> - Attacks, <?php echo $mem2['memcount2'];?> - 2 <span class="fa fa-star"></span><span class="fa fa-star"></span></span><br /></a>
	</div>
    
    <?php } }?>       
</div> 
<div class="col-md-3"  style="padding:20;">
    <label>1 Star</label>
<?php
    $members_sql = "SELECT user_username, count(*) as 'memcount' FROM score GROUP BY user_username ORDER BY memcount ASC";
    $result_members = mysqli_query($database,$members_sql) or die(mysqli_error($database));
    while($mem = mysqli_fetch_array($result_members)){ 
	 $member = $mem['user_username']; 
    $members_sql2 = "SELECT user_username, count(*) as 'memcount2' FROM score WHERE user_username='$member' AND Score = 1 GROUP BY user_username";
    $result_members2 = mysqli_query($database,$members_sql2) or die(mysqli_error($database));
    while($mem2 = mysqli_fetch_array($result_members2)){
		$a = $mem['memcount'];
		$b = $mem2['memcount2'];
		$porcent_mem = ($b * 100) / $a;
		?> 
      <div style="border:solid #999 1px;; padding:3px;">     	  
    <a href="profile.php?user_username=<?php echo $mem['user_username'];?>" class="list-group-item"><strong><?php echo $mem['user_username'];?></strong> <span class="badge" style="background-color:orange;"><?php echo $porcent_mem;?> %</span><br /> 
    <?php echo $mem['memcount'];?> - Attacks, <?php echo $mem2['memcount2'];?> - 1 <span class="fa fa-star"></span></span><br /></a>
	</div>
    
    <?php } }?>       
</div> 
<div class="col-md-3"  style="padding:20;">
    <label>Fails</label>
<?php
    $members_sql = "SELECT user_username, count(*) as 'memcount' FROM score GROUP BY user_username ORDER BY memcount ASC";
    $result_members = mysqli_query($database,$members_sql) or die(mysqli_error($database));
    while($mem = mysqli_fetch_array($result_members)){ 
	 $member = $mem['user_username']; 
    $members_sql2 = "SELECT user_username, count(*) as 'memcount2' FROM score WHERE user_username='$member' AND Score = 0 GROUP BY user_username";
    $result_members2 = mysqli_query($database,$members_sql2) or die(mysqli_error($database));
    while($mem2 = mysqli_fetch_array($result_members2)){
		$a = $mem['memcount'];
		$b = $mem2['memcount2'];
		$porcent_mem = ($b * 100) / $a;
		?> 
      <div style="border:solid #999 1px;; padding:3px;">     	  
   <a href="profile.php?user_username=<?php echo $mem['user_username'];?>" class="list-group-item"> <strong><?php echo $mem['user_username'];?></strong> <span class="badge" style="background-color:red;"><?php echo $porcent_mem;?> %</span><br /> 
    <?php echo $mem['memcount'];?> - Attacks, <?php echo $mem2['memcount2'];?> - Fail</span><br /></a>
	</div>
    
    <?php } }?>       
</div> 

</div>

</div>
<!-- end statistic page-->
</div> 
<?php }?>