<?php include 'components/session-check-index.php' ?>
<?php require '_database/database.php'; ?>
<?php include 'controllers/base/head.php' ?>
<?php include 'controllers/navigation/index-before-login-navigation.php' ?>
 <style>
            body{
                background: linear-gradient( rgba(44, 38, 38, 0.45), rgba(0, 0, 0, 0.45) ), url("./imagenes/profileback.jpg")!important;
                background-repeat: no-repeat !important;
                background-attachment: fixed !important;
                background-size: cover !important;
                margin-top: 0px;
                display: block;
            }
        </style>
    <div id="headerwrap">
        <div class="container">
            <div class="row centered">
                    <div class="col-lg-12">
                    <h1>ClanWars</h1>
                    <h3>Plan your attack and win the war!</h3>
                    <br>
                    <div class="col-lg-2">
                    </div>
                    <div class="col-lg-8 form_corners" >
                        
<?php include 'controllers/form/registration-form.php' ?>

                   </div>
                    <div class="col-lg-2">
                    </div>
                	</div>
			</div>
        </div> <!--/ .container -->
    </div><!--/ #headerwrap -->
</body>    