<?php include('ingamehead.php'); ?>

<h1><?php echo $_SESSION['username'];?>'s town</h1>
<div style="position:absolute;top:447px;left:132px;margin:0;">
<?php
$query="SELECT * FROM `players` WHERE `username`='$username'";
$userresult=mysql_query($query);
$userresult=mysql_fetch_array($userresult);
$user=explode('|',$userresult['buildings']);

if ($userresult['resourceconstruction']!=''){
	$construction=explode('|',$userresult['resourceconstruction']);
	$temp=$construction[0];
	
	$bldname=explode('|',$userresult['resourcefields']);
	$bldname=$bldname[$temp];
	switch ($bldname){
		case 'w':
			$bldname='Woodcutter';
		break;
		case 's':
			$bldname='Stone Quarry';
		break;
		case 'b':
			$bldname='Bronze Mine';
		break;
		case 'g':
			$bldname='Gold Mine';
		break;
		case 'c':
			$bldname='Wheat Farm';
		break;
	}
	
	$temp=$construction[1];
	$finishtime=date("G:i:s",$construction[2]);
	echo '<b>Current construction</b><br/>';
	$on='yes';
	echo "$bldname (level $temp) &nbsp;&nbsp;&nbsp;&nbsp;Finished at $finishtime<br/><br/>";
}
if ($userresult['construction']!=''){
	$construction=explode('|',$userresult['construction']);
	$temp=$construction[0];
	
	$query="SELECT `name` FROM `buildings` WHERE `abbr`='$temp'";
	$bldname=mysql_query($query);
	$bldname=mysql_result($bldname,0);
	
	if ($on != 'yes'){
		echo '<b>Current construction</b><br/>';
	}
	
	$temp=$construction[1];
	$finishtime=date("G:i:s",$construction[2]);
	echo "$bldname (level $temp) &nbsp;&nbsp;&nbsp;&nbsp;Finished at $finishtime<br/><br/>";
}

?>
</div>
<div style="position:absolute;top:217px;left:132px;margin:0;">
<?php
$username=$_SESSION['username'];

$query="SELECT `resourcefields` FROM `players` WHERE `username`='$username'";
$buildings=mysql_query($query);
$buildings=mysql_result($buildings,0);

$fldcount=0;
$fields=explode('|',$buildings);
for ($i=0;$i<=2;$i++){
for ($j=0;$j<=3;$j++){
echo '<img border="0" src="resources/'.current($fields).'.gif"/>';
next($fields);
next($fields);
}
echo '<br/>';
}
?>

</div>
<div style="position:absolute;top:247px;left:172px;margin:0;">
<?php
for ($i=0;$i<=2;$i++){
for ($j=0;$j<=3;$j++){
echo '<img src="resources/'.current($fields).'.gif"/>';
next($fields);
next($fields);
}
echo '<br/>';
}
?>
</div>
<div style="position:absolute;top:219px;left:134px;margin:0;width:350px;height:210px;">
<?php
reset($fields);
next($fields);
for ($i=0;$i<=2;$i++){
for ($j=0;$j<=3;$j++){
echo '<div style="float:left;width:33px;height:35px;font-size:160%;color:black;margin:13px 23px 11px 21px;text-align:center;">';
echo '<a href="bldresource.php?field='.$fldcount.'" style="text-decoration:none;color:black;">'.current($fields).'</a>';
echo '</div>';
$fldcount+=2;
next($fields);
next($fields);
}
}
?>
</div>
<div style="position:absolute;top:249px;left:174px;margin:0;width:350px;height:1px;overflow:visible;">
<?php

for ($i=0;$i<=2;$i++){
for ($j=0;$j<=3;$j++){
echo '<div style="float:left;width:33px;height:35px;font-size:160%;color:black;margin:13px 23px 11px 21px;text-align:center;">';
echo '<a href="bldresource.php?field='.$fldcount.'" style="text-decoration:none;color:black;">'.current($fields).'</a>';
echo '</div>';
$fldcount+=2;
next($fields);

next($fields);
}
}
?>
</div>
</div>

<div id="right">
<?php include('stat.php'); ?>
<?php include('resourcestat.php');?>
<?php include('unitstat.php');?>

<?php include('foot.php'); ?>