<?php
session_start();
include('dbinfo.php');
$username=$_SESSION['username'];
$name=$_GET['name'];

$query="SELECT * FROM `players` WHERE `username`='$username'";
$result=mysql_query($query);
$userresult=mysql_fetch_array($result);

if ($userresult['alliance']==''){
	$query="SELECT * FROM `invitations` WHERE `to`='$username' AND `alliance`='$name'";
	$result=mysql_query($query);
	if (mysql_num_rows($result)>0){
		$query="DELETE FROM `invitations` WHERE `to`='$username' AND `alliance`='$name'";
		$result=mysql_query($query);
		$query="UPDATE `players` SET `alliance`='$name' WHERE `username`='$username'";
		$result=mysql_query($query);
	}
}

$url = "dg.php";
echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL='.$url.'">';
?>