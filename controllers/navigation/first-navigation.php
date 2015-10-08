<?php
    include '_database/database.php';	
    $sql = "SELECT * FROM user WHERE user_username='$current_user'";
    $result = mysqli_query($database,$sql);
    while($row = mysqli_fetch_array($result,MYSQLI_BOTH)) {
		
function User_Title($title_user){
	if ($title_user == 0){
		echo 'Banned';
		}elseif($title_user == 1){
			echo 'awaiting approval';
		}elseif($title_user == 2){
			echo 'Member';
		}elseif($title_user == 3){
			echo 'Elder';
		}elseif($title_user == 4){
			echo 'Co-leader';
		}elseif($title_user == 5){
			echo 'Leader';
		}elseif($title_user == 6){
			echo 'Web Admin';
		}	
	}
		
?>
<nav id="navigation" class="navbar navbar-default navbar-fixed-top">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.php">
      	 <img alt="Brand" src="./imagenes/logo.png" height="50">
      </a>
    </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

      <ul class="nav navbar-nav navbar-right">
                <form class="navbar-form navbar-left" role="search" method="post" autocomplete="off" action="search-result.php">
                    <div class="form-group">
                        <input type="text" class="search form-control" id="searchbox" placeholder="Search for People" name="search-form"/><br />
                        <div id="display"></div>
				    </div> 
				</form>
      <li><a href="#"><span class="fa fa-eye" style="color:#093;"></span></a></li>   
        <li class="dropdown">
        	<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="fa fa-user"></span> <?php echo $current_user;?> <span class="caret"></span></a>
		  <ul class="dropdown-menu">
            <li><a href="profile.php?user_username=<?php echo $row['user_username'];?>"><span class="fa fa-user"></span> Profile</a></li>
            <!--<li><a href="#"><span class="fa fa-envelope"></span> PM</a></li>-->
            <li><a href="edit-profile.php"><span class="fa fa-cog"></span> User Setings</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="#"><span class="fa fa-fire"></span> Your Base</a></li>
            <li><a href="#"><span class="fa fa-leaf"></span> Your Weight</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="components/logout.php"><span class="fa fa-minus"></span> Log out</a></li>
            
          </ul>            
        </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Menu <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="rules.php"><span class="fa fa-envelope"></span> Rules</a></li>   
<?php
 $sql = "SELECT * FROM war_table ORDER BY war_warid DESC LIMIT 1";
    $result = mysqli_query($database,$sql) or die(mysqli_error($database));
    while($rws = mysqli_fetch_array($result,MYSQLI_BOTH)) {
?>	                   
            <li><a href="war.php?war_details=<?php echo $rws['war_warid'];?>&war_size=<?php echo $rws['war_size']; ?>"><span class="fa fa-user"></span> Current War</a></li>
 <?php }?>
           <!-- <li><a href="#"><span class="fa fa-th-list"></span> War Log</a></li>-->
           <li><a href="all-users.php"><i class="fa fa-th-large"></i> View all users</a></li>
            <li><a href="stats_global.php"><span class="fa fa-list-alt"></span> Statistics</a></li>  
<?php  
$title_user = $row['user_title'];
if ($title_user >= 3){?>
<li><a href="createwar.php"><i class="fa fa-star"></i> Create War</a></li>
<?php }?>
                            
                         <?php  
$title_user = $row['user_title'];
if ($title_user >= 4){ ?>  
            <li role="separator" class="divider"></li>    
            <li><a href="admin.php"><span class="fa fa-cog"></span> Clan Settings</a></li>
          <?php }?>  
          </ul>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
<?php
    }
?>