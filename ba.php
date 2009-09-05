<?php include('ingamehead.php'); ?>

<h1>Barracks</h1>
<form action="train.php" method="post">
<table width="100%" cellspacing="0" border="1">
<tr><th width="25%">Unit</th><th width="45%">Cost</th><th width="18%">Number</th><th width="12%">Max</th></tr>
<?php
$query="SELECT * FROM `players` WHERE `username`='$username'";
$result=mysql_query($query);
$userresult=mysql_fetch_array($result);
$units=explode('|',$userresult['unitposs']);
foreach ($units as $unitabbr){

$query="SELECT * FROM `units` WHERE `abbr`='$unitabbr'";
$result=mysql_query($query);
$unit=mysql_fetch_array($result);
?>
<tr><td><a class="pop" href="#"><img src="units/<?php echo $unit['picture'].'" />';?><div class="cover"><div class="middle">
<?php
$query="SELECT * FROM `units` WHERE `id`='1'";
#$result=mysql_query($query);
#$unit=mysql_fetch_array($result);
echo '<h1>'.$unit['name'].'</h1>';
list($bldwood,$bldstone,$bldbronze,$bldwheat,$bldcoin)=explode('|',$unit['resources']);

$tmp=date('G',$unit['time']);
$tmp-=1;

echo '<b>Resources</b><br/><font color="black"><img src="images/wood.gif" alt="wood" style="margin-right:2px;" />'.$bldwood;
echo '  <img src="images/stone.gif" alt="stone" style="margin-right:2px;" />'.$bldstone;
echo '  <img src="images/bronze.gif" alt="bronze" style="margin-right:2px;" />'.$bldbronze;
echo '  <img src="images/wheat.gif" alt="wheat" style="margin-right:2px;" />'.$bldwheat;
echo '  <img src="images/coin.gif" alt="coin" style="margin-right:2px;" />'.$bldcoin;
echo '  <img src="images/pop.gif" alt="population" style="margin-right:2px;" />'.$unit['pop'];
echo '  <img src="images/time.gif" alt="build time" style="margin-right:2px;" />'.$tmp.date(':i:s',$unit['time']);

list($inf,$cav,$arch)=explode('|',$unit['attack']);
?>
<br/><br/>
<table width="48%" border="1" style="float:left; margin-right:12px;">
	<tr>
		<th colspan="3">Attack vs</th>
	</tr>
	<tr>
		<td>Infantry</td>
		<td>Archers</td>
		<td>Cavalry</td>
	</tr>
	<tr>
		<td><?php echo $inf;?></td>
		<td><?php echo $arch;?></td>
		<td><?php echo $cav;?></td>
	</tr>
</table>
<?php
list($inf,$cav,$arch)=explode('|',$unit['defence']);
?>
<table width="48%" border="1">
	<tr>
		<th colspan="3">Defence vs</th>
	</tr>
	<tr>
		<td>Infantry</td>
		<td>Archers</td>
		<td>Cavalry</td>
	</tr>
	<tr>
		<td><?php echo $inf;?></td>
		<td><?php echo $arch;?></td>
		<td><?php echo $cav;?></td>
	</tr>
</table>
<br/>
This unit can carry 
<?php
echo $unit['carry'].' resources.<br/><br/>'.$unit['description'];
?>
</font>
</div></div></a>

<?php echo $unit['name'];?></td><td align="center">

<?php
list($bldwood,$bldstone,$bldbronze,$bldwheat,$bldcoin)=explode('|',$unit['resources']);

$tmp=date('G',$unit['time']);
$tmp-=1;

echo '<img src="images/wood.gif" alt="wood" style="margin-right:2px;" />'.$bldwood;
echo '  <img src="images/stone.gif" alt="stone" style="margin-right:2px;" />'.$bldstone;
echo '  <img src="images/bronze.gif" alt="bronze" style="margin-right:2px;" />'.$bldbronze;
echo '  <img src="images/wheat.gif" alt="wheat" style="margin-right:2px;" />'.$bldwheat;
echo '  <img src="images/coin.gif" alt="coin" style="margin-right:2px;" />'.$bldcoin;
echo '<br/>  <img src="images/pop.gif" alt="population" style="margin-right:2px;" />'.$unit['pop'];
echo '  <img src="images/time.gif" alt="build time" style="margin-right:2px;" />'.$tmp.date(':i:s',$unit['time']);
?>
</td>
<td align="center"><input type="text" name="<?php echo $unit['abbr']; ?>" value="0" size="4" style="padding:0;"></td>
<td align="center">
<?php
$max=($wood-($wood%$bldwood))/$bldwood;
if ((($stone-($stone%$bldstone))/$bldstone)<$max){
$max=($stone-($stone%$bldstone))/$bldstone;
}
if ((($bronze-($bronze%$bldbronze))/$bldbronze)<$max){
$max=($bronze-($bronze%$bldbronze))/$bldbronze;
}
if ((($wheat-($wheat%$bldwheat))/$bldwheat)<$max){
$max=($wheat-($wheat%$bldwheat))/$bldwheat;
}
if ((($coin-($coin%$bldcoin))/$bldcoin)<$max){
$max=($coin-($coin%$bldcoin))/$bldcoin;
}
echo round($max);
?>
</td></tr>
<?php
}
?>
</table>
<br/>
<input type="submit" value="Train" />
</form>
<br/>
<br/>
<?php
if ($userresult['unitconstruction']!=''){
$build=explode('|',$userresult['unitconstruction']);
$switch='f';
?><b>Current Training</b><br/>
Next unit finished at: <?php 
$query="SELECT `time` FROM `unitqueue` WHERE `player`='$username'";
$result=mysql_query($query);
$time=mysql_result($result,0);
echo date("G:i:s",$time);
?>
<table width="90%"><tr><td><b>Unit</b></td><td><b>Number</b></td></tr><?php
foreach ($build as $unit){
	if ($switch=='f'){
		$switch='s';
		$query="SELECT * FROM `units` WHERE `abbr`='$unit'";
		$result=mysql_query($query);
		$result=mysql_fetch_array($result);
		echo '<tr><td><a href="#" class="pop"><img src="units/'.$result['picture'].'" alt="'.$result['name'].'" />';
		?>
		<div class="cover"><div class="middle">
		<?php
		$query="SELECT * FROM `units` WHERE `abbr`='$unit'";
		$resulto=mysql_query($query);
		$unit=mysql_fetch_array($resulto);
		echo '<h1>'.$unit['name'].'</h1>';
		list($bldwood,$bldstone,$bldbronze,$bldwheat,$bldcoin)=explode('|',$unit['resources']);
		
		$tmp=date('G',$unit['time']);
		$tmp-=1;
		
		echo '<b>Resources</b><br/><font color="black"><img src="images/wood.gif" alt="wood" style="margin-right:2px;" />'.$bldwood;
		echo '  <img src="images/stone.gif" alt="stone" style="margin-right:2px;" />'.$bldstone;
		echo '  <img src="images/bronze.gif" alt="bronze" style="margin-right:2px;" />'.$bldbronze;
		echo '  <img src="images/wheat.gif" alt="wheat" style="margin-right:2px;" />'.$bldwheat;
		echo '  <img src="images/coin.gif" alt="coin" style="margin-right:2px;" />'.$bldcoin;
		echo '  <img src="images/pop.gif" alt="population" style="margin-right:2px;" />'.$unit['pop'];
		echo '  <img src="images/time.gif" alt="build time" style="margin-right:2px;" />'.$tmp.date(':i:s',$unit['time']);
		
		list($inf,$cav,$arch)=explode('|',$unit['attack']);
		?>
		<br/><br/>
		<table width="48%" border="1" style="float:left; margin-right:12px;">
			<tr>
				<th colspan="3">Attack vs</th>
			</tr>
			<tr>
				<td>Infantry</td>
				<td>Archers</td>
				<td>Cavalry</td>
			</tr>
			<tr>
				<td><?php echo $inf;?></td>
				<td><?php echo $arch;?></td>
				<td><?php echo $cav;?></td>
			</tr>
		</table>
		<?php
		list($inf,$cav,$arch)=explode('|',$unit['defence']);
		?>
		<table width="48%" border="1">
			<tr>
				<th colspan="3">Defence vs</th>
			</tr>
			<tr>
				<td>Infantry</td>
				<td>Archers</td>
				<td>Cavalry</td>
			</tr>
			<tr>
				<td><?php echo $inf;?></td>
				<td><?php echo $arch;?></td>
				<td><?php echo $cav;?></td>
			</tr>
		</table>
		</font>
		<br/>
		<?php
		echo $unit['description'];
		?>
		</div></div></a>
		<?php
		
		echo $result['name'].' </td><td><b>';
	}else{
		echo $unit.'</b><br/></td></tr>';
		$switch='f';
	}
}

?>
</table>
<?php
}
?>
</div>

<div id="right">
<?php include('stat.php'); ?>
<?php include('unitstat.php');?>

<?php include('foot.php'); ?>