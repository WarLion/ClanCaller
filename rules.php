<?php include 'components/authentication.php' ?>
<?php include 'components/session-check.php' ?>
<?php include 'controllers/base/head.php' ?>
<?php include 'controllers/navigation/first-navigation.php' ?>
<div class="container" style="padding-top:50px;">
 <h1 class="text-center profile-name" style="margin-top:35;">Rules <br /><small> use them to be the best!</small></h1>
    <div class="col-md-12 panel" style="border-radius: 20px; margin-top:20px; margin-bottom:20px; padding-bottom:20px; padding-top:20px;"> 
       
       <?php 
	$rule = "SELECT * FROM rules ORDER BY rules_id DESC LIMIT 1";
    $result = mysqli_query($database,$rule);
    while($rule = mysqli_fetch_array($result,MYSQLI_BOTH)) {
?>
<P style="font-family:Verdana, Geneva, sans-serif">
<?php echo $rule['rule_txt'];?>
</p>
<br> <br> by <?php echo $rule['user_username'];?></address>
		<?php
}
?>
 </div>
  </div>
   </div>
