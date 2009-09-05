<?php
session_start();
include('dbinfo.php');
$username=$_SESSION['username'];
$to=$_GET['to'];

$query="SELECT * FROM `players` WHERE `username`='$username'";
$result=mysql_query($query);
$player=mysql_fetch_array($result);

$query="SELECT * FROM `players` WHERE `username`='{$_GET['to']}'";
$result=mysql_query($query);
$defplayer=mysql_fetch_array($result);

if ($player['alliance'] != ''){
	if ($player['alliance'] == $defplayer['alliance']){
		echo "Stop hacking Oakley";
		die();
	}
}

$units=explode('|',$player['units']);

$attunits=array();
$x='f';
foreach ($units as $unit){
	if ($x=='f'){
		$temp=$unit;
		$x='s';
	}else{
		$attunits[$temp]=$unit;
		$x='f';
	}
}

$civ=$player['civ'];
			
$query="SELECT * FROM `units` WHERE `civ`='$civ'";
$resulta=mysql_query($query);
while ($unit=mysql_fetch_array($resulta)){
	if ($attunits[$unit['abbr']]==''){

	}else{
		$curunits[$unit['abbr']]+=$attunits[$unit['abbr']];
		$unitpop+=$unit['pop']*$curunits[$unit['abbr']];
		
	}
	$theunits.=$unit['abbr'].'|'.$curunits[$unit['abbr']].'|';
}


$count=0;
$switch='f';
foreach ($units as $unit){
	if ($switch=='f'){
		$switch='s';
		$temp=$unit;
		$troops.="$unit|";
	}else{
		if ($unit<$_POST[$temp]){
			echo 'Not enough troops';
			die();
		}
		$switch='f';
		$count++;
		$tmp=$unit-$_POST[$temp];
		$troops.="$tmp|";
	}
}
#echo $troops;
foreach ($_POST as $abbr => $number){
	$x='no';
	foreach ($units as $unit){
		if ($unit==$abbr){
			$x='yes';
		}
	}
	if ($x=='no'){
		echo 'Not enough troops';
		die();
		
	}
	$force.="$abbr|$number|";
}

#echo "$force<br>";

$civ=$player['civ'];


$fph=10000;
$query="SELECT * FROM `units` WHERE `civ`='$civ'";
$result=mysql_query($query);
	while ($unit=mysql_fetch_array($result)){
		if ($_POST[$unit['abbr']]==''){
			#echo $unit['abbr'];
		}else{

			if ($fph>$unit['speed']){
				$fph=$unit['speed'];
			}
		}
	}
#echo $fph;

$query="SELECT `position` FROM `players` WHERE `username`='{$_GET['to']}'";
$result=mysql_query($query);
$result=mysql_result($result,0);
list($x1,$y1)=explode(',',$result);
list($x2,$y2)=explode(',',$player['position']);
$dist=sqrt((($x1-$x2)*($x1-$x2))+(($y1-$y2)*($y1-$y2)));
$outhour=$dist/$fph;
$time=round($outhour*3600);

#echo $time;
$time=time()+$time;

$query="UPDATE `players` SET `units` = '$troops' WHERE `username` ='$username' LIMIT 1";
$result=mysql_query($query);

$query="INSERT INTO `attacks` ( `index` , `to` , `from` , `troops` , `time` , `resources` ) VALUES (NULL , '{$_GET['to']}', '$username', '$force', '$time', '')";
$result=mysql_query($query);

$url = "attacks.php";
echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL='.$url.'">';
?>