<?php include 'components/authentication.php' ?>     
<?php include 'components/session-check.php' ?>
<?php include 'controllers/base/head.php' ?>
<?php include 'controllers/base/style.php' ?>
<?php include 'controllers/navigation/first-navigation.php' ?> 
<div class="container" style="padding-top:50px;">
 <h1 class="text-center profile-name" style="margin-top:35;">Bugs or Subjections <br /><small> Help us to get better !</small></h1>
    <div class="col-md-12 panel" style="border-radius: 20px; margin-top:20px; margin-bottom:20px; padding-bottom:20px; padding-top:20px;"> 
       
 <?php 
 
 $sql_user = "SELECT * FROM user WHERE user_username='$current_user'";
$result_user = mysqli_query($database,$sql_user) or die(mysqli_error($database));
while($user = mysqli_fetch_array($result_user)){ 
 if($user['user_title'] !== '6'){
 ?>


            <div class="row">
                <div class="col-lg-8 col-lg-offset-2">
                            <?php if ( isset($_GET['send'])) {?>
                            <div class="form-group col-xs-12">
                                <h1>thanks for you message!</h1>
                            </div>    
                            <?php }?>  
                            <?php if ( isset($_GET['fail'])) {?>
                            <div class="form-group col-xs-12">
                                <h1>Fail sending the message try again later!</h1>
                            </div>    
                            <?php }?>                                             
                    <form action="components/contact_me.php" method="post" enctype="multipart/form-data" id="UploadForm">
                        <div class="row control-group">
                            <div class="form-group col-xs-12 floating-label-form-group controls">
                                <label>Name</label>
                                <input type="text" class="form-control" placeholder="name" id="name" name="name" required data-validation-required-message="Please enter your name.">
                            </div>
                        </div>
                        <div class="row control-group">
                            <div class="form-group col-xs-12 floating-label-form-group controls">
                                <label>Email Address</label>
                                <input type="email" class="form-control" placeholder="Email Address" id="email" name="email" required data-validation-required-message="Please enter your email address.">
                            </div>
                        </div>
                        <div class="row control-group">
                            <div class="form-group col-xs-12 floating-label-form-group controls">
                                <label>Type</label>
<select class="form-control" name="bug_type">
	<option>Select one..</option>
  <option value="bugs">Bugs</option>
  <option value="subjection">subjection</option>
  <option value="other">Other</option>
</select>                               
                            </div>
                        </div>                        
                        <div class="row control-group">
                            <div class="form-group col-xs-12 floating-label-form-group controls">
                                <label>Message</label>
                                <textarea rows="5" class="form-control" placeholder="message" id="message" name="message" required data-validation-required-message="Please enter a message."></textarea>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group col-xs-12">
                                <button class="btn btn-primary ladda-button" data-style="zoom-in" type="submit"  id="SubmitButton" value="Upload" />Send</button>
                            </div>                       
                        </div>
                    </form>
                </div>
               </div> 



<?php }else{?>
<table class="table text-center">   
  <thead> 
        <tr>
          <th  class="text-center">Name</th>
          <th  class="text-center">Email</th>
          <th  class="text-center">Type</th>
          <th  class="text-center">Message</th>
          <th  class="text-center">Read</th>
        </tr>
      </thead>
      <tbody>      
 <?php 
 $sql = "SELECT * FROM bugs";
$result = mysqli_query($database,$sql) or die(mysqli_error($database));
while($bugs = mysqli_fetch_array($result)){ 
 ?>
<tr>
	<td><?php echo $bugs['name'];?></td>
    <td><a href="mailto:<?php echo $bugs['email'];?>"><?php echo $bugs['email'];?></a></td>
    <td><?php echo $bugs['type'];?></td>
    <td><a href="#myModal<?php echo $bugs['bug_id'];?>" data-toggle="modal" class="btn btn-success btn-sm">Leer</a></td>
 <div class="modal fade" id="myModal<?php echo $bugs['bug_id'];?>" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content"  style="background-image:url(assets/images/bg-1.jpg);">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Message from <?php echo $bugs['name'];?> - <?php echo $bugs['type'];?></h4>
        </div>
        <div class="modal-body">
          <?php echo $bugs['message'];?>
        </div>
        <div class="modal-footer">
          <a href="components/del_bugs.php?delete=<?php echo $bugs['bug_id'];?>" class="btn btn-danger" onclick="return confirm('are you sure?')"/>Delete</a>
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>   
    <td><a href="components/del_bugs.php?delete=<?php echo $bugs['bug_id'];?>" class="btn btn-danger btn-xs" onclick="return confirm('are you sure?')"/>Delete</a></td>    


</tr>
<?php }?>
 </tbody>    
</table>
<?php } }?>
  </div>
   </div>