<?php
include('ingamehead.php');
$username=$_SESSION['username'];

$resourcefield=$_GET['field'];

$query="SELECT * FROM `players` WHERE `username`='$username'";
$userresult=mysql_query($query);
$userresult=mysql_fetch_array($userresult);
$user=explode('|',$userresult['resourcefields']);

$resourcetype=$user[$resourcefield];
$resourcelvl=$user[$resourcefield+1];

switch ($resourcetype){
case 'w':
$name='Woodchopper';
$bldwood=60;
$bldstone=80;
$bldbronze=100;
$bldwheat=30;
$bldcoin=60;
$bldtime=360;
$popcost=1;
break;
case 's':
$name='Stone Quarry';
$bldwood=100;
$bldstone=40;
$bldbronze=70;
$bldwheat=30;
$bldcoin=60;
$bldtime=540;
$popcost=1;
break;
case 'b':
$name='Bronze Mine';
$bldwood=100;
$bldstone=80;
$bldbronze=40;
$bldwheat=30;
$bldcoin=60;
$bldtime=480;
$popcost=1;
break;
case 'g':
$name='Gold Mine (coin)';
$bldwood=100;
$bldstone=80;
$bldbronze=50;
$bldwheat=30;
$bldcoin=60;
$bldtime=300;
$popcost=0;
break;
case 'c':
$name='Wheat Field';
$bldwood=80;
$bldstone=80;
$bldbronze=80;
$bldwheat=50;
$bldcoin=60;
$bldtime=420;
$popcost=1;
break;
}

$lvlcost=pow(1.25,$resourcelvl);
$bldwood=round($bldwood*$lvlcost);
$bldstone=round($bldstone*$lvlcost);
$bldbronze=round($bldbronze*$lvlcost);
$bldwheat=round($bldwheat*$lvlcost);
$bldcoin=round($bldcoin*$lvlcost);
$bldtime=round($bldtime*$lvlcost);

$tmp=date('G',$bldtime);
$tmp-=1;

$lvl=$resourcelvl+1;

?>
<h1>Build <?php echo $name;?> level <?php echo $lvl;?></h1>
<br/>
Current production <?php echo ((2*$resourcelvl*$resourcelvl)-(2*$resourcelvl))+5;?><br/>
<br/>
Production at next level <?php echo ((2*$lvl*$lvl)-(2*$lvl))+5;?><br/>
<br/>
<?php
echo '<img src="images/wood.gif" alt="wood" style="margin-right:2px;" />'.$bldwood;
echo '  <img src="images/stone.gif" alt="stone" style="margin-right:2px;" />'.$bldstone;
echo '  <img src="images/bronze.gif" alt="bronze" style="margin-right:2px;" />'.$bldbronze;
echo '  <img src="images/wheat.gif" alt="wheat" style="margin-right:2px;" />'.$bldwheat;
echo '  <img src="images/coin.gif" alt="coin" style="margin-right:2px;" />'.$bldcoin;
echo '  <img src="images/pop.gif" alt="population" style="margin-right:2px;" />'.$popcost;
echo '  <img src="images/time.gif" alt="build time" style="margin-right:2px;" />'.$tmp.date(':i:s',$bldtime);
?>
<br/>
<br/>
<?php
if ((($wood-$bldwood)>=0) AND (($stone-$bldstone)>=0) AND (($bronze-$bldbronze)>=0) AND (($wheat-$bldwheat)>=0) AND (($coin-$bldcoin)>=0)){
	if ($userresult['resourceconstruction']==''){
	?>
	<a href="startbldresource.php?field=<?php echo $resourcefield;?>">Build</a>
	<?php
	}else{
	echo 'Your builders are working';
	}
}else{
	echo 'You need more resources';
}
?>
</div>

<div id="right">
<p><u><b>Statistics</b></u>
<br/>
<?php include('stats.php'); ?>
Users Registered :<?php echo $registeredusers;?> <br/>
Users Online :<?php echo $onlineusers;?> <br/>
</p>

<?php include('foot.php'); ?>