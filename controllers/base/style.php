<?php
    if (isset($_GET['user_username'])) {
        $user_username = $_GET['user_username'];
    }
    $sql = "SELECT * FROM user where user_username='$user_username'";
    $result = mysqli_query($database,$sql) or die(mysqli_error()); 
    $rws = mysqli_fetch_array($result);       
?>




