<?php 
session_start(); 
if ($_COOKIE['stylesheet']!=''){
$_SESSION['stylesheet']=$_COOKIE['stylesheet'];
}
if ($_GET['stylesheet']!=''){
$_SESSION['stylesheet']=$_GET['stylesheet'];
setcookie("stylesheet", $_GET['stylesheet'], time()+31536000);
}

$ip=$_SERVER['REMOTE_ADDR'];
if ($_SESSION['stop']!='no'){
	if ($ip=='213.106.248.101'){
		echo 'I regret to inform you that the game will be no longer available to play at school due to surfcontrol reasons.';
		die();
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>MMOG</title>
<link rel="stylesheet" type="text/css" href="style.php" />
<link rel="icon" href="favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
</head>

<body>
<div id="menu">
<ul class="mainmenu">
<li><a href="index.php">Homepage</a></li>
<li><a href="instructions.php">Instructions</a></li>
<li><a href="login.php">Login</a></li>
<li><a href="register.php">Register</a></li>

<li><a href="../phpBB2/">Forum</a></li>
<li><a href="rules.php">Rules</a></li>
</ul>
</div>

<div id="main">