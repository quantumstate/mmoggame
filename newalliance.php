<?php
session_start();
include('dbinfo.php');
$username=$_SESSION['username'];
$alliance=$_POST['name'];

$query="SELECT * FROM `players` WHERE `username`='$username'";
$result=mysql_query($query);
$userresult=mysql_fetch_array($result);

$buildings=explode('|',$userresult['buildings']);

foreach ($buildings as $building){
	if ($next=='set'){
		$dglvl=$building;
		$next='unset';
	}
	if ($building=='dg'){
		$next='set';
	}
	#echo $building.'<br/>';
}

if ($dglvl > 2 OR $alliance != ''){
	$query="SELECT * FROM `alliance` WHERE `name`='$alliance'";
	$result=mysql_query($query);
	$rank=mysql_num_rows($result);
	if ($rank != 0){
		header('Location: http://'.$_SERVER['HTTP_HOST'].'/game/alliance.php');
		die;
	}

	$query="UPDATE `players` SET `allianceoptions`='all',`alliance`='$alliance' WHERE `username`='$username'";
	$result=mysql_query($query);
	
	$query="SELECT * FROM `alliance`";
	$result=mysql_query($query);
	$rank=mysql_num_rows($result)+1;
	
	$query=" INSERT INTO `alliance` ( `id` , `name` , `rank` , `ally` , `nap` , `war` , `description` , `positions` , `options` ) VALUES ('', '$alliance', '$rank', '', '', '', '', 'Founder|$username', '')";
	$result=mysql_query($query);
}

header('Location: http://'.$_SERVER['HTTP_HOST'].'/game/alliance.php');
?>