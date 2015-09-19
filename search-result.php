<?php include 'components/authentication.php' ?>   
<?php include 'components/session-check.php' ?>
<?php include 'controllers/base/head.php' ?>
<?php include 'controllers/navigation/first-navigation.php' ?> 

                                                  <div class="container" style="margin-top:30px;">
                                                  		<h2 class="text-center profile-text profile-name">Search</h2>
                                                          <div class="col-md-12 column">
                                                              <div class="row clearfix">
<?php
    if($_POST){
        $query=$_POST['search-form'];
        $sql=mysqli_query($database,"select * from user where user_firstname like '%$query%' or user_username like '%$query%' order by user_username");
        if( mysqli_num_rows($sql) > 0) {
            while($rws = mysqli_fetch_array($sql)){
?>
    <div class="panel-group" id="panel-<?php echo $rws['user_id']; ?>">
        <div class="panel panel-default"  style="margin-bottom:-20px;">
            <div class="panel-heading">
<?php
$sql2 = "SELECT * FROM user WHERE user_username='$current_user'";
$result2 = mysqli_query($database,$sql2);
while($row = mysqli_fetch_array($result2,MYSQLI_BOTH)) {?>            
                 <a class="panel-title" data-toggle="collapse" data-parent="#panel-<?php echo $rws['user_id']; ?>" href="#panel-element-<?php echo $rws['user_id']; ?>"><span style="font-size:22;"><?php echo $rws['user_username'];?> </a></span><span class="pull-right hidden-xs">
<?php																				  
$title_user = $row['user_title'];
if ($title_user == 4 || $title_user == 5 || $title_user == 6){
$admin_leader = $rws['user_title'];	
if ($admin_leader < 5){?>
<a class="btn btn-primary" href="edit-users.php?user_username=<?php echo $rws['user_username'];?>">Edit</a>
<?php  }}?>                                                                                        
                             <a class="btn btn-primary" href="profile.php?user_username=<?php echo $rws['user_username'];?>">View</a> 
                             </span> 
                 
                
            </div>
            <div id="panel-element-<?php echo $rws['user_id']; ?>" class="panel-collapse collapse">
                <div class="panel-body">
                	 <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="col-md-2 col-sm-2 col-xs-12">
                    
                       <a href="profile.php?user_username=<?php echo $rws['user_username'];?>"> <img src="userfiles/avatars/<?php echo $rws['user_avatar'];?>" name="aboutme" class="img-responsive center-block" width="100"> </a>                    
                    </div>
                    <div class="col-md-10 col-sm-10 col-xs-12">
                        <h2 class="profile-profession2"><a href="profile.php?user_username=<?php echo $rws['user_username'];?>"><?php echo $rws['user_username'];?></a> </h2><p class="user_title"><?php User_Title($rws['user_title']); ?></p>

                             </div>
                      <div class="footer visible-xs text-center">

<?php																				  
$title_user = $row['user_title'];
if ($title_user == 4 || $title_user == 5 || $title_user == 6){
$admin_leader = $rws['user_title'];	
if ($admin_leader < 5){?>
<a class="btn btn-primary" href="edit-users.php?user_username=<?php echo $rws['user_username'];?>">Edit</a>
<?php  }}}?>                                                                                        
                             <a class="btn btn-primary" href="profile.php?user_username=<?php echo $rws['user_username'];?>">View</a> 

                      </div>       
                	</div>
            	</div>
         </div>
    	 </div>
    </div>     
<?php 
            } 
        }
        else{
?>
                                                                                <center>
                                                                                    <h1>No Results to show</h1>
                                                                                </center>
<?php      
        }
    }                                                              
?>                                                                
                                                          </div>
                                                      </div>
                                                  </div>
                                              </div>                                        