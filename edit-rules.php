<?php include 'components/authentication.php' ?>
<?php include 'components/session-check.php' ?>
<?php include 'controllers/base/head.php' ?>
<?php include 'controllers/base/style.php' ?> 	
<?php include 'controllers/navigation/first-navigation.php' ?>          
     <div class="container" style="padding-top:50px;">
    <h1 class="text-center profile-text profile-name">Edit Rules</h1>
	   <div class="no-gutter row"> 
           <div class="col-md-12">
               <div class="panel panel-default" id="sidebar">
                   <div class="panel-body">                     
<?php include 'controllers/form/edit-rules-form.php' ?>
                   </div>
               </div>
           </div>
        </div>
    </div>