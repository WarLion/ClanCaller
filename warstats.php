<?php include 'components/authentication.php' ?> 
<?php include 'components/session-check.php' ?>
<?php include 'controllers/base/head.php' ?>
<?php include 'controllers/navigation/first-navigation.php' ?> 
<?php include 'controllers/base/style.php' ?>
<?php
	include '_database/database.php';
	$current_war = $_GET['warid'];
	$sql = "SELECT * FROM war_table WHERE war_warid='$current_war'";
	$result = mysqli_query($database,$sql) or die(mysqli_error($database));
	while($rws = mysqli_fetch_array($result)){
	 $enemyname = $rws['war_enemy'];	
	  $sql_user = "SELECT * FROM user WHERE user_username='$current_user'";
	$result_user = mysqli_query($database,$sql_user) or die(mysqli_error($database));
	while($user = mysqli_fetch_array($result_user)){
?> 

<div class="container">		
    <h1 class="text-center profile-name" style="margin-top:35;">Statistics <small><br /><?php echo $enemyname;?></small></h1><br />	
    <div class="text-right"><a href="javascript:history.go(-1)" class="btn btn-success" onMouseOver="self.status=document.referrer;return true">back</a> </div>	
<!-- start statistic page -->
<div class="col-md-12 panel" style="padding-bottom:20;">

<div class="col-md-8">
	<div class="col-md-6 col-sm-6 col-xs-12" style="padding:20;">
    <label>Most used attack</label>
    <hr />
    <?php
    $sql = "SELECT favattack, count(*) as 'Cnt' FROM score WHERE war_enemy='$enemyname' GROUP BY favattack ORDER BY 2 DESC LIMIT 2";
    $result = mysqli_query($database,$sql) or die(mysqli_error($database));
    while($rws = mysqli_fetch_array($result)){?>    
    <div class="col-xs-6 col-sm-6 col-md-6 text-center">
        <div class="imageAndText">
            <img src="imagenes/troops/attacks/<?php if ($rws['favattack']){echo $rws['favattack'];}else{ echo 'none';}?>.png" class="align-center img-responsive">
            <div class="col">
                <div class="col-md-6">
                    <p><span class="badge" style="background-color:#F90;"><?php echo $rws['Cnt'];?></span></p>
                </div>
            </div>
        </div>
    
	</div>
    <?php  }?> 
    </div>   
<div class="col-md-6 col-sm-6 col-xs-12" style="padding:20;">
    <label>Least used attack</label>
    <hr />
    <?php
    $sql = "SELECT favattack, count(*) as 'Cnt' FROM score WHERE war_enemy='$enemyname' GROUP BY favattack ORDER BY 2 ASC LIMIT 2";
    $result = mysqli_query($database,$sql) or die(mysqli_error($database));
    while($rws = mysqli_fetch_array($result)){?>
    
    <div class="col-xs-6 col-sm-6 col-md-6 text-center">
        <div class="imageAndText">
            <img src="imagenes/troops/attacks/<?php if ($rws['favattack']){echo $rws['favattack'];}else{ echo 'none';}?>.png" class="align-center img-responsive">
            <div class="col">
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <p><span class="badge" style="background-color:#F90;"><?php echo $rws['Cnt'];?></span></p>
                </div>
            </div>
        </div>
    

    </div>
    <?php  }?>    
</div> 
<div class="row">
<div class="col-md-6 col-sm-6 col-xs-12" style="padding:20;">
    <label>Most Successful attack</label>
    <hr />
    <?php
     $sql = "SELECT favattack, count(*) as 'Cnt' FROM score WHERE score = 3 AND war_enemy='$enemyname' GROUP BY favattack ORDER BY 2 DESC LIMIT 2";
    $result = mysqli_query($database,$sql) or die(mysqli_error($database));
    while($rws = mysqli_fetch_array($result)){?>    
    <div class="col-xs-6 col-sm-6 col-md-6 text-center">
        <div class="imageAndText">
            <img src="imagenes/troops/attacks/<?php if ($rws['favattack']){echo $rws['favattack'];}else{ echo 'none';}?>.png" class="align-center img-responsive">
            <div class="col">
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <p><span class="badge" style="background-color:#F90;"><?php echo $rws['Cnt'];?></span></p>
                </div>
            </div>
        </div>
    
	</div>
    <?php  }?>    
</div>
<div class="col-md-6 col-sm-6 col-xs-12" style="padding:20;">
    <label>Least Successful attack</label>
    <hr />
    <?php
 $sql = "SELECT favattack, count(*) as 'Cnt' FROM score WHERE score = 0 AND war_enemy='$enemyname' GROUP BY favattack ORDER BY 2 DESC LIMIT 2";
    $result = mysqli_query($database,$sql) or die(mysqli_error($database));
    while($rws = mysqli_fetch_array($result)){?>    
    <div class="col-xs-6 col-sm-6 col-md-6 text-center">
        <div class="imageAndText">
            <img src="imagenes/troops/attacks/<?php if ($rws['favattack']){echo $rws['favattack'];}else{ echo 'none';}?>.png" class="align-center img-responsive">
            <div class="col">
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <p><span class="badge" style="background-color:#F90;"><?php echo $rws['Cnt'];?></span></p>
                </div>
            </div>
        </div>
    
	</div>
    <?php  }?>    
</div>  
</div> <!--row--> 
<div class="row">
   	<div class="col-md-12 text-center">
    <label>Harder Enemy Base</label>
    <hr />
    <div class="col-md-5">
<?php  $sql = "SELECT enemy_enemynumber, count(*) as 'Cnt' FROM score WHERE war_enemy='$enemyname' GROUP BY enemy_enemynumber ORDER BY 2 ASC";
    $result = mysqli_query($database,$sql) or die(mysqli_error($database));
    
		$rows = array();
		$flag = true;
		$table = array();
		$table['cols'] = array(
		array('label' => 'enemy', 'type' => 'string'),
		array('label' => 'attacks', 'type' => 'number')
		);
		 foreach($result as $r) {

		$temp = array();
		$temp[] = array('v' => (string) $r['enemy_enemynumber']); 
		$temp[] = array('v' => (int) $r['Cnt']); 
		$rows[] = array('c' => $temp);
}

$table['rows'] = $rows;
$jsonTable = json_encode($table);
  ?>  
  
  
  <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load('visualization', '1', {packages: ['corechart', 'bar']});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
       var data = new google.visualization.DataTable(<?php echo $jsonTable; ?>);

    var options = {
            title: 'Harder Enemy Base',
        hAxis: {
          title: 'Enemy',
        },
        vAxis: {
          title: 'Attacks'
        }
      };

      var chart = new google.visualization.ColumnChart(
        document.getElementById('chart_div'));

      chart.draw(data, options);
      }
    </script>

<div id="chart_div" class="align-center"></div>


    </div>
             
  <div class="col-md-4 col-md-offset-3">
<?php 
	$sql = "SELECT enemy_enemynumber, count(*) as 'Cnt' FROM score WHERE war_enemy='$enemyname' GROUP BY enemy_enemynumber ORDER BY 1 ASC";
    $result = mysqli_query($database,$sql) or die(mysqli_error($database));
	while($rws = mysqli_fetch_array($result)){
	 $enemynumber = $rws['enemy_enemynumber'];	
	$sql = "SELECT call_base FROM caller WHERE war_enemynumber='$enemynumber' AND war_enemy = '$enemyname' ORDER BY war_enemynumber ASC";
    $result = mysqli_query($database,$sql) or die(mysqli_error($database));
    while($rws = mysqli_fetch_array($result)){?> 
    <strong>Enemy - <?php echo $r['enemy_enemynumber']?> Base</strong> <br />  
<a href="userfiles/screenshoots/<?Php echo $rws['call_base'];?>"><img src="userfiles/screenshoots/<?Php echo $rws['call_base'];?>" class="img-thumbnail" alt="Enemy-<?php echo $r['enemy_enemynumber']?>"/></a>

<?php  }}?>
    </div>   

    </div>


</div><!--row-->   
</div><!-- col izq-->
	<div class="col-md-4"><!-- col der-->
    <div class="row">
    <div class="col-md-12" style="padding-top:30px;">
<a class="btn btn-default btn-lg btn-block" role="button" data-toggle="collapse" href="#Hitters" aria-expanded="false" aria-controls="collapseExample">Top 5 Hitters</a>
<div class="collapse" id="Hitters">
  <div class="well">    
    <div class="list-group">
    <?php
    $sql = "SELECT user_username, SUM(score) FROM score WHERE war_enemy='$enemyname' GROUP BY user_username ORDER BY SUM(score) DESC LIMIT 5";
    $result = mysqli_query($database,$sql) or die(mysqli_error($database));
    while($rws = mysqli_fetch_array($result)){?>
<a href="profile.php?user_username=<?php echo $rws['user_username'];?>" class="list-group-item"><strong><?php echo $rws['user_username'];?> </strong><span class="badge" style="background-color:green;"><?php echo $rws['SUM(score)'];?><span class="fa fa-star"></span></span></a>
<?php  }?>
</div>
</div>
</div>
</div>
</div>
 <div class="row">
    <div class="col-md-12">
<a class="btn btn-default btn-lg btn-block" role="button" data-toggle="collapse" href="#Cleaners" aria-expanded="false" aria-controls="collapseExample">Cleaners 1st call</a>
<div class="collapse" id="Cleaners">
  <div class="well">  
  <div class="list-group">  
    <?php
    $members_sql = "SELECT user_username1, count(*) as 'memcount' FROM caller WHERE war_enemy = '$enemyname' GROUP BY user_username1 ORDER BY memcount ASC";
    $result_members = mysqli_query($database,$members_sql) or die(mysqli_error($database));
    while($mem = mysqli_fetch_array($result_members)){ 
	 $member = $mem['user_username1']; 
 $members_sql3 = "SELECT * FROM caller WHERE war_enemy = '$enemyname' AND  user_username1 = '$member'";
    $result_members3 = mysqli_query($database,$members_sql3) or die(mysqli_error($database));
    while($mem3 = mysqli_fetch_array($result_members3)){ 	 
	 $enemynum = $mem3['war_enemynumber'];
    $members_sql2 = "SELECT user_username, count(*) as 'memcount2' FROM score WHERE user_username='$member' AND war_enemy = '$enemyname' AND enemy_enemynumber = '$enemynum' AND Score = 3 GROUP BY user_username ";
    $result_members2 = mysqli_query($database,$members_sql2) or die(mysqli_error($database));
    while($mem2 = mysqli_fetch_array($result_members2)){
		$a = $mem['memcount'];
		$b = $mem2['memcount2'];
		$porcent_mem = ($b * 100) / $a;
		?>
<a href="profile.php?user_username=<?php echo $mem['user_username1'];?>" class="list-group-item"><strong><?php echo $mem['user_username1'];?></strong> <span class="badge" style="background-color:green;"><?php echo $mem['memcount'];?></span></a>
<?php } } }?>
</div>
</div>
  </div> 
  </div>
  </div>
  <div class="row">
    <div class="col-md-12">
<a class="btn btn-default btn-lg btn-block" role="button" data-toggle="collapse" href="#Cleaners2" aria-expanded="false" aria-controls="collapseExample">Cleaners 2nd call</a>
<div class="collapse" id="Cleaners2">
  <div class="well">  
  <div class="list-group">  
    <?php
    $members_sql = "SELECT user_username2, count(*) as 'memcount' FROM caller WHERE war_enemy = '$enemyname' GROUP BY user_username2 ORDER BY memcount ASC";
    $result_members = mysqli_query($database,$members_sql) or die(mysqli_error($database));
    while($mem = mysqli_fetch_array($result_members)){ 
	 $member = $mem['user_username2']; 
 $members_sql3 = "SELECT * FROM caller WHERE war_enemy = '$enemyname' AND  user_username2 = '$member'";
    $result_members3 = mysqli_query($database,$members_sql3) or die(mysqli_error($database));
    while($mem3 = mysqli_fetch_array($result_members3)){ 	 
	 $enemynum = $mem3['war_enemynumber'];	 
    $members_sql2 = "SELECT user_username, count(*) as 'memcount2' FROM score WHERE user_username='$member' AND war_enemy = '$enemyname' AND Score = 3 GROUP BY user_username ";
    $result_members2 = mysqli_query($database,$members_sql2) or die(mysqli_error($database));
    while($mem2 = mysqli_fetch_array($result_members2)){
		$a = $mem['memcount'];
		$b = $mem2['memcount2'];
		$porcent_mem = ($b * 100) / $a;
		?>
<a href="profile.php?user_username=<?php echo $mem['user_username2'];?>" class="list-group-item"><strong><?php echo $mem['user_username2'];?></strong> <span class="badge" style="background-color:orange;"><?php echo $mem['memcount'];?></span></a>
<?php  } } }?>
</div>
</div>
  </div> 
  </div>
  </div>
  <div class="row">
    <div class="col-md-12">
<a class="btn btn-default btn-lg btn-block" role="button" data-toggle="collapse" href="#Cleaners3" aria-expanded="false" aria-controls="collapseExample">Cleaners 3rd call</a>
<div class="collapse" id="Cleaners3">
  <div class="well">  
  <div class="list-group">     
    <?php
    $members_sql = "SELECT user_username3, count(*) as 'memcount' FROM caller WHERE war_enemy = '$enemyname' GROUP BY user_username3 ORDER BY memcount ASC";
    $result_members = mysqli_query($database,$members_sql) or die(mysqli_error($database));
    while($mem = mysqli_fetch_array($result_members)){ 
	 $member = $mem['user_username3']; 
 $members_sql3 = "SELECT * FROM caller WHERE war_enemy = '$enemyname' AND  user_username3 = '$member'";
    $result_members3 = mysqli_query($database,$members_sql3) or die(mysqli_error($database));
    while($mem3 = mysqli_fetch_array($result_members3)){ 	 
	 $enemynum = $mem3['war_enemynumber'];	 	 
    $members_sql2 = "SELECT user_username, count(*) as 'memcount2' FROM score WHERE user_username='$member' AND war_enemy = '$enemyname' AND Score = 3 GROUP BY user_username ";
    $result_members2 = mysqli_query($database,$members_sql2) or die(mysqli_error($database));
    while($mem2 = mysqli_fetch_array($result_members2)){
		$a = $mem['memcount'];
		$b = $mem2['memcount2'];
		$porcent_mem = ($b * 100) / $a;
		?>
<a href="profile.php?user_username=<?php echo $mem['user_username3'];?>" class="list-group-item"><strong><?php echo $mem['user_username3'];?></strong> <span class="badge" style="background-color:red;"><?php echo $mem['memcount'];?></span></a>
<?php } } }?>
</div>
  </div> 
  </div>
  </div>
  </div>
<?php if($user['user_title'] >= 4){?>  
  <div class="row">
    <div class="col-md-12">
<a class="btn btn-default btn-lg btn-block" role="button" data-toggle="collapse" href="#Unlucky" aria-expanded="false" aria-controls="collapseExample">Top 3 Unlucky</a>
<div class="collapse" id="Unlucky">
  <div class="well">  
  <div class="list-group">     
    <?php
    $sql = "SELECT user_username, SUM(score) FROM score WHERE war_enemy='$enemyname' GROUP BY user_username ORDER BY SUM(score) ASC LIMIT 3";
    $result = mysqli_query($database,$sql) or die(mysqli_error($database));
    while($rws = mysqli_fetch_array($result)){?>
<a href="profile.php?user_username=<?php echo $rws['user_username'];?>" class="list-group-item"><strong><?php echo $rws['user_username'];?></strong> <span class="badge" style="background-color:#F33;"><?php echo $rws['SUM(score)'];?><span class="fa fa-star"></span></span></a>
<?php  }?>
</div>
  </div> 
  </div>
  </div>
  </div>  
  <div class="row">
    <div class="col-md-12">
<a class="btn btn-default btn-lg btn-block" role="button" data-toggle="collapse" href="#fails" aria-expanded="false" aria-controls="collapseExample">Most Fails</a>
<div class="collapse" id="fails">
  <div class="well">  
  <div class="list-group">         
    <?php
    $members_sql = "SELECT user_username, count(*) as 'memcount' FROM score WHERE war_enemy = '$enemyname' GROUP BY user_username";
    $result_members = mysqli_query($database,$members_sql) or die(mysqli_error($database));
    while($mem = mysqli_fetch_array($result_members)){ 
	 $member = $mem['user_username']; 
    $members_sql2 = "SELECT user_username, count(*) as 'memcount2' FROM score WHERE user_username='$member' AND war_enemy = '$enemyname' AND Score = 0 GROUP BY user_username ORDER BY memcount2 DESC";
    $result_members2 = mysqli_query($database,$members_sql2) or die(mysqli_error($database));
    while($mem2 = mysqli_fetch_array($result_members2)){
		$a = $mem['memcount'];
		$b = $mem2['memcount2'];
		$porcent_mem = ($b * 100) / $a;
		?>
<a href="profile.php?user_username=<?php echo $mem['user_username'];?>" class="list-group-item"><strong><?php echo $mem['user_username'];?></strong> <span class="badge" style="background-color:orange;"><?php echo $mem2['memcount2'];?></span></a>
<?php  } }?>
</div>
  </div>       
<?php }?>
    </div>    
    </div> <!-- col del-->
</div>
</div>
</div>



</div>
<!-- end statistic page-->
</div> 
<?php }}?>