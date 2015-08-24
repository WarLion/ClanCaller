<?php include 'components/authentication.php' ?>     
<?php include 'components/session-check.php' ?>
<?php include 'controllers/base/head.php' ?>
<?php include 'controllers/base/style.php' ?>
<?php include 'controllers/navigation/first-navigation.php' ?>   
                                                     <div class="container" style="padding-top:50px;">
                                                       <h2 class="text-center profile-text profile-name">User List</h2>
                                                      <div class="row clearfix">
                                                          <div class="col-md-12 column">
                                                              <div class="row clearfix">
<?php
    include '_database/database.php';
    $current_user = $_SESSION['user_username'];
    $sql = "SELECT * FROM user order by user_username asc";
    $result = mysqli_query($database,$sql) or die(mysqli_error($database));
    while($rws = mysqli_fetch_array($result)){ 
	
	
	
?>
                                                                  <div class="col-md-6 column">
                                                                    <div class="panel-group" id="panel-<?php echo $rws['user_id']; ?>">
                                                                        <div class="panel panel-default">
                                                                            <div id="panel-element-<?php echo $rws['user_id']; ?>" class="panel-collapse collapse in">
                                                                                <div class="panel-body">
                                                                                    <div class="col-md-6 column">
                                                                                      <a href="profile.php?user_username=<?php echo $rws['user_username'];?>">
                                                                                        <img src="userfiles/avatars/<?php echo $rws['user_avatar'];?>" name="aboutme" width="90">                                  
                                                                                        </a>
                                                                                    </div>
                                                                                    <div class="col-md-6 column">
                                                                                        <h2><a href="profile.php?user_username=<?php echo $rws['user_username'];?>"><?php echo $rws['user_username'];?></a> <small><?php 
                        User_Title($rws['user_title']); ?></small></h2>
                                                                                    </div>
                                                                                    <div class="col-md-6">
                                                                                      <?php
																					  
																			  
    $sql2 = "SELECT * FROM user WHERE user_username='$current_user'";
    $result2 = mysqli_query($database,$sql2);
    while($row = mysqli_fetch_array($result2,MYSQLI_BOTH)) {																				  
																					  
																					  
																					   $title_user = $row['user_title'];
																						if ($title_user == 4 || $title_user == 5 || $title_user == 6){
																								$admin_leader = $rws['user_title'];	
																							if ($admin_leader < 5){
											?><a href="edit-users.php?user_username=<?php echo $rws['user_username'];?>"><i class="fa fa-edit"></i> Edit users</a></li><?php
																							}}}?>
                                                                                    </div>                                                                                    
                                                                                    
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                  </div>
 <?php  }?>                                                         
                                                              </div>
                                                          </div>
                                                      </div>
                                                  </div>