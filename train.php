<?php
session_start();
include('dbinfo.php');
$username=$_SESSION['username'];

$buildingid=$_GET['building'];

$query="SELECT * FROM `players` WHERE `username`='$username'";
$userresult=mysql_query($query);
$userresult=mysql_fetch_array($userresult);
$user=explode('|',$userresult['unitposs']);

$bldwood=0;
$bldstone=0;
$bldbronze=0;
$bldwheat=0;
$bldcoin=0;
$popcost=0;
foreach ($user as $usrunit){
	$query="SELECT * FROM `units` WHERE `abbr`='$usrunit'";
	$result=mysql_query($query);
	$unit=mysql_fetch_array($result);
	list($wood,$stone,$bronze,$wheat,$coin)=explode('|',$unit['resources']);
	$bldwood+=$_POST[$usrunit]*$wood;
	$bldstone+=$_POST[$usrunit]*$stone;
	$bldbronze+=$_POST[$usrunit]*$bronze;
	$bldwheat+=$_POST[$usrunit]*$wheat;
	$bldcoin+=$_POST[$usrunit]*$coin;
	#$popcost+=$_POST[$usrunit]*$unit['pop'];
}
#echo $bldwood;

list($wood,$woodlimit,$stone,$stonelimit,$bronze,$bronzelimit,$wheat,$wheatlimit,$coin,$coinlimit,$pop,$poplimit)=explode('|',$userresult['resources']);

$wood-=$bldwood;
$stone-=$bldstone;
$bronze-=$bldbronze;
$wheat-=$bldwheat;
$coin-=$bldcoin;
$pop+=$popcost;

if ($wood<0 || $stone<0 || $bronze<0 || $wheat<0 || $coin<0){
	$url = "ba.php?error=Not%20enough%20resources";
	echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL='.$url.'">';
	exit();
}

$units=$userresult['unitconstruction'];
foreach ($user as $usrunit){
	if ($_POST[$usrunit]>0){
		$units.="$usrunit|{$_POST[$usrunit]}|";
		if ($bldtime==''){
			$query="SELECT * FROM `units` WHERE `abbr`='$usrunit'";
			$result=mysql_query($query);
			
			$barracks=explode('|',$userresult['buildings']);
			foreach ($barracks as $ba){
				if ($next=='yes'){
					$balvl=$ba;
					break;
				}
				if ($ba=='ba'){
					$next='yes';
				}
			}
			
			$unit=mysql_fetch_array($result);
			$bldtime=$unit['time']*(1-($balvl*0.04));
			$bldtime+=time();
		}
	}
}

#echo $units;
$query="UPDATE `players` SET `resources`='$wood|$woodlimit|$stone|$stonelimit|$bronze|$bronzelimit|$wheat|$wheatlimit|$coin|$coinlimit|$pop|$poplimit', `unitconstruction` = '$units' WHERE `username`='$username' LIMIT 1";

$result=mysql_query($query);

$query="SELECT * FROM `unitqueue` WHERE `player`='$username'";
$result=mysql_query($query);

if (mysql_num_rows($result)==0){
$query="INSERT INTO `unitqueue` ( `id` , `player` , `time` ) VALUES (NULL , '$username', '$bldtime')";
$result=mysql_query($query);
}


$url = "ba.php";
echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL='.$url.'">';
?>