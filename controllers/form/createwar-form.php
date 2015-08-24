<form action="components/create-clanwar.php" method="post" enctype="multipart/form-data" id="UploadForm">

        <div class="col-md-12">
        	<div class="col-md-4">
            </div>
            <div class="col-md-4">
                  <div class="form-group float-label-control">  
            		<input name="war_enemy" id="enemy_clan_name" class="form-control" type="text" placeholder="Enemy Clan Name"></input>
                    <input name="war_warid" type="hidden"></input>
                  </div>  
                  <h4 class="text-center profile-text profile-name">Size</h4>
                <hr>
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