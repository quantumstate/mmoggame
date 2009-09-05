<?php
session_start();
include('dbinfo.php');
$username=$_SESSION['username'];

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
$popcost=1;
$bldtime=360;
break;
case 's':
$name='Stone Quarry';
$bldwood=100;
$bldstone=40;
$bldbronze=70;
$bldwheat=30;
$bldcoin=60;
$popcost=1;
$bldtime=540;
break;
case 'b':
$name='Bronze Mine';
$bldwood=100;
$bldstone=80;
$bldbronze=40;
$bldwheat=30;
$bldcoin=60;
$popcost=1;
$bldtime=480;
break;
case 'g':
$name='Gold Mine (coin)';
$bldwood=100;
$bldstone=80;
$bldbronze=50;
$bldwheat=30;
$bldcoin=60;
$bldtime=600;
$popcost=0;
break;
case 'c':
$name='Wheat Field';
$bldwood=80;
$bldstone=80;
$bldbronze=80;
$bldwheat=50;
$bldcoin=60;
$popcost=1;
$bldtime=420;
break;
}

$lvlcost=pow(1.25,$resourcelvl);
$bldwood=round($bldwood*$lvlcost);
$bldstone=round($bldstone*$lvlcost);
$bldbronze=round($bldbronze*$lvlcost);
$bldwheat=round($bldwheat*$lvlcost);
$bldcoin=round($bldcoin*$lvlcost);
$bldtime=round($bldtime*$lvlcost)+time();

list($wood,$woodlimit,$stone,$stonelimit,$bronze,$bronzelimit,$wheat,$wheatlimit,$coin,$coinlimit,$pop,$poplimit)=explode('|',$userresult['resources']);

$wood-=$bldwood;
$stone-=$bldstone;
$bronze-=$bldbronze;
$wheat-=$bldwheat;
$coin-=$bldcoin;
$pop+=$popcost;

$lvl=$resourcelvl+1;

$query="UPDATE `players` SET `resources`='$wood|$woodlimit|$stone|$stonelimit|$bronze|$bronzelimit|$wheat|$wheatlimit|$coin|$coinlimit|$pop|$poplimit',`pop`='$pop', `resourceconstruction` = '$resourcefield|$lvl|$bldtime' WHERE `username`='$username' LIMIT 1";
$result=mysql_query($query);

$query="INSERT INTO `resqueue` ( `id` , `player` , `time` ) VALUES (NULL , '$username', '$bldtime')";
$result=mysql_query($query);

$url = "resources.php";
echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL='.$url.'">';
?>