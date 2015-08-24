<script src="//tinymce.cachefly.net/4.2/tinymce.min.js"></script>
<?php          
    $sql = "SELECT * FROM rules";
    $result = mysqli_query($database,$sql) or die(mysqli_error($database)); 
    $rules = mysqli_fetch_array($result);
?>         
    <!-- Tab panes -->
    <div class="tab-content">
        <div class="tab-pane fade in active" id="general">         
            <div class="col-md-12">

                <form action="components/update-rules.php" method="post" enctype="multipart/form-data" id="UploadForm">                    
                    <input type="hidden"  name="rules_id" value="<?php echo $rules['rules_id'];?>"/>
    			   <input type="hidden" name="user_username" value="<?php echo $_SESSION['user_username'];?>"/>
                    <textarea id="post_body" class="form-control" name="rule_txt" value="" style="height:300px;"><?php echo $rules['rule_txt'];?></textarea>

               
    
      	  </div>
        </div>
    </div>
<br>
    <div class="submit">
        <center>
            <button class="btn btn-primary ladda-button" data-style="zoom-in" type="submit"  id="SubmitButton" value="Upload" />Edit rules</button>
        </center>
    </div>
</form>

<script>
tinymce.init({
    selector: "#post_body",
    theme: "modern",
    height: 300,
    plugins: [
         "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
         "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
         "save table contextmenu directionality emoticons template paste textcolor"
   ],
   content_css: "css/content.css",
   toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons", 
   style_formats: [
        {title: 'Bold text', inline: 'b'},
        {title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
        {title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
        {title: 'Example 1', inline: 'span', classes: 'example1'},
        {title: 'Example 2', inline: 'span', classes: 'example2'},
        {title: 'Table styles'},
        {title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
    ]
 }); 
</script>


     
