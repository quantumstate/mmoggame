<?php include('ingamehead.php'); 
if ($_GET['player']!=''){
	$playername=$_GET['player'];
	$query="SELECT `rank` FROM `players` WHERE `username`='$playername'";
	#echo $query;
	$result=mysql_query($query);
	$rank=mysql_result($result,0);
	$start=$rank-11;
}else{
	if ($_GET['start']!=''){
		$start=$_GET['start']-11;
	}else{
		$query="SELECT `rank` FROM `players` WHERE `username`='$username'";
		#echo $query;
		$result=mysql_query($query);
		$rank=mysql_result($result,0);
		$start=$rank-11;
	}
}
if ($start<0){
	$start=0;
}
?>

<h1>Statistics</h1>
<table width="95%" border="1px" cellpadding="0" cellspacing="0">
<tr>
	<th width="11%">Rank</th>
	<th width="36%">Player</th>
	<th width="33%">Alliance</th>
	<th width="20%">Population</th>
</tr>
<?php
$end=$start+20;
$query="SELECT * FROM `players` ORDER BY `rank` ASC LIMIT $start,$end";
#echo $query;
$result=mysql_query($query);
$i=0;
while ($player=mysql_fetch_array($result)){
	$i++;
	if ($player['username']==$username || $player['username']==$playername || $player['rank']==$_GET['start']){
		$highlight=' class="highlight"';
	}else{
		$highlight=' class="normal"';
	}
	echo '<tr'.$highlight.'><td>'.($start+$i).'</td>';
	echo '<td><a href="player.php?user='.$player['username'].'">'.$player['username'].'</a></td>';
	if ($player['alliance']==''){
		echo "<td>{$player['alliance']}</td>";
	}else{
		echo "<td><a href=\"alliance.php?name={$player['alliance']}\">{$player['alliance']}</a></td>";
	}
	echo '<td>'.$player['pop'].'</td></tr>';	
}
?>
</table><br/>
<form action="statistics.php" method="get">
Find: Rank<input type="text" name="start" style="padding:0;" value="<?php echo $start;?>" size="5" />
Player<input type="text" name="player" style="padding:0;" />
<a href="statistics.php?start=<?php echo $start-9;?>">&lt;&lt; back </a>|
<a href="statistics.php?start=<?php echo $start+31;?>">&gt;&gt; forward</a>
<input type="submit" value="Search" />
</form>
</div>

<div id="right">
<?php include('stat.php'); ?>

<?php include('foot.php'); ?>