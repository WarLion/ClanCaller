<?php include 'components/session-check-index.php' ?>
<?php require '_database/database.php'; ?>
<?php include 'controllers/base/head.php' ?>
<body background="imagenes/profileback.jpg">	
<?php include 'controllers/navigation/index-before-login-navigation.php' ?>
    <div id="headerwrap">
        <div class="container">
        <form role="form" action="components/forgot-process.php" method="post" name="login">
        <div class="row">
                    <div class="col-lg-12 text-center">
                    <h3>Forgoten Password</h3>
                    <br>
                    <div class="col-lg-8 col-md-offset-2 form_corners" >
                    <div class="row">
                    <?php if ( isset($_GET['send'])) {?>
                      <div class="alert alert-success" role="alert">
                           A email was sent to you with your reset instruccion to get a new password.
                        </div>
                    <?php }?>  
                    <?php if ( isset($_GET['no_user'])) {?>
                      <div class="alert alert-danger" role="alert">
                           We cant find your Username!
                        </div>
                    <?php }?>                                        
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" class="form-control" name="username" placeholder="Username" required>
                        </div>
                    </div>
                    
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