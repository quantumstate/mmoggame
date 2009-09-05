<?php include('ingamehead.php');
$query="SELECT `alliance` FROM `players` WHERE `username`='$username'";
$result=mysql_query($query);
$playeralliance=mysql_result($result,0); 
if (isset($_GET['name'])){
$alliance=$_GET['name'];
}else{
$alliance=$playeralliance;
}

$query="SELECT * FROM `alliance` WHERE `name`='$alliance'";
$result=mysql_query($query);
$allianceresult=mysql_fetch_array($result);
?>

<h1><?php echo $alliance;?></h1>
<?php

if ($playeralliance==$alliance){
?>
<a href="alliance.php">Overview</a> | 
<a href="allianceoptions.php">Options</a>
<br/><br/>
<?php
}
?>
<table width="90%" cellspacing="0" border="1">
	<tr>
		<th width="50%">Name</th>
		<td><?php echo $alliance;?></td>
	</tr>
	<tr>
		<th>Rank</th>
		<td><?php echo $allianceresult['rank'];?></td>
	</tr>
	<?php
	$tmp=trim($allianceresult['positions'],'|');
	$positions=explode('|',$tmp);
	foreach ($positions as $position){
		if(isset($t)){
			unset($t);
			?>
			<td>
			<?php echo "<a href=\"player.php?user=$position\">$position</a>";?>
			</td>
			</tr>
			<?php
		}else{
			$t='h';
			?>
			<tr>
			<td>
			<?php echo $position;?>
			</td>
			<?php
		}
	}
	?>
</table><br/>
<?php echo $allianceresult['description'];?>
<br/><br/>
<table width="90%" cellspacing="0" border="1">
	<tr>
		<th>Player</th>
		<th>Population</th>
	</tr>
	<?php
	$query="SELECT * FROM `players` WHERE `alliance`='$alliance' ORDER BY `pop` DESC";
	$result=mysql_query($query);
	while ($player=mysql_fetch_array($result)){
		echo "<tr>\r\n<td>\r\n<a href=\"player.php?user={$player['username']}\">{$player['username']}</a></td>\r\n<td>\r\n{$player['pop']}</td>\r\n</tr>\r\n";
	}
	?>	
</table>
</div>

<div id="right">
<?php include('stat.php'); ?>

<?php include('foot.php'); ?>