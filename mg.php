<?php include('ingamehead.php'); ?>

<h1>Merchants Guild</h1>
Here you can send resources to other players.<br/>
<br/>
<?php
if ($_POST['confirmed']=='yes'){
	$vx=$_POST['x'];
	$vy=$_POST['y'];
	$fph=10;
	$query="SELECT `position` FROM `players` WHERE `username`='$username'";
	$result=mysql_query($query);
	list($mx,$my)=explode(',',mysql_result($result,0));
	$dist=sqrt((($mx-$vx)*($mx-$vx))+(($my-$vy)*($my-$vy)));
	$outhour=$dist/$fph;
	$time=round($outhour*3600)+time();
	$resources=$_POST['wood'].'|'.$_POST['stone'].'|'.$_POST['bronze'].'|'.$_POST['wheat'].'|'.$_POST['coin'];
	$query="INSERT INTO `trade` (`id` , `from` , `to` , `resources` , `time`) VALUES (NULL , '$username', '{$_POST['village']}', '$resources', '$time')";
	$resulta=mysql_query($query);
	
	$query="SELECT `resources` FROM `players` WHERE `username` = '$username'";
	$resulta=mysql_query($query);
	$resulta=mysql_result($resulta,0);
	list($wood,$woodlimit,$stone,$stonelimit,$bronze,$bronzelimit,$wheat,$wheatlimit,$coin,$coinlimit,$pop,$poplimit)=explode('|',$resulta);

	$wood-=$_POST['wood'];
	$stone-=$_POST['stone'];
	$bronze-=$_POST['bronze'];
	$wheat-=$_POST['wheat'];
	$coin-=$_POST['coin'];
	
	$query="UPDATE `players` SET `resources`='$wood|$woodlimit|$stone|$stonelimit|$bronze|$bronzelimit|$wheat|$wheatlimit|$coin|$coinlimit|$pop|$poplimit' WHERE `username`='$username' LIMIT 1";
	$h=mysql_query($query);
	
	$error="Resources Sent";
}
if (isset($_POST['wood'])){
	if ($_POST['village']==''){
		$vx=$_POST['x'];
		$vy=$_POST['y'];
		if ($vx=='' || $vy==''){
		$error='Please specify a town or coordinates';
		}else{
			$query="SELECT `username` FROM `players` WHERE `position`='$vx,$vy'";
			$result=mysql_query($query);
			$village=mysql_result($result,0);
		}
	}else{
		$village=$_POST['village'];
		$query="SELECT `position` FROM `players` WHERE `username`='$village'";
		$result=mysql_query($query);
		list($vx,$vy)=explode(',',mysql_result($result,0));
	}
	
	if ($_POST['wood']>$wood || $_POST['stone']>$stone || $_POST['bronze']>$bronze || $_POST['wheat']>$wheat || $_POST['coin']>$coin){
		if ($error==''){
			$error="You do not have enough resources";
		}		
	}
	
	if ($error==''){
		?>
		<b>Send resources to <?php echo $village.' ('.$vx.','.$vy.')';?></b><br/>
		<br/>
		<b>Time:</b> <?php
		$fph=10;
		$query="SELECT `position` FROM `players` WHERE `username`='$username'";
		$result=mysql_query($query);
		list($mx,$my)=explode(',',mysql_result($result,0));
		$dist=sqrt((($mx-$vx)*($mx-$vx))+(($my-$vy)*($my-$vy)));
		$outhour=$dist/$fph;
		$time=round($outhour*3600);
		$tmp=date('G',$time);
		$tmp-=1;
		echo $tmp.date(':i:s',$time);
		?>
		<br/><br/>
		<form action="mg.php" method="post">
		<table>
		<tr><td><img src="images/wood.gif" alt="wood" /> Wood:</td><td><input type="text" name="wood" value="<?php echo $_POST['wood'];?>" size="4" style="padding:0;" /></td></tr>
		<tr><td><img src="images/stone.gif" alt="stone" /> Stone:</td><td><input type="text" name="stone" value="<?php echo $_POST['stone'];?>" size="4" style="padding:0;" /></td></tr>
		<tr><td><img src="images/bronze.gif" alt="bronze" /> Bronze:</td><td><input type="text" name="bronze" value="<?php echo $_POST['bronze'];?>" size="4" style="padding:0;" /></td></tr>
		<tr><td><img src="images/wheat.gif" alt="wheat" /> Wheat:</td><td><input type="text" name="wheat" value="<?php echo $_POST['wheat'];?>" size="4" style="padding:0;" /></td></tr>
		<tr><td><img src="images/coin.gif" alt="coin" /> Coin:</td><td><input type="text" name="coin" value="<?php echo $_POST['coin'];?>" size="4" style="padding:0;" /></td></tr>
		</table>
		<input type="hidden" name="village" value="<?php echo $village;?>" />
		<input type="hidden" name="x" value="<?php echo $vx;?>" />
		<input type="hidden" name="y" value="<?php echo $vy;?>" />
		<input type="hidden" name="confirmed" value="yes" />
		<br/>
		<input type="submit" value="Send" />
		</form>
		<?php
	}else{
		?>
		<form action="mg.php" method="post">
		<?php echo $error;?>
		<table style="float:left;">
		<tr><td><img src="images/wood.gif" alt="wood" /> Wood:</td><td><input type="text" name="wood" value="<?php echo $_POST['wood'];?>" size="4" style="padding:0;" /></td></tr>
		<tr><td><img src="images/stone.gif" alt="stone" /> Stone:</td><td><input type="text" name="stone" value="<?php echo $_POST['stone'];?>" size="4" style="padding:0;" /></td></tr>
		<tr><td><img src="images/bronze.gif" alt="bronze" /> Bronze:</td><td><input type="text" name="bronze" value="<?php echo $_POST['bronze'];?>" size="4" style="padding:0;" /></td></tr>
		<tr><td><img src="images/wheat.gif" alt="wheat" /> Wheat:</td><td><input type="text" name="wheat" value="<?php echo $_POST['wheat'];?>" size="4" style="padding:0;" /></td></tr>
		<tr><td><img src="images/coin.gif" alt="coin" /> Coin:</td><td><input type="text" name="coin" value="<?php echo $_POST['coin'];?>" size="4" style="padding:0;" /></td></tr>
		</table>
		<table height="115px" style="margin-left:30px;">
		<tr><td>
		Town: <input type="text" name="village" value="<?php echo $_GET['to'].$_POST['village'];?>" size="10" style="padding:0;" /><br/>
		<br/>
		Or<br/>
		<br/>
		Coordinates: X:<input type="text" name="x" size="2" style="padding:0;" /> Y:<input type="text" name="y" size="2" style="padding:0;" />
		</td></tr>
		</table>
		<br/>
		<input type="submit" value="Get time" />
		<?php
	}
}else{
	?>
	<form action="mg.php" method="post">
	<?php echo $error;?>
	<table style="float:left;">
	<tr><td><img src="images/wood.gif" alt="wood" /> Wood:</td><td><input type="text" name="wood" value="0" size="4" style="padding:0;" /></td></tr>
	<tr><td><img src="images/stone.gif" alt="stone" /> Stone:</td><td><input type="text" name="stone" value="0" size="4" style="padding:0;" /></td></tr>
	<tr><td><img src="images/bronze.gif" alt="bronze" /> Bronze:</td><td><input type="text" name="bronze" value="0" size="4" style="padding:0;" /></td></tr>
	<tr><td><img src="images/wheat.gif" alt="wheat" /> Wheat:</td><td><input type="text" name="wheat" value="0" size="4" style="padding:0;" /></td></tr>
	<tr><td><img src="images/coin.gif" alt="coin" /> Coin:</td><td><input type="text" name="coin" value="0" size="4" style="padding:0;" /></td></tr>
	</table>
	<table height="115px" style="margin-left:30px;">
	<tr><td>
	Town: <input type="text" name="village" value="<?php echo $_GET['to'].$_POST['village'];?>" size="10" style="padding:0;" /><br/>
	<br/>
	Or<br/>
	<br/>
	Coordinates: X:<input type="text" name="x" size="2" style="padding:0;" /> Y:<input type="text" name="y" size="2" style="padding:0;" />
	</td></tr>
	</table>
	<br/>
	<input type="submit" value="Get time" />
	<?php
}
?>
<?php
$query="SELECT * FROM `trade` WHERE `to`='$username'";
$to=mysql_query($query);
if (mysql_num_rows($to)>0){
	echo '<br/><br/><b>Incoming Trade</b><br/><table width="95%" border="1"><tr><th width="50%">From</th><th width="50%">Arrival Time</th></tr>';
	while ($arriving=mysql_fetch_array($to)){
		$finishtime=date("G:i:s",$arriving['time']);
		echo '<tr><td>'.$arriving['from'].'</td><td>'.$finishtime.'</td></tr>';
	}
	echo '</table>';
}
$query="SELECT * FROM `trade` WHERE `from`='$username'";
$to=mysql_query($query);
if (mysql_num_rows($to)>0){
	echo '<br/><br/><b>Outgoing Trade</b><br/><table width="95%" border="1"><tr><th width="30%">Destination</th><th width="40%">Resources</th><th width="30%">Arrival Time</th></tr>';
	while ($arriving=mysql_fetch_array($to)){
		list($bldwood,$bldstone,$bldbronze,$bldwheat,$bldcoin)=explode('|',$arriving['resources']);
		$finishtime=date("G:i:s",$arriving['time']);
		echo '<tr><td>'.$arriving['from'].'</td><td>';
		echo '<img src="images/wood.gif" alt="wood" style="margin-right:2px;" />'.$bldwood;
		echo '  <img src="images/stone.gif" alt="stone" style="margin-right:2px;" />'.$bldstone;
		echo '  <img src="images/bronze.gif" alt="bronze" style="margin-right:2px;" />'.$bldbronze;
		echo '  <img src="images/wheat.gif" alt="wheat" style="margin-right:2px;" />'.$bldwheat;
		echo '  <img src="images/coin.gif" alt="coin" style="margin-right:2px;" />'.$bldcoin;
		echo '</td><td>'.$finishtime.'</td></tr>';
	}
	echo '</table>';
}
?>
</div>

<div id="right">
<?php include('stat.php'); ?>

<?php include('foot.php'); ?>