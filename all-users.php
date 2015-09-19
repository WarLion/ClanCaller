<?php include 'components/authentication.php' ?>     
<?php include 'components/session-check.php' ?>
<?php include 'controllers/base/head.php' ?>
<?php include 'controllers/navigation/first-navigation.php' ?>   
                                                     <div class="container" style="padding-top:50px;">
                                                       <h2 class="text-center profile-text profile-name">Members List</h2>
                                                      <div class="row clearfix">
                                                          <div class="col-md-12 column">
                                                              <div class="row clearfix">
<?php
    include '_database/database.php';
    $sql = "SELECT * FROM user WHERE user_title = 1 order by user_username asc";
    $result = mysqli_query($database,$sql) or die(mysqli_error($database));
    while($rws = mysqli_fetch_array($result)){ 
	
	
	
?>
                                                                  <div class="col-sm-6 col-md-4" style="margin-top:-15px;">
                                                                    <div class="panel-group" id="panel-<?php echo $rws['user_id']; ?>">
                                                                        <div class="panel panel-default">
                                                                            <div id="panel-element-<?php echo $rws['user_id']; ?>" class="panel-collapse collapse in">
                                                                                <div class="panel-body">
                                                                                    <div class="col-md-3 col-sm-3 col-xs-12 text-center visible-xs">
                                                                                      <a href="profile.php?user_username=<?php echo $rws['user_username'];?>">
                                                                                        <img src="userfiles/avatars/<?php echo $rws['user_avatar'];?>" name="aboutme" height="60px">                                  
                                                                                        </a>
                                                                                    </div>
                 
                                                                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                                                                        <h2><a href="profile.php?user_username=<?php echo $rws['user_username'];?>"><span class="user_title" style="font-size:18; color:#FFF;"><?php echo $rws['user_username'];?></span></a><br /> <small><?php 
                        User_Title($rws['user_title']); ?></small><span class="pull-right">
<?php
$sql2 = "SELECT * FROM user WHERE user_username='$current_user'";
$result2 = mysqli_query($database,$sql2);
while($row = mysqli_fetch_array($result2,MYSQLI_BOTH)) { 																			  
$title_user = $row['user_title'];
if ($title_user == 4 || $title_user == 5 || $title_user == 6){
$admin_leader = $rws['user_title'];	
if ($admin_leader < 5){?>
<a class="btn btn-primary btn-sm" href="edit-users.php?user_username=<?php echo $rws['user_username'];?>">Edit</a>
<?php  }} }?> 
                        </span></h2>
                                                                                    </div>                                                                                    
                                                                                    
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                  </div>
 <?php  }?>                                                         
                                                              </div>
                                                          </div>
 <div class="col-md-12 column">
                                                              <div class="row clearfix">
<?php
    include '_database/database.php';
    $sql = "SELECT * FROM user WHERE user_title <> 1 order by user_username asc";
    $result = mysqli_query($database,$sql) or die(mysqli_error($database));
    while($rws = mysqli_fetch_array($result)){ 
	
	
	
?>
                                                                  <div class="col-sm-6 col-md-4" style="margin-top:-15px;">
                                                                    <div class="panel-group" id="panel-<?php echo $rws['user_id']; ?>">
                                                                        <div class="panel panel-default">
                                                                            <div id="panel-element-<?php echo $rws['user_id']; ?>" class="panel-collapse collapse in">
                                                                                <div class="panel-body">
                                                                                    <div class="col-md-3 col-sm-3 col-xs-12 text-center visible-xs">
                                                                                      <a href="profile.php?user_username=<?php echo $rws['user_username'];?>">
                                                                                        <img src="userfiles/avatars/<?php echo $rws['user_avatar'];?>" name="aboutme" height="60px">                                  
                                                                                        </a>
                                                                                    </div>
                 
                                                                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                                                                        <h2><a href="profile.php?user_username=<?php echo $rws['user_username'];?>"><span class="user_title" style="font-size:18; color:#FFF;"><?php echo $rws['user_username'];?></span></a><br /> <small><?php 
                        User_Title($rws['user_title']); ?></small></h2>
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