<?php

include('dbinfo.php');





$time=time();
$query="SELECT * FROM `map`";
#echo $query;
$resultt=mysql_query($query);
#echo $result;

while ($job=mysql_fetch_array($resultt)){
	$username=$job['player'];

	$query="SELECT * FROM `players` WHERE `username`='$username'";
	$result=mysql_query($query);
	if (mysql_num_rows($result)==0){
		$query="UPDATE `map` SET `player`='', `terrain`='g' WHERE `player`='$username'";
		$result=mysql_query($query);
	}
}

?>