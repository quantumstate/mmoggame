<?php
include('dbinfo.php');
$query="SELECT * FROM `players` ORDER BY `pop` DESC";
$result=mysql_query($query);
$i=0;
while ($player=mysql_fetch_array($result)){
	$i++;
	$query="UPDATE `players` SET `rank`='$i' WHERE `id`='{$player['id']}'";
	$res=mysql_query($query);
}
?>
