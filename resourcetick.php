<?php
session_start();
include('dbinfo.php');
$query="SELECT * FROM `resource`";
$result=mysql_query($query);
$oldtime=mysql_result($result,0);

$time=time();
$times=($time-$oldtime)/3600;
#echo $times;

$query="UPDATE `resource` SET `time` = '$time'";
$result=mysql_query($query);

$query="SELECT * FROM `players`";
$result=mysql_query($query);


while ($job=mysql_fetch_array($result)){
	$username=$job['username'];

	list($woodinc,$stoneinc,$bronzeinc,$wheatinc,$coininc)=explode('|',$job['production']);
	$woodinc*=$times;
	$stoneinc*=$times;
	$bronzeinc*=$times;
	$wheatinc*=$times;
	$coininc*=$times;
	
	list($wood,$woodlimit,$stone,$stonelimit,$bronze,$bronzelimit,$wheat,$wheatlimit,$coin,$coinlimit,$pop,$poplimit)=explode('|',$job['resources']);
	$popit=$pop*$times;
	#echo $coininc;
	$wood+=$woodinc;
	$stone+=$stoneinc;
	$bronze+=$bronzeinc;
	$wheat+=$wheatinc;
	$coin+=$coininc-$popit;
	#echo '<br>'.$popit.'<br>'.'<br>';
	
	if ($wood>$woodlimit){
		$wood=$woodlimit;
	}
	if ($stone>$stonelimit){
		$stone=$stonelimit;
	}
	if ($bronze>$bronzelimit){
		$bronze=$bronzelimit;
	}
	if ($wheat>$wheatlimit){
		$wheat=$wheatlimit;
	}
	if ($coin>$coinlimit){
		$coin=$coinlimit;
	}
	
	$pop=$job['pop']+$job['$unitpop'];
	
	$resources=$wood.'|'.$woodlimit.'|'.$stone.'|'.$stonelimit.'|'.$bronze.'|'.$bronzelimit.'|'.$wheat.'|'.$wheatlimit.'|'.$coin.'|'.$coinlimit.'|'.$pop.'|'.$poplimit;

	$buildings=str_replace($find,$replace,$buildings);
	$query="UPDATE `players` SET `resources` = '$resources' WHERE `username`='$username' LIMIT 1";
	$resulter=mysql_query($query);
}
?>