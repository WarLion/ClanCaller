<?php include 'components/session-check-index.php' ?>
<?php require '_database/database.php'; ?>
<?php include 'controllers/base/head.php' ?>
<body background="imagenes/profileback.jpg">	
<?php include 'controllers/navigation/index-before-login-navigation.php' ?>
<section id="home" name="home"></section>
    <div id="headerwrap">
        <div class="container">
            <div class="row centered">
                    <div class="col-lg-12">
                    <h1>ClanWars<br>
                    <small>Plan your attack and win the war!</small></h1>
                    <br>
                    <div class="col-lg-2">
                    </div>
                    <div class="col-lg-8 form_corners" >
                    <form role="form" action="components/login-process.php" method="post" name="login">
                        <div class="form-group">
                        <label for="inputUsernameEmail">Username</label>
                        <input type="text" class="form-control" id="inputUsernameEmail" name="username" placeholder="Username">
                        </div>
                        <div class="form-group">
                        <label for="inputPassword">Password</label>
                        <input type="password" class="form-control" id="inputPassword" name="password" placeholder="Password">
                        </div>
                    <button type="submit" class="btn btn btn-primary ladda-button" data-style="zoom-in" value="Sign In" name="login_button">
                    Log In  
                    </button>
                    <a href="register.php" class="btn btn btn-primary ladda-button">Sign Up</a>
                    <div class="row  centered">
                    <br />
                    <h6><a href="forget.php">Forgot password?</a></h6>
                    </div>                    
                    </form>
                    </div>
                    <div class="col-lg-2">
                    </div>
                	</div>
                    
			</div>
        </div> <!--/ .container -->
    </div><!--/ #headerwrap -->
</body>   