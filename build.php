<?php
session_start();
include('dbinfo.php');
$username=$_SESSION['username'];

$buildingid=$_GET['building'];

$query="SELECT * FROM `players` WHERE `username`='$username'";
$userresult=mysql_query($query);
$userresult=mysql_fetch_array($userresult);
$user=explode('|',$userresult['buildings']);

$bldlvl=array();
for ($i=0;$i<count($user);$i=$i+2){
$bldlvl[$user[$i]]=$user[($i+1)];
}

$query="SELECT `resources` FROM `buildings` WHERE `abbr`='$buildingid'";
$bldresult=mysql_query($query);
$bldresult=mysql_result($bldresult,0);
list($bldwood,$bldstone,$bldbronze,$bldwheat,$bldcoin,$popcost)=explode('|',$bldresult);

$lvlcost=pow(1.25,$bldlvl[$buildingid]);
$bldwood=round($bldwood*$lvlcost);
$bldstone=round($bldstone*$lvlcost);
$bldbronze=round($bldbronze*$lvlcost);
$bldwheat=round($bldwheat*$lvlcost);
$bldcoin=round($bldcoin*$lvlcost);

$query="SELECT `time` FROM `buildings` WHERE `abbr`='$buildingid'";
$bldtime=mysql_query($query);
$bldtime=mysql_result($bldtime,0);
$bldtime=round($bldtime*$lvlcost)+time();

list($wood,$woodlimit,$stone,$stonelimit,$bronze,$bronzelimit,$wheat,$wheatlimit,$coin,$coinlimit,$pop,$poplimit)=explode('|',$userresult['resources']);

$wood-=$bldwood;
$stone-=$bldstone;
$bronze-=$bldbronze;
$wheat-=$bldwheat;
$coin-=$bldcoin;
$pop+=$popcost;

$lvl=$bldlvl[$buildingid]+1;

$query="UPDATE `players` SET `resources`='$wood|$woodlimit|$stone|$stonelimit|$bronze|$bronzelimit|$wheat|$wheatlimit|$coin|$coinlimit|$pop|$poplimit',`pop`='$pop', `construction` = '$buildingid|$lvl|$bldtime' WHERE `username`='$username' LIMIT 1";
$result=mysql_query($query);

$query="INSERT INTO `queue` ( `id` , `player` , `time` ) VALUES (NULL , '$username', '$bldtime')";
$result=mysql_query($query);

$url = "buildings.php";
echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL='.$url.'">';
?>