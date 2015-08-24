<?php include 'components/authentication.php' ?>   
<?php include 'components/session-check.php' ?>
<?php include 'controllers/base/head.php' ?>
<?php include 'controllers/navigation/first-navigation.php' ?> 
<?php include 'controllers/base/style.php' ?>

                            <div id="content">
                              <div class="row">
                                  <div class="col-md-12">
                                      <div  style="margin: 20px 0px;">
                                          <div class="panel-body">
                                              <div class="row">
                                                  <div class="container">
                                                      <div class="row clearfix">
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
                                                                        <div class="panel panel-default">
                                                                            <div class="panel-heading">
                                                                                 <a class="panel-title" data-toggle="collapse" data-parent="#panel-<?php echo $rws['user_id']; ?>" href="#panel-element-<?php echo $rws['user_id']; ?>"><p class="user_title" style="font-size:22;"><?php echo $rws['user_username'];?></p></a>
                                                                            </div>
                                                                            <div id="panel-element-<?php echo $rws['user_id']; ?>" class="panel-collapse collapse">
                                                                                <div class="panel-body">
                                                                                    <div class="col-md-6 column">
                                                                                       <div class="col-md-6 column">
                                                                                        <img src="userfiles/avatars/<?php echo $rws['user_avatar'];?>" name="aboutme" class="img-responsive" width="100">                                  														</div>
                                                                                        <div class="col-md-6 column">
                                                                                        <h2 class="profile-profession2"><a href="profile.php?user_username=<?php echo $rws['user_username'];?>"><?php echo $rws['user_username'];?></a> </h2><p class="user_title"><?php 
                        User_Title($rws['user_title']); ?></p>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-6 column">
                                                                                        <div class="col-md-12 column">
                                                                                        	<div class="col-md-6 column">
<?php
	if ($rws['user_th']){
	?>                                                                          
	<img src="imagenes/th/<?php echo $rws['user_th'];?>.png" height="100px" />
	<?php }else{ ?>   
	<img src="imagenes/th/noselect.png" width="100px" />
<?php }?>                                                                                            
                                                                                            </div>
                                                                                        	<div class="col-md-6 column">
                                        <img src="imagenes/troops/attacks/<?php echo $rws['user_favattack'];?>.png" height="100px" />
                                                                                        
                                                                                            </div>                                                                                            
                                                                                        </div>
                                                                                        <div class="col-md-12 column text-right" style="margin-top:5;" >
                                                                                        <div class="col-md-6 column text-right" >
                                                                                        </div>
                                                                                         <div class="col-md-4 column text-left" >
<?php
    $sql2 = "SELECT * FROM user WHERE user_username='$current_user'";
    $result2 = mysqli_query($database,$sql2);
    while($row = mysqli_fetch_array($result2,MYSQLI_BOTH)) {																				  
			$title_user = $row['user_title'];
			if ($title_user == 4 || $title_user == 5 || $title_user == 6){
			$admin_leader = $rws['user_title'];	
			if ($admin_leader < 5){?>
<a href="edit-users.php?user_username=<?php echo $rws['user_username'];?>"><i class="fa fa-edit"></i> Edit users</a></li> 
<?php  }}}?>                                                                                        
                                                                                         </div>                                                                                            
                                                                                        <div class="col-md-2 column text-right" >
                                                                                             <a href="profile.php?user_username=<?php echo $rws['user_username'];?>"><button type="button" class="btn btn-primary">View</button></a> 
                                                                                             </div>
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
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>