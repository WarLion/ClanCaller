<form action="components/update-profile.php" method="post" enctype="multipart/form-data" id="UploadForm">
    <!-- Nav tabs -->
    <ul class="nav nav-tabs nav-justified">
      <li class="active"><a href="#general" data-toggle="tab"> <h4><strong>General</strong></h4></a></li>
      <li><a href="#personal" data-toggle="tab"> <h4><strong>Game Data</strong></h4></a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
        <div class="tab-pane fade in active" id="general">         
            <div class="col-md-6">
                <div class="form-group float-label-control">                      
                    <label for="">First Name</label>
                    <input type="text" class="form-control" placeholder="<?php echo $rws['user_firstname'];?>" name="user_firstname" value="<?php echo $rws['user_firstname'];?>" >
                </div>
                <div class="form-group float-label-control">
                    <label for="">Avatar</label>
                    <input name="ImageFile" type="file" id="uploadFile"/>
                    <div class="col-md-6">
                        <div class="shortpreview">
                            <label for="">Previous Avatar </label>
                            <br> 
                            <img src="userfiles/avatars/<?php echo $rws['user_avatar'];?>" class="img-responsive">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="shortpreview" id="uploadImagePreview">
                            <label for="">Current Uploaded Avatar </label>
                            <br> 
                            <div id="imagePreview"></div>
                        </div>
                    </div>
                </div>
            </div>  
            <div class="col-md-6">
                <label for="">Username</label>
                <div class="form-group float-label-control">      
                                <input type="text" class="form-control" placeholder="<?php echo $rws['user_username'];?>" name="user_username" value="<?php echo $rws['user_username'];?>" disabled>
                </div>
                <div class="form-group float-label-control">
                    <label for="">Password</label>
                    <input type="hidden" name="user_password" value="<?php echo $rws['user_password'];?>">
                    <input type="password" class="form-control"  name="user_password" value="">
                </div>
                <div class="form-group float-label-control">
                    <label for="">Email</label> 
                    <input type="text" class="form-control" placeholder="<?php echo $rws['user_email'];?>" name="user_email" value="<?php echo $rws['user_email'];?>">
                </div>  
                <div class="form-group float-label-control">
<?php
if ($rws['user_email_get'] == 2){
	$check = 'checked';
	}else{
		$check = '';
}?>
<input type="hidden" name="user_email_get" value="1"/>
<input type="checkbox" name="user_email_get" value="2" <?php echo $check;?>/> Do you want your email to be secret?

 
                </div>                  
            </div>
        </div>
        <div class="tab-pane fade" id="personal">
            <div class="col-md-6">
                <div class="form-group float-label-control">
                    <label for="">Favorite attack</label>
                        <div class="cc-selector-2">
                        	<div class="col-xs-4 col-sm-4 col-md-4">
                            <input type="hidden" name="user_favattack" value="<?php echo $rws['user_favattack'];?>"/>
                            <?PHP if($rws['user_favattack'] == 'goho'){?>
                            <img src="imagenes/troops/attacks/goho.png" width="120" class="img-responsive"/>
                            <?php }else{?>
                            <input id="goho" type="radio" name="user_favattack" value="goho" style="display:none" />
                            <label class="favattack-cc goho" for="goho"></label>
                            <?php }?>
                            </div>
                            <div class="col-xs-4 col-sm-4 col-md-4">
                            <?PHP if($rws['user_favattack'] == 'gohoc'){?>
                            <img src="imagenes/troops/attacks/gohoc.png" width="120" class="img-responsive"/>
                            <?php }else{?>                            
                            <input id="gohoc" type="radio" name="user_favattack" value="gohoc" style="display:none" />
                            <label class="favattack-cc gohoc"for="gohoc"></label>
                            <?php }?>
                            </div>
                            <div class="col-xs-4 col-sm-4 col-md-4">
                            <?PHP if($rws['user_favattack'] == 'golalo'){?>
                            <img src="imagenes/troops/attacks/golalo.png" width="120" class="img-responsive"/>
                            <?php }else{?>                            
                            <input id="lalo" type="radio" name="user_favattack" value="golalo"  style="display:none"/>
                            <label class="favattack-cc lalo"for="lalo"></label><br />
                            <?php }?>
                            </div>
                            <div class="row"></div>
                            <div class="col-xs-4 col-sm-4 col-md-4">
                            <?PHP if($rws['user_favattack'] == 'gowipe'){?>
                            <img src="imagenes/troops/attacks/gowipe.png" width="120" class="img-responsive"/>
                            <?php }else{?>                            
                            <input id="gowipe" type="radio" name="user_favattack" value="gowipe" style="display:none" />
                            <label class="favattack-cc gowipe" for="gowipe"></label>
                            <?php }?>
                            </div>
                            <div class="col-xs-4 col-sm-4 col-md-4">
                            <?PHP if($rws['user_favattack'] == 'gowiwi'){?>
                            <img src="imagenes/troops/attacks/gowiwi.png" width="120" class="img-responsive"/>
                            <?php }else{?>                            
                            <input id="gowiwi" type="radio" name="user_favattack" value="gowiwi" style="display:none" />
                            <label class="favattack-cc gowiwi"for="gowiwi"></label>
                            <?php }?>
                            </div>
                            <div class="col-xs-4 col-sm-4 col-md-4">
                            <?PHP if($rws['user_favattack'] == 'lalonion'){?>
                            <img src="imagenes/troops/attacks/lalonion.png" width="120" class="img-responsive"/>
                            <?php }else{?>                            
                            <input id="lalonion" type="radio" name="user_favattack" value="lalonion"  style="display:none"/>
                            <label class="favattack-cc lalonion" for="lalonion"></label> 
                            <?php }?>
                            </div>       
                        </div>             
                </div>
                <div class="row">
				<div class="form-group float-label-control">
                    <label for="">Your TownHall Lv</label>
                        <div class="cc-selector-2">
                        	<div class="col-xs-6 col-sm-3 col-md-3">
                            <input type="hidden" name="user_th" value="<?php echo $rws['user_th'];?>"/>
                          <?PHP if($rws['user_th'] == 'th7'){?>
                          	<img src="imagenes/th/th7.png" width="100"class="img-responsive" />
                            <?php }else{?>
                            <input id="th7" type="radio" name="user_th" value="th7" style="display:none" />
                            <label class="favattack-cc th7" for="th7"></label>
                             <?php }?>
                             </div>
                        	<div class="col-xs-6 col-sm-3 col-md-3">
                            <input type="hidden" name="user_th" value="<?php echo $rws['user_th'];?>"/>
                          <?PHP if($rws['user_th'] == 'th8'){?>
                          	<img src="imagenes/th/th8.png" width="100"class="img-responsive" />
                            <?php }else{?>
                            <input id="th8" type="radio" name="user_th" value="th8" style="display:none" />
                            <label class="favattack-cc th8" for="th8"></label>
                             <?php }?>
                             </div>
                             <div class="col-xs-6 col-sm-3 col-md-3">
                          <?PHP if($rws['user_th'] == 'th9'){?>
                          	<img src="imagenes/th/th9.png" width="100" class="img-responsive"/>
                            <?php }else{?>
                            <input id="th9" type="radio" name="user_th" value="th9" style="display:none" />
                            <label class="favattack-cc th9" for="th9"></label>
                             <?php }?>
                             </div>
                             <div class="col-xs-6 col-sm-3 col-md-3">
                          <?PHP if($rws['user_th'] == 'th10'){?>
                          	<img src="imagenes/th/th10.png" width="100" class="img-responsive" />
                            <?php }else{?>
                            <input id="th10" type="radio" name="user_th" value="th10" style="display:none" />
                            <label class="favattack-cc th10" for="th10"></label>
                             <?php }?>  
                             </div>  
                        </div>             
                </div>                
            </div>
            </div>
            <div class="col-md-6 text-center">
                <div class="form-group float-label-control">
            <label for="">Your Slogan</label>
                 <input type="text" class="form-control" placeholder="<?php echo $rws['user_slogan'];?>" name="user_slogan" value="<?php echo $rws['user_slogan'];?>"> 
             <hr />           
            </div> 
            </div>
                        
            <div class="col-md-6">
            	<div class="col-md-6">
                <div class="form-group float-label-control">
                    <label for="">Favorite Troop</label>
                        <select name="user_favtroop" class="form-control">
                            <option value="<?php echo $rws['user_favtroop'];?>"><?php echo $rws['user_favtroop'];?></option>
                            <option value="barb">Barbarian</option>
                            <option value="arch">Archer</option>
                            <option value="opel">Goblin</option>
                            <option value="giant">Giant</option>
                            <option value="wb">Wall Breaker</option>
                            <option value="loon">Balloon</option>
                            <option value="wiz">Wizard</option>
                            <option value="healer">Healer</option>
                            <option value="dragon">Dragon</option>
                            <option value="pekka">P.E.K.K.A</option>
                            <option value="minion">Minion</option>
                            <option value="hog">Hog Rider</option>
                            <option value="valk">Valkyrie</option>
                            <option value="golem">Golem</option>
                            <option value="witch">Witch</option>
                            <option value="lava">Lava Hound</option>
                        </select>
                </div>
                </div>
               <div class="col-md-6 text-center">
                <img src="imagenes/troops/troops/<?php echo $rws['user_favtroop'];?>.png" height="80"/>
                </div>

                <div class="col-md-12 text-center">
                <p class="text-center profile-title">Heroes Level</p>
                <hr>
                    <div class="col-md-6 col-sm-6 col-xs-6 text-center">
                   <input type="text" class="form-control" placeholder="<?php echo $rws['user_bk'];?>" name="user_bk" value="<?php echo $rws['user_bk'];?>"> 

                         <img src="imagenes/troops/heroes/king.png" width="100px" />                                   
                    </div>  
                    <?php 
                    if($rws['user_th'] == 'th9' || $rws['user_th'] == 'th10'){
                    ?>
                    <div class="col-md-6 col-sm-6 col-xs-6 text-center">
                         <input type="text" class="form-control" placeholder="<?php echo $rws['user_aq'];?>" name="user_aq" value="<?php echo $rws['user_aq'];?>"> 
                        <img src="imagenes/troops/heroes/queen.png" width="100px" />                                   
                    </div> 
                    <?php } else { ?>
                    <div class="col-md-6 col-sm-6 col-xs-6 text-center">
                         <input type="text" class="form-control"  value="Disable" id="disabledTextInput">  
                        <img src="imagenes/troops/heroes/noaq.png" width="100px" />                                   
                    </div> 				                   <?php } ?>                                                                                                                                        
                </div>   


            </div>
        </div>
    </div>     
    <br />
    <br />
    <div class="col-md-12">
    <div class="submit">
    <center>
            <button class="btn btn-primary ladda-button" data-style="zoom-in" type="submit"  id="SubmitButton" value="Upload" />Save Your Profile</button>
            </center>
    </div>
    </div>
</form>