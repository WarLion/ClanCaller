<?php include 'components/authentication.php' ?> 
<?php include 'components/session-check.php' ?>
<?php include 'controllers/base/head.php' ?>
<?php include 'controllers/navigation/first-navigation.php' ?> 
<?php include 'controllers/base/style.php' ?>
<div class="container">				
				<?php
                    include '_database/database.php';
                    $current_war = '1508';
                    $sql = "SELECT * FROM war_table WHERE war_warid='$current_war'";
                    $result = mysqli_query($database,$sql) or die(mysqli_error($database));
                    while($rws = mysqli_fetch_array($result)){ 
					
					$war_stars = $rws['war_size'];
					$war_stars_total = $war_stars * 3;
					$enemy_name = $rws['war_enemy'];
					
					$sql_score = "SELECT SUM(score) FROM score WHERE war_enemy='$enemy_name'";
                    $result_score = mysqli_query($database,$sql_score) or die(mysqli_error($database));
                    while($score = mysqli_fetch_array($result_score)){ 
					
					$score_total = $score['SUM(score)'];
					echo $score_total,' total<br>';
					
					
					$sql_score = "SELECT SUM(max_score) FROM (SELECT war_enemy, MAX(score) as max_score from score WHERE war_enemy ='$enemy_name' group by enemy_enemynumber) as total";
                    $result_score = mysqli_query($database,$sql_score) or die(mysqli_error($database));
                    while($score = mysqli_fetch_array($result_score)){ 
					echo $score['SUM(max_score)'],' this one' ;
					
					}}}
					
					
					
$sql = "SELECT SUM(max_score) FROM (SELECT war_enemy, MAX(score) AS max_score FROM score WHERE war_enemy ='$enemy_name' GROUP BY enemy_enemynumber) AS total";
$result = mysqli_query($database,$sql) or die(mysqli_error($database));
while($res = mysqli_fetch_array($result)){      
echo $res['SUM(max_score)'];
}
					
					
					
 ?>
 
               
</div> 

