<?php
    $current_user = $_SESSION['user_username'];
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
    <!-- Navbar1 -->
	    <div id="navigation" class="navbar navbar-default navbar-fixed-top">
	      <div class="fluid-container">
	        <div class="navbar-header">
	          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse1">
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	          </button>
                <a class="navbar-brand" href="index.php"><img src="imagenes/logo.png" height="70" /></a>	        
            </div>
	        <div class="navbar-collapse collapse" id="navbar-collapse1">
                <form class="navbar-form navbar-left" role="search" method="post" autocomplete="off" action="search-result.php">
                    <div class="form-group">
                        <input type="text" class="search form-control" id="searchbox" placeholder="Search for People" name="search-form"/><br />
                        <div id="display"></div>
				    </div> 
				</form>
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo $row['user_username'];?><strong class="caret"></strong></a>                  
                        <ul class="dropdown-menu">
                            <li>
                                <a href="profile.php?user_username=<?php echo $row['user_username'];?>"><i class="fa fa-edit"></i>Profile</a>
                                <a href="edit-profile.php"><i class="fa fa-edit"></i> Edit Profile</a>
                                  <li><a href="components/logout.php"><i class="fa fa-mail-reply"></i> Logout</a></li>
                            </li>
                        </ul>
                    </li>	
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-bars" style="font-size: 1.27em;"></i>
                        </a>
                        <ul class="dropdown-menu">
                        	<h4>User menu</h4>
<?php
 $sql = "SELECT * FROM war_table ORDER BY war_warid DESC LIMIT 1";
    $result = mysqli_query($database,$sql) or die(mysqli_error($database));
    while($rws = mysqli_fetch_array($result,MYSQLI_BOTH)) {
?>		
                            
                            <li><a href="war.php?war_details=<?php echo $rws['war_warid'];?>&war_size=<?php echo $rws['war_size']; ?>"><i class="fa fa-star"></i> Current war</a></li>
<?php } ?>                            
                            <li><a href="rules.php"><i class="fa fa-list"> </i>Rules</a></li>
                            <li><a href="all-users.php"><i class="fa fa-th-large"></i> View all users</a></li>
                            
                            
                         <?php  
						 
$title_user = $row['user_title'];
if ($title_user >= 4){
		echo '<h4>Admin menu</h4>
                          <li><a href="createwar.php"><i class="fa fa-star"></i> Create War</a></li>
						  <li><a  href="edit-rules.php"><i class="fa fa-edit"></i> Edit Rules</a></li>
						  <li><a  href="stats_global.php"><i class="fa fa-list-alt"></i> Clan Stats</a></li>';
	}
 ?> 
                            <li></li>
                            <li></li>
                        </ul>
                    </li>	
                </ul>    
	        </div><!--/.nav-collapse -->
	      </div>
	    </div>
      <!-- ./Navbar1 -->
<?php
    }
?>