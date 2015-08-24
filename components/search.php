<?php
    require '../_database/database.php';
    session_start();
    $current_user=$_SESSION['user_username'];
    if($_POST){
        $q=$_POST['searchword'];
        $sql_res=mysqli_query($database,"select * from user where user_username like '%$q%' order by user_id LIMIT 5");
        //$result=  mysql_query($sql_res) or die(mysql_errno());
        $trws= mysqli_num_rows($sql_res);
        if($trws>0){
            while($row=mysqli_fetch_array($sql_res)){
            $fname=$row['user_username'];
            $user_username=$row['user_username'];
            $re_fname='<b>'.$q.'</b>';
            $final_fname = str_ireplace($q, $re_fname, $fname);
?>  
<a href="./profile.php?user_username=<?php echo $user_username; ?>">    
    <div class="display_box" align="left">
        <i class="fa fa-user"></i>
<?php echo $final_fname; ?>  
    </div>    
</a>
<?php
            }
        }
        else{
?>        
<div class="display_box" align="left">    
<?php echo "No results to show"; ?>
</div>
<?php   
        }
    }
    else{
    }
?>