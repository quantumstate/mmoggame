<?php include('ingamehead.php'); 
$player=$_GET['user'];
$query="SELECT * FROM `players` WHERE `username`='$player'";

$player=mysql_query($query);
$player=mysql_fetch_array($player);

?>

<h1><?php echo $player['username'];?>'s town (<?php echo $player['position'];?>)</h1>
<?php
$query="SELECT `resources` FROM `players` WHERE `username` = '{$player['username']}'";
$result=mysql_query($query);
$result=mysql_result($result,0);
list($wood,$woodlimit,$stone,$stonelimit,$bronze,$bronzelimit,$wheat,$wheatlimit,$coin,$coinlimit,$pop,$poplimit)=explode('|',$result);

echo "<b>Population</b>: $pop<br/>";
switch ($player['civ']){
case 1:
	$civ='Phonecian';
break;
case 2:
	$civ='Carthaginian';
break;
case 3:
	$civ='Greek';
break;
case 4:
	$civ='Egyptian';
break;
} 
echo "<b>Civilisation</b>: $civ<br/>";
if ($player['alliance']==''){
	echo "<b>Alliance</b>: {$player['alliance']}<br/>";
}else{
	echo "<b>Alliance</b>: <a href=\"alliance.php?name={$player['alliance']}\">{$player['alliance']}</a><br/>";
}
echo "<b>Rank</b>: {$player['rank']}<br/>";
?>
<br/>
<br/>
<b>Options</b><br/>
<a href="map.php?x=<?php
$coords=explode(',',$player['position']);
echo $coords[0].'&y='.$coords[1];
?>">Centre Map</a><br/>
<a href="writeigm.php?to=<?php echo $player['username'];?>">Send message</a><br/>
<a href="mg.php?to=<?php echo $player['username'];?>">Send resources</a><br/>
<?php

$query="SELECT `alliance` FROM `players` WHERE `username`='$username'";
$result=mysql_query($query);

if (($player['alliance'] != mysql_result($result,0)) OR ($player['alliance'] == '')){
?>
<a href="attack.php?to=<?php echo $player['username'];?>">Attack Player</a>
<?php
}
?>
</div>

<div id="right">
<?php include('stat.php'); ?>

<?php include('foot.php'); ?>