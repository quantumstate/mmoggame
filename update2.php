<?php

include('dbinfo.php');


$time=time();
$query="SELECT * FROM `players`";
#echo $query;
$result=mysql_query($query);
#echo $result;

while ($job=mysql_fetch_array($result)){
	$username=$job['username'];

	
	$query="SELECT `password` FROM `players` WHERE `username`='$username'";
	$buildings=mysql_query($query);
	$buildings=mysql_result($buildings,0);
	
	if (strlen($buildings)!=32){
	$buildings=md5($buildings);
	}
	 
	$query="UPDATE `players` SET `password`='$buildings' WHERE `username`='$username'";
	#echo $query.'<br>';
	$resulter=mysql_query($query);
}

?>