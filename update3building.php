<?php

include('dbinfo.php');


$time=time();
$query="SELECT * FROM `players`";
$result=mysql_query($query);

while ($job=mysql_fetch_array($result)){
	$username=$job['username'];

	
	$query="SELECT `buildings` FROM `players` WHERE `username`='$username'";
	$buildings=mysql_query($query);
	$buildings=mysql_result($buildings,0);
	
	trim($buildings,'|');
	
	$buildings.='|dg|0';
	 
	$query="UPDATE `players` SET `buildings`='$buildings' WHERE `username`='$username'";
	$resulter=mysql_query($query);
}

?>