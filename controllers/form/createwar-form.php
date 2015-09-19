
<form action="components/create-clanwar.php" method="post" enctype="multipart/form-data" id="UploadForm">

        <div class="col-md-6 col-md-offset-3 panel" style="padding-top:15px; border-radius:25px; border:solid #999 2px;">
            <div class="col-md-10 col-md-offset-1">
                              <h4 class="text-center profile-text profile-name">Clan Name</h4>
                  <div class="form-group float-label-control">  
            		<input name="war_enemy" id="enemy_clan_name" class="form-control" type="text" placeholder="Enemy Clan Name" required="required"></input>
                    <input name="war_warid" type="hidden"></input>
                  </div>  
                  <hr>
                  <h4 class="text-center profile-text profile-name">Size</h4>
                   <div class="form-group float-label-control"> 
                        <select name="war_size" class="form-control">
                        <option value="50" selected>50 vs 50</option>
                        <option value="45">45 vs 45</option>
                        <option value="40">40 vs 40</option>
                        <option value="35">35 vs 35</option>
                        <option value="30">30 vs 30</option>
                        <option value="25">25 vs 25</option>
                        <option value="20">20 vs 20</option>
                        <option value="15">15 vs 15</option>
                        <option value="10">10 vs 10</option>
                        </select>
                    </div>  
                    <hr />
                  <h4 class="text-center profile-text profile-name">War Start in</h4>
                   <div class="form-inline text-center"> 
	<input  class="form-control" name="hours" step="1" min="0" max="23" value="23" style="width:60px" type="number">
	 hours and 
	<input  class="form-control" name="minutes" step="1" min="0" max="59" value="59" style="width:60px" type="number">
	 minutes.
                    </div>  
                    <hr />   
                  <h4 class="text-center profile-text profile-name">Timer for calls</h4>
                   <div class="form-inline text-center"> 
<input  class="form-control" name="call_timer" step="1" min="0" max="24" value="5" style="width:60px" type="number"> Hours
                    </div>  
                    <hr />                                      
                     <div class="form-group float-label-control"> 
                     <div class="submit">
                     <center>
        <button class="btn btn-primary ladda-button" data-style="zoom-in" type="submit"  id="SubmitButton" value="Upload" />Create War</button>
        </center>
    </div>
                     </div>  
			</div>
        </div> 

	
</form>
