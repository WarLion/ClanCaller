<!-- second call ----->
    <?PhP if($caller['user_username3']){?>
	<div class="col-xs-12 col-sm-6 col-md-3 col-lg-2 text-center">
		<?php if ($caller['user_username4'] == NULL){
				if ($caller['user_username3'] !== $current_user){
					if ($caller['user_username2'] !== $current_user){
						if ($caller['user_username1'] !== $current_user){
			?>

        
        <?php } } } }else{?>
            <ul class="list-unstyled">
                <li><strong>Called by</strong></li>
                <li><h4><?php echo $caller['user_username4'];?></h4></li>
         <?php    
		 $user_score = $caller['user_username4']; // change for # of calls      
         $sql_score = "SELECT * FROM score WHERE war_enemy = '$caller_enemy' && enemy_enemynumber = '$war_enemynumber' && user_username ='$user_score' LIMIT 1";
        $result_score = mysqli_query($database,$sql_score) or die(mysqli_error($database));
        while($score = mysqli_fetch_array($result_score)){ 
          ?>  
                    <li><a href="#myModal4<?php echo $i;?>" data-toggle="modal"><img src="imagenes/th/<?php echo $score['score'];?>.png" width="80" /></a></li>
          <!-- popup -->

<div class="modal fade bs-example-modal-sm" id="myModal4<?php echo $i;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Stars <?php echo $rws['war_enemy'];?> <?php echo $i;?></h4>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
          <div class="row">
			<div class="col-md-6">
            	 <div class="row">
                 <label for=""><?php echo $score['user_username'];?>`s attack plan</label>	
                 	<div class="col-md-12" style="padding-bottom:10;">
            			<a href="<?php echo $score['plan'];?>"><img src="<?php echo $score['plan'];?>" height="95" class="img-thumbnail"/></a>
                    </div>
                  </div> 
                    <?php if ($score['favattack']){?>
            	 <div class="row">
                 	<div class="col-md-12">
            			 <img src="imagenes/troops/attacks/<?php echo $score['favattack'];?>.png" width="120" />
                    </div>
                  </div>
                  <?php }?>                 
            </div>
            	 
			<div class="col-md-6"> 	
            	<div class="form-group float-label-control">

                   <input type="image" src="imagenes/th/0.png" width="120" />

                   <input type="image" src="imagenes/th/1.png" width="120" />
 
                   <input type="image" src="imagenes/th/2.png" width="120" />

                   <input type="image" src="imagenes/th/3.png" width="120" />

                </div>
        	</div>
          </div>
        </div>        
        

      </div>
    </div>
  </div>
</div>
 <!--   popup -->
          
    <?php }?>            

         
        <?php  }?>   
	</div>
    <?php }?>
     <!---end second call ---> 