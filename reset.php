<?php include 'components/session-check-index.php' ?>
<?php require '_database/database.php'; ?>
<?php include 'controllers/base/head.php' ?>
<body background="imagenes/profileback.jpg">	
<?php include 'controllers/navigation/index-before-login-navigation.php' ?>
<?php if(isset($_GET['action']))
{          
    if($_GET['action']=="reset")
    {
        $encrypt = $_GET['encrypt'];
        $query = "SELECT user_id FROM user where md5(90*13+user_id)='".$encrypt."'";
        $result = mysqli_query($database,$query);
        $Results = mysqli_fetch_array($result);
        if(count($Results)>=1)
        {
	 $message ='';
        }
        else
        {
            $message = '<br />Invalid key please try again. <a href="http://halo-clan.com/clanwars/forget.php">Forget Password?</a><br />';
        }
    }
}
if(isset($_GET['pass']))
{     
if($_GET['pass']=="x")
{
$message = '<h5 class="text-center" style="color:#F00;">password dont match</a><h5 />';
}
}
?>
    <div id="headerwrap">
        <div class="container">
        <form role="form" action="components/reset-process.php" method="post" name="login">
        <div class="row">
                    <div class="col-lg-12 text-center">
                    <h3>Reset your Password</h3>
                    <br>
                    <div class="col-lg-8 col-md-offset-2 form_corners" >
                    <div class="row">
                    <?php echo $message;?>
<div class="form-group">
    <div class="col-sm-12">
      <input type="password" class="form-control" id="password" name="password" placeholder="Enter new password">
    </div>
  </div>
  <br>
   <div class="form-group">
    <div class="col-sm-12">
      <input type="password" class="form-control" id="password2" name="password2" placeholder="Re-type new password" v>
      <input type="hidden" class="form-control" id="encrypy" name="encrypt" value="<?php echo $encrypt;?>">
    </div>
  </div>                    

                    </div>
                    <br>
                      <div class="row centered">      
                 <button type="submit" class="btn btn-primary ladda-button" data-style="zoom-in" value="Sign In" name="login_button">Reset Password</button>
                 </div>
                    </div>
                    
                 </div>
                    </form>
          </div>          
        </div> <!--/ .container -->
    </div><!--/ #headerwrap -->
</body>   