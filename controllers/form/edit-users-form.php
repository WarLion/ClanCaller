    <!-- Nav tabs -->
    <!-- Tab panes -->
    <div class="tab-content">
        <div class="tab-pane fade in active">         
            <div class="col-md-6">                    
                <div class="panel panel-default">
                    <div class="panel-heading ">
						UserName
                    </div>
                    <div class="panel-body">
						<h2 class="user_title" style="font-size:22;"><?php echo $rws['user_username'];?></h2>
                    </div>
                </div>  
            </div>           
            <div class="col-md-6">  
                <div class="panel panel-default">
                    <div class="panel-heading">
						Title
                    </div>
                    <div class="panel-body">
                     <h1 class="user_title" style="font-size:22;">
                        <?php User_Title($rws['user_title']); ?>
                      </h1>
                    </div>
                </div>                                
             </div> 
			 <div class="col-md-6">  
                    <div class="panel-body">
                    
                    </div>
                </div> 
			 <div class="col-md-6">  
                    <div class="panel-body">
                    <form action="components/update-user.php?user_username=<?php echo $rws['user_username'];?>" method="post" enctype="multipart/form-data" id="UploadForm">
 					<label for="">Change Title</label>
                        <select name="user_title" class="form-control">
                            <option value="<?php echo $rws['user_title'];?>"><?php 
                        User_Title($rws['user_title']); ?></option>
                        	<option value="0">Banned</option>
                            <option value="1">awaiting approval</option>
                            <option value="2">Member</option>
                            <option value="3">Elder</option>
                            <option value="4">Co-Leader</option>
                           <?php  
						   
    $current_user = $_SESSION['user_username'];
    $sql = "SELECT * FROM user WHERE user_username='$current_user'";
    $result = mysqli_query($database,$sql);
    while($row = mysqli_fetch_array($result,MYSQLI_BOTH)) {
								   
						   $admin = $row['user_title'];
						   if ($admin == 5 || $admin == 6){
                        echo '<option value="5">Leader</option>';
						   
						   if($admin == 6){
                        echo '<option value="6">Web Admin</option>';
                        }}}?>
                            
                            
                        </select>
                    </div>
                </div>                                                
             
						
             
             
             
        </div>
    </div>
    <div class="submit">
        <center>
        <?php if($rws['user_title'] <= 4){?>
            <button class="btn btn-primary ladda-button" data-style="zoom-in" type="submit"  id="SubmitButton" value="Upload" />Edit <?php echo $rws['user_username'];?><?php echo $row['user_username'];?></button>
            </form> 
        </center> 
                 
            <?php 
				 if($rws['user_title'] <= 4){?>
<div class="text-right">                   
<form id="form1" action="components/delete-user.php" method="post">
<input type="hidden" name="user_username" value="<?php echo $rws['user_username'];?>"/>
<button class="btn btn-danger btn-xs" data-style="zoom-in" type="submit"  id="SubmitButton" value="Upload" onclick="return confirm('Are you sure?')">Delete <?php echo $rws['user_username'];?></button>
    <input type="hidden" name="user_username" value="<?php echo $rws['user_username'];?>"/>
</form>  
</div>          
            <?php } }?>

    </div>    
   