<?php
include '../_database/database.php';
if($_POST['id'])
{
$id=$_POST['id'];
$ww=$_POST['ww'];
$wl=$_POST['wl'];
$wt=$_POST['wt'];
$sql = "update clan_info set war_won='$ww',war_lost='$wl',war_tie='$wt' where id='$id'";
mysqli_query($database,$sql)or die(mysqli_error($database));
}
?>