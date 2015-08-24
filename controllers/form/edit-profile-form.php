<form action="components/update-profile.php" method="post" enctype="multipart/form-data" id="UploadForm">
    <!-- Nav tabs -->
    <ul class="nav nav-tabs">
      <li class="active"><a href="#general" data-toggle="tab">General</a></li>
      <li><a href="#personal" data-toggle="tab">Game Data</a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
        <div class="tab-pane fade in active" id="general">         
            <div class="col-md-6">
                <div class="form-group float-label-control">                      
                    <label for="">First Name</label>
                    <input type="text" class="form-control" placeholder="<?php echo $rws['user_firstname'];?>" name="user_firstname" value="<?php echo $rws['user_firstname'];?>">
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
                    <a href="profile.php?user_username=<?php echo $rws['user_username'];?>">        
                        <div class="input-group">
                            <span class="input-group-addon">Profile</span>
                            <fieldset disabled> 
                                <input type="text" class="form-control" placeholder="<?php echo $rws['user_username'];?>" name="user_username" value="<?php echo $rws['user_username'];?>" id="disabledTextInput" autocomplete="off">
                            </fieldset>  
                        </div>
                    </a>
                </div>
                <div class="form-group float-label-control">
                    <label for="">Password</label>
                    <input type="password" class="form-control" placeholder="<?php echo $rws['user_password'];?>" name="user_password" value="<?php echo $rws['user_password'];?>">
                </div>
                <div class="form-group float-label-control">
                    <label for="">Email</label> 
                    <input type="text" class="form-control" placeholder="<?php echo $rws['user_email'];?>" name="user_email" value="<?php echo $rws['user_email'];?>">
                </div>  
            </div>
        </div>
        <div class="tab-pane fade" id="personal">
            <div class="col-md-6">
                <div class="form-group float-label-control">
                    <label for="">Favorite attack</label>
                        <div class="cc-selector-2">
                            <input type="hidden" name="user_favattack" value="<?php echo $rws['user_favattack'];?>"/>
                            <input id="goho" type="radio" name="user_favattack" value="goho" style="display:none" />
                            <label class="favattack-cc goho" for="goho"></label>
                            <input id="gohoc" type="radio" name="user_favattack" value="gohoc" style="display:none" />
                            <label class="favattack-cc gohoc"for="gohoc"></label>
                            <input id="lalo" type="radio" name="user_favattack" value="lalo"  style="display:none"/>
                            <label class="favattack-cc lalo"for="lalo"></label><br />
                            <input id="gowipe" type="radio" name="user_favattack" value="gowipe" style="display:none" />
                            <label class="favattack-cc gowipe" for="gowipe"></label>
                            <input id="gowiwi" type="radio" name="user_favattack" value="gowiwi" style="display:none" />
                            <label class="favattack-cc gowiwi"for="gowiwi"></label>
                            <input id="lalonion" type="radio" name="user_favattack" value="lalonion"  style="display:none"/>
                            <label class="favattack-cc lalonion" for="lalonion"></label>        
                        </div>             
                </div>
				<div class="form-group float-label-control">
                    <label for="">Your TownHall Lv</label>
                        <div class="cc-selector-2">
                            <input type="hidden" name="user_th" value="<?php echo $rws['user_th'];?>"/>
                            <input id="th8" type="radio" name="user_th" value="th8" style="display:none" />
                            <label class="favattack-cc th8" for="th8"></label>
                            <input id="th9" type="radio" name="user_th" value="th9" style="display:none" />
                            <label class="favattack-cc th9"for="th9"></label>
                            <input id="th10" type="radio" name="user_th" value="th10"  style="display:none"/>
                            <label class="favattack-cc th10"for="th10"></label>      
                        </div>             
                </div>                
            </div>
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

                <div class="col-md-12 column">
                <p class="text-center profile-title">Heroes Level</p>
                <hr>
                    <div class="col-md-6">
                   <input type="text" class="form-control" placeholder="<?php echo $rws['user_bk'];?>" name="user_bk" value="<?php echo $rws['user_bk'];?>"> 

                         <img src="imagenes/troops/heroes/king.png" width="100px" />                                   
                    </div>  
                    <?php 
                    if($rws['user_th'] == 'th9' || $rws['user_th'] == 'th10'){
                    ?>
                    <div class="col-md-6">
                         <input type="text" class="form-control" placeholder="<?php echo $rws['user_aq'];?>" name="user_aq" value="<?php echo $rws['user_aq'];?>"> 
                        <img src="imagenes/troops/heroes/queen.png" width="100px" />                                   
                    </div> 
                    <?php } else { ?>
                    <div class="col-md-6">
                         <input type="text" class="form-control"  value="Disable" id="disabledTextInput">  
                        <img src="imagenes/troops/heroes/noaq.png" width="100px" />                                   
                    </div> 				                   <?php } ?>                                                                                                                                        
                </div>   


            </div>
        </div>
    </div>     
    <br>
    <div class="submit">
        <center>
            <button class="btn btn-primary ladda-button" data-style="zoom-in" type="submit"  id="SubmitButton" value="Upload" />Save Your Profile</button>
        </center>
    </div>
</form>