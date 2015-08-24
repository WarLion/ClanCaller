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
?> 

<div class="container">		
    <h1 class="text-center profile-name" style="margin-top:35;">Statistics <small><br /><?php echo $enemyname;?></small></h1><br />	
    <div class="text-right"><a href="javascript:history.go(-1)" class="btn btn-success" onMouseOver="self.status=document.referrer;return true">back</a> </div>	
<!-- start statistic page -->
<div class="col-md-12 panel">
	<div class="col-md-8">
<div class="col-md-6"  style="padding:20;">
    <label>Most used attack</label>
    <hr />
    <?php
    $sql = "SELECT favattack, count(*) as 'Cnt' FROM score WHERE war_enemy='$enemyname' GROUP BY favattack ORDER BY 2 DESC LIMIT 2";
    $result = mysqli_query($database,$sql) or die(mysqli_error($database));
    while($rws = mysqli_fetch_array($result)){?>    
    <div class="col-xs-6 col-sm-6 col-md-6 text-center">
        <div class="imageAndText">
            <img src="imagenes/troops/attacks/<?php echo $rws['favattack'];?>.png" class="align-center img-responsive">
            <div class="col">
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <p><span class="badge" style="background-color:#F90;"><?php echo $rws['Cnt'];?></span></p>
                </div>
            </div>
        </div>
    
	</div>
    <?php  }?>    
</div>

<div class="col-md-6"  style="padding:20;">
    <label>Less used attack</label>
    <hr />
    <?php
    $sql = "SELECT favattack, count(*) as 'Cnt' FROM score WHERE war_enemy='$enemyname' GROUP BY favattack ORDER BY 2 ASC LIMIT 2";
    $result = mysqli_query($database,$sql) or die(mysqli_error($database));
    while($rws = mysqli_fetch_array($result)){?>
    
    <div class="col-xs-6 col-sm-6 col-md-6 text-center">
        <div class="imageAndText">
            <img src="imagenes/troops/attacks/<?php echo $rws['favattack'];?>.png" class="align-center img-responsive">
            <div class="col">
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <p><span class="badge" style="background-color:#F90;"><?php echo $rws['Cnt'];?></span></p>
                </div>
            </div>
        </div>
    

    </div>
    <?php  }?>    
</div>  

<div class="col-md-6"  style="padding:20;">
    <label>Most Successful attack</label>
    <hr />
    <?php
     $sql = "SELECT favattack, count(*) as 'Cnt' FROM score WHERE score = 3 AND war_enemy='$enemyname' GROUP BY favattack ORDER BY 2 DESC LIMIT 2";
    $result = mysqli_query($database,$sql) or die(mysqli_error($database));
    while($rws = mysqli_fetch_array($result)){?>    
    <div class="col-xs-6 col-sm-6 col-md-6 text-center">
        <div class="imageAndText">
            <img src="imagenes/troops/attacks/<?php echo $rws['favattack'];?>.png" class="align-center img-responsive">
            <div class="col">
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <p><span class="badge" style="background-color:#F90;"><?php echo $rws['Cnt'];?></span></p>
                </div>
            </div>
        </div>
    
	</div>
    <?php  }?>    
</div>

<div class="col-md-6"  style="padding:20;">
    <label>Less Successful attack</label>
    <hr />
    <?php
 $sql = "SELECT favattack, count(*) as 'Cnt' FROM score WHERE score = 0 AND war_enemy='$enemyname' GROUP BY favattack ORDER BY 2 DESC LIMIT 2";
    $result = mysqli_query($database,$sql) or die(mysqli_error($database));
    while($rws = mysqli_fetch_array($result)){?>    
    <div class="col-xs-6 col-sm-6 col-md-6 text-center">
        <div class="imageAndText">
            <img src="imagenes/troops/attacks/<?php echo $rws['favattack'];?>.png" class="align-center img-responsive">
            <div class="col">
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <p><span class="badge" style="background-color:#F90;"><?php echo $rws['Cnt'];?></span></p>
                </div>
            </div>
        </div>
    
	</div>
    <?php  }?>    
</div>  
    </div>
    
    
    <!-- col der-->
	<div class="col-md-4">
   <div class="col-md-12">
<h2>Top 3</h2>
    <div class="col-md-12">
    <div class="list-group">
    <?php
    $sql = "SELECT user_username, SUM(score) FROM score WHERE war_enemy='$enemyname' GROUP BY user_username ORDER BY SUM(score) DESC LIMIT 3";
    $result = mysqli_query($database,$sql) or die(mysqli_error($database));
    while($rws = mysqli_fetch_array($result)){?>
<a href="profile.php?user_username=<?php echo $rws['user_username'];?>" class="list-group-item"><strong><?php echo $rws['user_username'];?> </strong><span class="badge" style="background-color:green;"><?php echo $rws['SUM(score)'];?><span class="fa fa-star"></span></span></a>
<?php  }?>
</div>
</div>
  <div class="row">
  <h2>unlucky</h2>
    <div class="col-md-12">
    <?php
    $sql = "SELECT user_username, SUM(score) FROM score WHERE war_enemy='$enemyname' GROUP BY user_username ORDER BY SUM(score) ASC LIMIT 1";
    $result = mysqli_query($database,$sql) or die(mysqli_error($database));
    while($rws = mysqli_fetch_array($result)){?>
<a href="profile.php?user_username=<?php echo $rws['user_username'];?>" class="list-group-item"><strong><?php echo $rws['user_username'];?></strong> <span class="badge" style="background-color:#F33;"><?php echo $rws['SUM(score)'];?><span class="fa fa-star"></span></span></a><br />
<?php  }?>
</div>
  </div> 

    </div>    
    </div>
    
   <div class="row">
   	<div class="col-md-12 text-center">
    <label>Harder Enemy Base</label>
    <hr />
    <div class="col-md-6">
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

<div id="chart_div" class="align-center img-responsive"></div>


    </div>
             
  <div class="col-md-2">
<?php 
	$enemynumber = $r['enemy_enemynumber'];
	$sql = "SELECT call_base FROM caller WHERE war_enemynumber='$enemynumber' AND war_enemy = '$enemyname' ORDER BY war_enemynumber ASC";
    $result = mysqli_query($database,$sql) or die(mysqli_error($database));
    while($rws = mysqli_fetch_array($result)){?>    
<a href="userfiles/screenshoots/<?Php echo $rws['call_base'];?>"><img src="userfiles/screenshoots/<?Php echo $rws['call_base'];?>" class="img-thumbnail" alt="Enemy-<?php echo $r['enemy_enemynumber']?>"/></a>

<?php  }?>
    </div>   
    </div>
   
   </div> 


</div>
<!-- end statistic page-->
</div> 
<?php }?>