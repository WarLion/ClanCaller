<?php include 'components/authentication.php' ?>     
<?php include 'components/session-check.php' ?>
<?php include 'controllers/base/head.php' ?>
<?php include 'controllers/base/style.php' ?>
<?php include 'controllers/navigation/first-navigation.php' ?> 
<?php 
$enemy = $_REQUEST['enemy'];  
$enemyname = $_REQUEST['enemyname']; 
$war_size = $_REQUEST['war_size'];
$war_warid = $_REQUEST['war_warid'];

?>
<!-- <script type="text/javascript" src="assets/js/canvas/react-with-addons.js"></script>
<script type="text/javascript" src="assets/js/canvas/literallycanvas.js"></script>
<link rel="stylesheet" type="text/css" href="assets/css/canvas/literallycanvas.css"/>-->
<div class="container" style="padding-top:50px;">
 <h1 class="text-center profile-name" style="margin-top:35;">plan your attack <br /><small> <?php echo $enemy;?>.- <?php echo $enemyname;?></small></h1>
    <div class="col-md-12 panel" style="border-radius: 20px; margin-top:20px; margin-bottom:20px; padding-bottom:20px; padding-top:20px;"> 
        <div class="col-md-12">
		<?php
            include '_database/database.php';
            $sql = "SELECT call_base FROM caller WHERE war_enemynumber='$enemy' && war_enemy = '$enemyname'";
            $result = mysqli_query($database,$sql) or die(mysqli_error($database));
            while($rws = mysqli_fetch_array($result)){ 
            ?>     
            

<!--<div class="literally localstorage" style="height:500;"></div>
<form class="controls export imgur-submit">
  <input class="btn btn-primary ladda-button" type="submit" data-action="export-as-png" value="Export as PNG" style="margin-top:10;">
    <input class="btn btn-success ladda-button" type="submit" data-action="upload-to-imgur" value="Upload to Imgur" style="margin-top:10;">
</form>


<script>
	var backgroundImage = new Image()
    backgroundImage.src = 'userfiles/screenshoots/<?php echo $rws['call_base'];?>';
	
    var lc = LC.init(document.getElementsByClassName('literally localstorage')[0],
	{imageURLPrefix: 'assets/img/',
		backgroundShapes: [
            LC.createShape(
              'Image', {x: 30, y: 30, image: backgroundImage, scale: 2}),
          ]
	});
	var localStorageKey = 'drawing-with-background'
    if (localStorage.getItem(localStorageKey)) {
      lc.loadSnapshotJSON(localStorage.getItem(localStorageKey));
    }
    lc.on('drawingChange', function() {
      localStorage.setItem(localStorageKey, lc.getSnapshotJSON());
    });	
	 $('.controls.export [data-action=export-as-png]').click(function(e) {
      e.preventDefault();
      window.open(lc.getImage().toDataURL());
    });
    $('[data-action=upload-to-imgur]').click(function(e) {
      e.preventDefault();

      $('.imgur-submit').html('Uploading...')

      // this is all standard Imgur API; only LC-specific thing is the image
      // data argument;
      $.ajax({
        url: 'https://api.imgur.com/3/image',
        type: 'POST',
        headers: {
          // Your application gets an imgurClientId from Imgur
          Authorization: 'Client-ID 2ea626172f0cb66',
          Accept: 'application/json'
        },
        data: {
          // convert the image data to base64
          image:  lc.canvasForExport().toDataURL().split(',')[1],
          type: 'base64'
        },
        success: function(result) {
          var url = 'http://i.imgur.com/' + result.data.id + '.png';
          $('.imgur-submit').html("<a href='" + url + "' target='_blank'>" + url + "</a>");
        },
      });
    });
</script>-->
<div class="col-md-6">

             <form action="components/update-planner.php" method="post" enctype="multipart/form-data" id="UploadForm">
            <input type="hidden" name="enemy" value="<?php echo $enemy;?>"/>
            <input type="hidden" name="enemyname" value="<?php echo $enemyname;?>"/>
            <input type="hidden" name="war_size" value="<?php echo $war_size;?>"/>
            <input type="hidden" name="war_warid" value="<?php echo $war_warid;?>"/>       
                <?php 
				
                    $sql2 = "SELECT * FROM caller WHERE war_enemy = '$enemyname' && war_enemynumber = '$enemy'";
                    $result2 = mysqli_query($database,$sql2) or die(mysqli_error($database));
                    while($rws2 = mysqli_fetch_array($result2)){
						?>				
                <img src="userfiles/screenshoots/<?php echo $rws2['call_base'];?>" class="img-responsive">
</div>
<div class="col-md-6">                
<div class="form-group float-label-control">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<label data-toggle="tooltip" title="Here you can upload a plan attack of the enemy base!">Your Plan Attack <span class="badge"><span class="fa fa-info"></span></span></label>

<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
});
</script>
    <input name="ImageFile" type="file" id="uploadFile"/>
 </div>   
        <div class="shortpreview" id="uploadImagePreview">
             <div id="imagePreview"></div>
        </div>
<?php }?> 
</div>
           <div class="row">
           <div class="col-md-12 text-center">              
            <button class="btn btn-success btn-primary" data-style="zoom-in" type="submit"  id="SubmitButton" value="Upload" />save it</button>
            </div>
            </div>
            </form>

<?php 
 }?>
</div></div></div>