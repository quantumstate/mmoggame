<?php include('ingamehead.php'); ?>
<?php
if (isset($_GET['x'])){
$x=$_GET['x'];
$y=$_GET['y'];
}else{
$query="SELECT `position` FROM `players` WHERE `username`='$username'";
$result=mysql_query($query);
$result=mysql_result($result,0);
$result=explode(',',$result);
$y=$result[1];
$x=$result[0];
if ($y==''){
$y=0;
$x=0;
}
}
if ($x < -7){
$x=-7;
}
if ($x>7){
$x=7;
}
if ($y<-7){
$y=-7;
}
if ($y>7){
$y=7;
}
?>

<h1>Map<?php echo "($x,$y)";?></h1>
<p id="desc" style="position:absolute;top:265px;left:560px;"><?php 
$origtext='<table width=\\\'200px\\\' border=\\\'1\\\'><tr><th width=\\\'80px\\\'>Town</th><td>';
$origtext.='-</td></tr><tr><th>Population</th><td>-</td></tr><tr><th>Alliance</th><td>-</td></tr>';
$origtext.="<th>Position</th><td>-</td></tr></table>";
?></p>
<script type="text/javascript">
writeText('<?php echo $origtext; ?>')
</script>
<div style="position:absolute;top:261px;left:164px; width:500px;">
<?php
for ($j=$y-3;$j<=$y+3;$j++){
for ($i=$x-3;$i<=$x+3;$i++){

	$query="SELECT `terrain` FROM `map` WHERE `x`=$i AND `y`=$j";
	$result=mysql_query($query);
	$terrain=mysql_result($result,0);
	$writetext='<table width=\\\'200px\\\' border=\\\'1\\\'><tr><th width=\\\'80px\\\'>Town</th><td>';
	if ($terrain=='v'){
		$query="SELECT `player` FROM `map` WHERE `x`=$i AND `y`=$j";
		$result=mysql_query($query);
		$player=mysql_result($result,0);
		$writetext.=$player.'</td></tr>';
		$query="SELECT `resources` FROM `players` WHERE `username`='$player'";
		$result=mysql_query($query);
		if (mysql_num_rows($result)>0){
		$result=mysql_result($result,0);
		list($wood,$woodlimit,$stone,$stonelimit,$bronze,$bronzelimit,$wheat,$wheatlimit,$coin,$coinlimit,$pop,$poplimit)=explode('|',$result);
		$writetext.="<tr><th>Population</th><td>$pop</td></tr>";
		$query="SELECT `alliance` FROM `players` WHERE `username`='$player'";
		$result=mysql_query($query);
		$alliance=mysql_result($result,0);
		if ($alliance==''){$alliance='-';}
		$writetext.="<tr><th>Alliance</th><td>$alliance</td></tr>";
		$query="SELECT `alliance` FROM `players` WHERE `username`='$username'";
		$result=mysql_query($query);
		$myalliance=mysql_result($result,0);
		$terrain='ev';
		if ($alliance==$myalliance){
			$terrain='av';
		}
		if ($player==$username){
			$terrain='mv';
		}
		}else{
			$writetext.='<tr><th>Population</th><td>Dead</td></tr><tr><th>Alliance</th><td>-</td></tr>';
		}
	}else{
		$writetext.='-</td></tr><tr><th>Population</th><td>-</td></tr><tr><th>Alliance</th><td>-</td></tr>';
	}
	$writetext.="<th>Position</th><td>$i,$j</td></tr></table>";
	if ($player!=''){echo "<a href=\"player.php?user=$player\">";}
	echo "<img src=\"map/$terrain.gif\" onMouseOver=\"writeText('$writetext')\" style=\"padding:0px;border:0;\">";
	if ($player!=''){echo '</a>';}
	$player='';
}
echo '<br/>';
}
?>
<br/>
</div>
<a href="map.php?x=<?php echo "$x&y=".($y-1);?>"><img src="map/uarrow.gif" alt="move map up" style="border-width:0px;position:absolute;top:235px;left:312px;"/></a>
<a href="map.php?x=<?php echo "$x&y=".($y+1);?>"><img src="map/darrow.gif" alt="move map up" style="border-width:0px;position:absolute;top:611px;left:312px;"/></a>
<a href="map.php?x=<?php echo ($x-1)."&y=$y";?>"><img src="map/larrow.gif" alt="move map up" style="border-width:0px;position:absolute;top:409px;left:138px;"/></a>
<a href="map.php?x=<?php echo ($x+1)."&y=$y";?>"><img src="map/rarrow.gif" alt="move map up" style="border-width:0px;position:absolute;top:409px;left:511px;"/></a>
</div>

<div id="right">
<?php include('stat.php'); ?>

<?php include('foot.php'); ?>