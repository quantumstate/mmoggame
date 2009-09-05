<?php

include('dbinfo.php');





$time=time();
$query="SELECT * FROM `players`";
#echo $query;
$result=mysql_query($query);
#echo $result;

while ($job=mysql_fetch_array($result)){
	$username=$job['username'];

	$tima = time();
	mysql_close();
	$dbusername="root";
	$dbpassword="simcity1984";
	$database="phpBB";


	$sqllink=mysql_connect(localhost,$dbusername,$dbpassword);
	@mysql_select_db($database);
	
	$query="SELECT * FROM `phpbb_users` WHERE 1";
	$resulto=mysql_query($query);
	$num=mysql_num_rows($resulto);
	#echo $num;
	$num++;
	
	$query = "INSERT INTO `phpbb_users` VALUES ($num, 1, '$username', '{$job['password']}', 0, 0, 0, $tima, 0, 0, 0.00, 3, 'english', 'D M d, Y g:i a', 0, 0, 0, 0, 0, NULL, 0, 1, 1, 1, 1, 1, 1, 1, 0, 1, 1, 0, '', 0, '{$job['email']}', '', '', '', '', '', '', '', '', '', '', '', NULL);";
	#echo $query.'<br>';
	$resulter=mysql_query($query);
	mysql_close();
	include('dbinfo.php');
}

?>