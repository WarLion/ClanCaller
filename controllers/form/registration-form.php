                    <form class="form col-md-12 center-block" action="components/registration.php" method="post" autocomplete="off">
                        <div class="row">     
                            <div class="col-lg-12" style="z-index: 9;">
                                <div class="form-group">
                                    <input type="text" class="form-control input-lg" placeholder="First Name" name="user_firstname" required>
                                </div>
                            </div>
                        </div>
                     <div class="row">     
                         <div class="col-lg-12">
                            <div class="form-group">
                                <input type="email" class="form-control input-lg" placeholder="Email Address" name="user_email">
                                <label style="font-size:12px;">*optional</label>
                            </div>
                         </div>
                     </div>
                     <div class="row">   
                         <div class="col-lg-12">
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="username" class="form-control input-lg" placeholder="username" name="user_username" id="user_username" required> 
                                    <span class="input-group-addon" id="status"></span>
                                </div>
                             </div>
                            </div>     
                        </div>
                        <div class="row">     
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <input type="password" class="form-control input-lg" placeholder="pasword" name="user_password" required>
                                </div>
                            </div>
                        </div>
                         <div class="row">    
                            <div class="col-lg-12">
				<div class="form-group float-label-control">
                    <label for="">Your TownHall Lv</label>
                        <div class="cc-selector-2">
                            <input id="th8" type="radio" name="user_th" value="th8" style="display:none" />
                            <label class="favattack-cc th8" for="th8"></label>
                            <input id="th9" type="radio" name="user_th" value="th9" style="display:none" />
                            <label class="favattack-cc th9"for="th9"></label>
                            <input id="th10" type="radio" name="user_th" value="th10"  style="display:none"/>
                            <label class="favattack-cc th10"for="th10"></label>      
                        </div>             
                </div> 
                            </div>
                        </div>                       
                        <div class="row">    
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <button class="btn btn-primary ladda-button" data-style="zoom-in" type="submit"  id="SubmitButton" value="Upload" style="float:left;" name="signup_button"/>Register</button>
                                </div>
                            </div>
                        </div>                        
                    </form>