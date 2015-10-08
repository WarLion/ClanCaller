<?php include 'components/authentication.php' ?>     
<?php include 'components/session-check.php' ?>
<?php include 'controllers/base/head.php' ?>
<?php include 'controllers/navigation/first-navigation.php' ?> 
<?php
$per_page=10;
if (isset($_GET["page"])) {
$page = $_GET["page"];
}
else {
$page=1;
}
$start_from = ($page-1) * $per_page;
?> 

                                                     <div class="container" style="padding-top:50px;">
                                                       <h2 class="text-center profile-text profile-name">Members List</h2>
                                                      <div class="row clearfix">
                                                          <div class="col-md-12 column">
                                                              <div class="row clearfix">

<div class="panel panel-default" style="border-radius: 19px;">
  <!-- Default panel contents -->
  <div class="panel-heading" style="border-radius: 19px 19px 0px 0px;"><img src="imagenes/logo.png" height="25" /> All Users <a href="#" data-toggle="collapse" data-target="#col-izq-1" style="font-weight:bold;"><span class="pull-right fa fa-remove"></span></a></div>
		 <div id="col-izq-1" class="collapse in panel-body">
  <!-- Table -->
  <table class="table" id="myTable">
  <thead> 
    <tr>
    	<td>#</td>
        <td>UserName</td>
        <td class="text-center">Title</td>
        <td class="text-center">Th</td>
        <td class="text-center">Barbarian King</td>
        <td class="text-center">Archer Queen</td>
        <td></td>
        </thead>
    </tr>
 <?php
    $sql = "SELECT * FROM user ORDER BY user_title  LIMIT $start_from, $per_page";
    $result = mysqli_query($database,$sql) or die(mysqli_error($database));
	$i=1;
	
	
	?>    
<?php
    while($rws = mysqli_fetch_array($result)){
	$num = $i++;	?>
    <tr>
    <td><?php echo $num;?></td>
        <td><a href="profile.php?user_username=<?php echo $rws['user_username'];?>" style="font-weight:bold;"><?php echo $rws['user_username'];?></a></td>
        <td class="text-center"><?php User_Title($rws['user_title']);?></td>
        <th class="text-center"><?php echo $rws['user_th'];?></th>
        <td class="text-center"><?php echo $rws['user_bk'];?></td>
        <td class="text-center"><?php echo $rws['user_aq'];?></td>
		<td><a class="btn btn-primary btn-sm pull-right" href="profile.php?user_username=<?php echo $rws['user_username'];?>">View</a></td>       
    </tr>
    <?php }	 
	?>  
  </table>
  		</div>
        <div class="panel-footer text-center"  style="border-radius: 0px 0px 19px 19px;">
        <?php
$query = "select * from user";
$result = mysqli_query($database, $query);
$total_records = mysqli_num_rows($result);
$total_pages = ceil($total_records / $per_page);?>
<nav>
  <ul class="pagination">
    <li>
	 <a href="all-users.php?page=1"> <span aria-hidden="true">&laquo;</span></a>
      </a>
    </li>
<li>
<?php for ($i=1; $i<=$total_pages; $i++) {?>
<a href="all-users.php?page=<?php echo $i;?>"><?php echo $i;?></a>
<?php }?>
</li>
<li>
<a href="all-users.php?page=<?php echo $total_pages;?>"><span aria-hidden="true">&raquo;</span></a>
</li>
</ul>
</nav>

</div>
</div>


                                                              </div>
                                                          </div>                                                          
                                                      </div>
                                                  </div>
                                                  <script>
												  $(document).ready(function() 
    { 
        $("#myTable").tablesorter(); 
    } 
); </script>