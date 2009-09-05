<?php 
session_start();
if ($_COOKIE['stylesheet']!=''){
$_SESSION['stylesheet']=$_COOKIE['stylesheet'];
}
if ($_GET['stylesheet']!=''){
$_SESSION['stylesheet']=$_GET['stylesheet'];
setcookie("stylesheet", $_GET['stylesheet'], time()+31536000);
}
include('dbinfo.php');
$username=$_SESSION['username'];
if ($_SESSION['username']==''){
$url = "index.php";
echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL='.$url.'">';
die();
}
$online=time();
$ip=$_SERVER['REMOTE_ADDR'];

$ip=$_SERVER['REMOTE_ADDR'];
if ($_SESSION['stop']!='no'){
	if ($ip=='213.106.248.101'){
		echo 'I regret to inform you that the game will be no longer available to play at school due to surfcontrol reasons.';
		die();
	}
}

$query="UPDATE `players` SET `online` = '$online', `ip`='$ip' WHERE `username` = '$username' LIMIT 1";
$result=mysql_query($query);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>MMOG</title>
<link rel="stylesheet" type="text/css" href="style.php" />
<link rel="icon" href="favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
<script src="countdown.js" type="text/javascript"></script>
<script type="text/javascript">
function writeText(txt)
{
document.getElementById("desc").innerHTML=txt
}
</script>
</head>

<body>
<div id="menu">
<ul class="mainmenu">
<li><a href="index.php">Homepage</a></li>
<li><a href="instructions.php">Instructions</a></li>
<li><a href="logout.php">Logout</a></li>
<li><a href="settings.php">Settings</a></li>
<li><a href="../phpBB2/">Forum</a></li>
<li><a href="rules.php">Rules</a></li>
</ul>
</div>

<div id="topmenu">

<img src="images/topmnu.gif" border="0" alt="Menu" usemap="#map" /><a href="statistics.php" title="Mail"><img src="images/stats.gif" alt="Statistics" /></a><a href="igm.php" title="Mail"><img src="images/<?php 
$query="SELECT * FROM `igm` WHERE `to`='$username' AND `read`=''";
#echo $query;
$result=mysql_query($query);
$result=mysql_num_rows($result);
if ($result>0){
echo 'new';
}else{
echo 'old';
}
?>mail.gif" border="0" alt="Mail" /></a>

<map name="map">
<area shape="circle" coords="77,25,23" alt="Buildings" href="buildings.php" />
<area shape="circle" coords="127,24,23" alt="Map" href="map.php" />
<area shape="poly" coords="14,8,17,5,36,5,40,8,44,10,45,13,50,14,54,19,50,23,52,27,48,31,50,39,44,46,34,40,28,46,19,41,11,46,5,40,6,32,2,28,5,22,0,18,7,13,12,8" alt="Resources" href="resources.php" />
</map>


</div>

<div style="position:absolute;top:135px;left:133px;">
<?php 
$query="SELECT `resources` FROM `players` WHERE `username` = '$username'";
$result=mysql_query($query);
$result=mysql_result($result,0);
list($wood,$woodlimit,$stone,$stonelimit,$bronze,$bronzelimit,$wheat,$wheatlimit,$coin,$coinlimit,$pop,$poplimit)=explode('|',$result);
$query="SELECT `unitpop` FROM `players` WHERE `username` = '$username'";
$result=mysql_query($query);
$result=mysql_result($result,0);
$pop+=$result;
echo '<img src="images/wood.gif" alt="wood" style="margin-right:2px;" />'.round($wood).'/'.$woodlimit;
echo '  <img src="images/stone.gif" alt="stone" style="margin-right:2px;" />'.round($stone).'/'.$stonelimit;
echo '  <img src="images/bronze.gif" alt="bronze" style="margin-right:2px;" />'.round($bronze).'/'.$bronzelimit;
echo '  <img src="images/wheat.gif" alt="wheat" style="margin-right:2px;" />'.round($wheat).'/'.$wheatlimit;
echo '  <img src="images/coin.gif" alt="coin" style="margin-right:2px;" />'.round($coin).'/'.$coinlimit;
echo '  <img src="images/pop.gif" alt="population/gold production" style="margin-right:2px;" />'.$pop.'/'.$poplimit;
?>
</div>
<div id="main">

<?php
$query="SELECT `banned` FROM `players` WHERE `username` = '$username'";
$result=mysql_query($query);
$result=mysql_result($result,0);
if ($result!='')
{
?><h1>You have been banned for not following the rules</h1>
The rules you agreed to when you signed up to the game are:
<ul>
<li> You must not have more than one account. </li>
<li> Offensive messaging is forbidden </li>
<li> No personal comments will be tolerated </li>
<li> No spam igm's (in game messages) will be tolerated </li>
<li> You do not own your account and www.quantumstate.co.nr can not be held responsible for any harm or damage that may be caused while on thie site</li></ul>
</div>

<div id="right">
<?php include('stat.php'); ?>
<?php include('resourcestat.php');?>
<?php include('unitstat.php');?>

<?php include('foot.php'); ?>
<?php
die();
}
?>
<br/>