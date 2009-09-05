<?php
$starttime=microtime(true);
include('ingamehead.php'); ?>

<h1><?php echo $_SESSION['username'];?>'s town</h1>
This is where you can build and upgrade your towns buildings.  They all have different functions and some need other buildings to be built before they can be built.<br/><br/>
<?php
$query="SELECT * FROM `buildings`";
$result=mysql_query($query);

$query="SELECT * FROM `players` WHERE `username`='$username'";
$userresult=mysql_query($query);
$userresult=mysql_fetch_array($userresult);
$user=explode('|',$userresult['buildings']);

if ($userresult['resourceconstruction']!=''){
	$construction=explode('|',$userresult['resourceconstruction']);
	$temp=$construction[0];
	
	$bldname=explode('|',$userresult['resourcefields']);
	$bldname=$bldname[$temp];
	switch ($bldname){
		case 'w':
			$bldname='Woodcutter';
		break;
		case 's':
			$bldname='Stone Quarry';
		break;
		case 'b':
			$bldname='Bronze Mine';
		break;
		case 'g':
			$bldname='Gold Mine';
		break;
		case 'c':
			$bldname='Wheat Farm';
		break;
	}
	
	$temp=$construction[1];
	$finishtime=date("G:i:s",$construction[2]);
	echo '<b>Current construction</b><br/>';
	$on='yes';
	echo "$bldname (level $temp) &nbsp;&nbsp;&nbsp;&nbsp;Finished at $finishtime<br/>";
}
if ($userresult['construction']!=''){
	$construction=explode('|',$userresult['construction']);
	$temp=$construction[0];
	
	$query="SELECT `name` FROM `buildings` WHERE `abbr`='$temp'";
	$bldname=mysql_query($query);
	$bldname=mysql_result($bldname,0);
	
	if ($on != 'yes'){
		echo '<b>Current construction</b><br/>';
	}
	
	$temp=$construction[1];
	$finishtime=date("G:i:s",$construction[2]);
	echo "$bldname (level $temp) &nbsp;&nbsp;&nbsp;&nbsp;Finished at $finishtime<br/><br/>";
}

$bldlvl=array();
for ($i=0;$i<count($user);$i=$i+2){
$bldlvl[$user[$i]]=$user[($i+1)];
}

#print_r(array_values($bldlvl));

echo '<table width="450px" border="1" cellpadding="2" cellspacing="0">';

while ($building=mysql_fetch_array($result)){
$errors=array();
?>
<tr>
<td rowspan="2" width="80px"><?php if ($building['link']!='' && $bldlvl[$building['abbr']]>0){echo '<a href="'.$building['link'].'">';}?><img src="buildings/<?php echo $building['picture'];?>"/><?php if ($building['link']!=''){echo '</a>';}?></td>
<th height="13px" align="center"><b><?php if ($building['link']!='' && $bldlvl[$building['abbr']]>0){echo '<a href="'.$building['link'].'">';}?><?php echo $building['name'].' level '.$bldlvl[$building['abbr']];?><?php if ($building['link']!=''){echo '</a>';}?></b></th>
</tr>
<tr>
<td valign="top" align="center">
<?php
list($bldwood,$bldstone,$bldbronze,$bldwheat,$bldcoin,$popcost)=explode('|',$building['resources']);
$lvlcost=pow(1.25,$bldlvl[$building['abbr']]);
$bldwood=round($bldwood*$lvlcost);
$bldstone=round($bldstone*$lvlcost);
$bldbronze=round($bldbronze*$lvlcost);
$bldwheat=round($bldwheat*$lvlcost);
$bldcoin=round($bldcoin*$lvlcost);

$buildingid=$building['abbr'];
$query="SELECT `time` FROM `buildings` WHERE `abbr`='$buildingid'";
$bldtime=mysql_query($query);
$bldtime=mysql_result($bldtime,0);
$bldtime=round($bldtime*$lvlcost);

$tmp=date('G',$bldtime);
$tmp-=1;

echo $building['description'].'<br/>';

echo '<img src="images/wood.gif" alt="wood" style="margin-right:2px;" />'.$bldwood;
echo '  <img src="images/stone.gif" alt="stone" style="margin-right:2px;" />'.$bldstone;
echo '  <img src="images/bronze.gif" alt="bronze" style="margin-right:2px;" />'.$bldbronze;
echo '  <img src="images/wheat.gif" alt="wheat" style="margin-right:2px;" />'.$bldwheat;
echo '  <img src="images/coin.gif" alt="coin" style="margin-right:2px;" />'.$bldcoin;
echo '  <img src="images/pop.gif" alt="population" style="margin-right:2px;" />'.$popcost;
echo '  <img src="images/time.gif" alt="build time" style="margin-right:2px;" />'.$tmp.date(':i:s',$bldtime);
?>
<br/>

<?php
$depend=explode('|',$building['dependancy']);
for ($i=0;$i<count($depend);$i=$i+2){
	if ($bldlvl[$depend[$i]]<$depend[($i+1)]){
		$temp=$depend[$i];
		$query="SELECT `name` FROM `buildings` WHERE `abbr`='$temp'";
		$dependresult=mysql_query($query);
		$dependresult=mysql_result($dependresult,0);
		$errors[$i]="Requires $dependresult level ".$depend[($i+1)];
	}
}
if ((($wood-$bldwood)>=0) AND (($stone-$bldstone)>=0) AND (($bronze-$bldbronze)>=0) AND (($wheat-$bldwheat)>=0) AND (($coin-$bldcoin)>=0)){

	if (!(empty($errors))){
		foreach ($errors as $k){
			echo $k.'<br/>';
		}
	}else{
		if ($userresult['construction']!=''){
			echo 'Your builders are working';
		}else{
			echo'<a href="build.php?building='.$building['abbr'].'">Build level '.($bldlvl[$building['abbr']]+1).'</a>';
		}
	}
}else{
	foreach ($errors as $j){
		echo $j.'<br/>';
	}
	echo 'Not enough resources';
	
}
$errors=array();
?>
</td>
</tr>
<?php
}
?>
</table>

</div>

<div id="right">
<?php include('stat.php'); ?>
<?php include('resourcestat.php');?>
<?php include('unitstat.php');?>

<?php include('foot.php');
echo microtime(true) - $starttime;
 ?>