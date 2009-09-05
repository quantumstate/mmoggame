<?php
session_start();
include('dbinfo.php');
$username=$_SESSION['username'];
$to=$_POST['to'];
$subject=$_POST['subject'];
$content=$_POST['content'];
$time=time();

$query="INSERT INTO `igm` ( `id` , `to` , `from` , `subject` , `content` , `read` , `time` ) VALUES (NULL , '$to', '$username', '$subject', '$content', '', $time)";

$result=mysql_query($query);

$url = "igm.php?b=from";
echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL='.$url.'">';
?>