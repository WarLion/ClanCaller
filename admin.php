<?php include 'components/authentication.php' ?> 
<?php include 'components/session-check.php' ?>
<?php include 'components/session-check-admin.php' ?>
<?php include 'controllers/base/head.php' ?>
<?php include 'controllers/navigation/first-navigation.php' ?> 
   
<script type="text/javascript" src="http://ajax.googleapis.com/
ajax/libs/jquery/1.5/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function()
{
$(".edit_tr").click(function()
{
var ID=$(this).attr('id');
$("#ww_"+ID).hide();
$("#wl_"+ID).hide();
$("#wt_"+ID).hide();
$("#ww_input_"+ID).show();
$("#wl_input_"+ID).show();
$("#wt_input_"+ID).show();
}).change(function()
{
var ID=$(this).attr('id');
var ww=$("#ww_input_"+ID).val();
var wl=$("#wl_input_"+ID).val();
var wt=$("#wt_input_"+ID).val();
var dataString = 'id='+ ID +'&ww='+ww+'&wl='+wl+'&wt='+wt;

if(ww.length>0&& wl.length>0&& wt.length>0)
{

$.ajax({
type: "POST",
url: "components/update_claninfo.php",
data: dataString,
cache: false,
success: function(html)
{
$("#ww_"+ID).html(ww);
$("#wl_"+ID).html(wl);
$("#wt_"+ID).html(wt);
}
});
}
else
{
alert('Enter something.');
}

});

// Edit input box click action
$(".editbox").mouseup(function()
{
return false
});

// Outside click action
$(document).mouseup(function()
{
$(".editbox").hide();
$(".text").show();
});

});
</script>
<div class="container">				
				<h2 class="text-center profile-text profile-name">Clan Settings</h2>
 <div class="col-md-12">
 <!-- col der-->
     <div class="col-md-4">
        <div class="col-md-12">

<div class="panel panel-default">
  <div class="panel-heading"><img src="imagenes/logo.png" height="25" /> Menu<a href="#" data-toggle="collapse" data-target="#col-del-2" style="font-weight:bold;"><span class="pull-right fa fa-remove"></span></a></div>
  <div id="col-del-2" class="collapse in panel-body">
<div class="list-group">
  <a href="edit-rules.php" class="list-group-item"><i class="fa fa-edit"></i> Edit Rules</a>
  <a href="createwar.php" class="list-group-item"><i class="fa fa-star"></i> Create War</a>
</div>
  </div>
        </div>

<div class="panel panel-default">
  <div class="panel-heading"><img src="imagenes/logo.png" height="25" /> Clan Info<a href="#" data-toggle="collapse" data-target="#col-del-1" style="font-weight:bold;"><span class="pull-right fa fa-remove"></span></a></div>
  <div id="col-del-1" class="collapse in panel-body">
<table class="table">
 <?php 
    $sql = "SELECT count(user_username) FROM user";
    $result = mysqli_query($database,$sql) or die(mysqli_error($database));
while($rws_user = mysqli_fetch_array($result))
{
	  echo '<tr><td><i class="fa fa-user"></i> Members:</td><td><span class="pull-right editable">'.$rws_user['count(user_username)'].'/50</span></td></tr>'; 
    }?>   
 <?php 
    $sql_ci = "SELECT * FROM clan_info";
    $result_ci = mysqli_query($database,$sql_ci) or die(mysqli_error($database));
while($ci = mysqli_fetch_array($result_ci))
{
	$id = $ci['id'];
	$ww = $ci['war_won'];
	$wl = $ci['war_lost'];
	$wt = $ci['war_tie'];
	  ?>         
<tr id="<?php echo $id; ?>" class="edit_tr">
<td><i class="fa fa-thumbs-up"></i> War Wons:</td>
<td class="edit_td">
<span id="ww_<?php echo $id; ?>" class="text pull-right"><?php echo $ww; ?></span>
<input type="text" value="<?php echo $ww; ?>" class="editbox" id="ww_input_<?php echo $id; ?>"  style="display: none"/>
</td>
</tr>
<tr id="<?php echo $id; ?>" class="edit_tr">
<td><i class="fa fa-thumbs-down"></i> War Lost:</td>
<td class="edit_td">
<span id="wl_<?php echo $id; ?>" class="text pull-right"><?php echo $wl; ?></span>
<input type="text" value="<?php echo $wl; ?>" class="editbox" id="wl_input_<?php echo $id; ?>"  style="display: none"/>
</td>
</tr>
<tr id="<?php echo $id; ?>" class="edit_tr">
<td><i class="fa fa-minus"></i> War Tie:</td>
<td class="edit_td">
<span id="wt_<?php echo $id; ?>" class="text pull-right"><?php echo $wt; ?></span>
<input type="text" value="<?php echo $wt; ?>" class="editbox" id="wt_input_<?php echo $id; ?>"  style="display: none"/>
</td>
</tr>
		<?php  }?>      
   </table>

   
    </div>
  </div>

        
        </div>
     </div>
  <!-- end col der-->
  <!-- col izq-->
   <div class="col-md-8">
   <?php
    $sql = "SELECT * FROM user where user_title = '1'";
    $result = mysqli_query($database,$sql) or die(mysqli_error($database));
    if( mysqli_num_rows($result) > 0) {
	?>
  <div class="row">
<div class="panel panel-default">
  <!-- Default panel contents -->
  <div class="panel-heading"><i class="fa fa-user"></i> Members Awaiting Approval<a href="#" data-toggle="collapse" data-target="#col-izq-0" style="font-weight:bold;"><span class="pull-right fa fa-remove"></span></a></div>
		 <div id="col-izq-0" class="collapse in panel-body">
  <!-- Table -->
  <table class="table">
 <?php while($rws = mysqli_fetch_array($result)){?>
    <tr>
        <td><a href="profile.php?user_username=<?php echo $rws['user_username'];?>" style="font-weight:bold;"><?php echo $rws['user_username'];?></a></td>
        <td >Awaiting Approval</td>
        <td><a class="btn btn-primary btn-sm pull-right" href="edit-users.php?user_username=<?php echo $rws['user_username'];?>">Edit</a></td>
    </tr>
   <?php }	?> 
  </table>
  		</div>
</div>  
<?php }	?>
<!---->
<div class="panel panel-default">
  <!-- Default panel contents -->
  <div class="panel-heading"><img src="imagenes/logo.png" height="25" /> Top Ten Best Attackers<a href="#" data-toggle="collapse" data-target="#col-izq-1" style="font-weight:bold;"><span class="pull-right fa fa-remove"></span></a></div>
		 <div id="col-izq-1" class="collapse in panel-body">
  <!-- Table -->
  <table class="table">
    <tr>
        <td>UserName</td>
        <td>Stars</td>
        <td></td>
    </tr>
 <?php
 	
    $sql = "SELECT user_username, SUM(score) FROM score GROUP BY user_username ORDER BY SUM(score) DESC LIMIT 10";
    $result = mysqli_query($database,$sql) or die(mysqli_error($database));
    while($rws = mysqli_fetch_array($result)){?>
    <tr>
        <td><a href="profile.php?user_username=<?php echo $rws['user_username'];?>" style="font-weight:bold;"><?php echo $rws['user_username'];?></a></td>
        <td ><?php echo $rws['SUM(score)'];?> <i class="fa fa-star"></i></td>
        <td><a class="btn btn-primary btn-sm pull-right" href="edit-users.php?user_username=<?php echo $rws['user_username'];?>">Edit</a></td>
    </tr>
    <?php }	 
	?>  
  </table>
  		</div>
</div>
<div class="panel panel-default">
  <!-- Default panel contents -->
  <div class="panel-heading"><img src="imagenes/logo.png" height="25" /> Top Five Worst Attackers<a href="#" data-toggle="collapse" data-target="#col-izq-2" style="font-weight:bold;"><span class="pull-right fa fa-remove"></span></a></div>
		 <div id="col-izq-2" class="collapse in panel-body">
  <!-- Table -->
  <table class="table">
    <tr>
        <td>UserName</td>
        <td>Stars</td>
        <td></td>
    </tr>
   <?php
 	
    $sql = "SELECT user_username, SUM(score) FROM score GROUP BY user_username ORDER BY SUM(score) ASC LIMIT 5";
    $result = mysqli_query($database,$sql) or die(mysqli_error($database));
    while($rws = mysqli_fetch_array($result)){?>
    <tr>
        <td><a href="profile.php?user_username=<?php echo $rws['user_username'];?>" style="font-weight:bold;"><?php echo $rws['user_username'];?></a></td>
        <td ><?php echo $rws['SUM(score)'];?> <i class="fa fa-star"></i></td>
        <td><a class="btn btn-primary btn-sm pull-right" href="edit-users.php?user_username=<?php echo $rws['user_username'];?>">Edit</a></td>
    </tr>
    <?php }	 
	?>  
  </table>
  </table>
  		</div>
</div>
    </div>

 <!-- end col izq-->
 
 </div>
               
</div> 

