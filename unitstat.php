<br/><u><b>Units</b></u><br/>
<?php
$query="SELECT `units` FROM `players` WHERE `username`='$username'";
$result=mysql_query($query);
$result=mysql_result($result,0);
$units=explode('|',$result);

$switch='f';
foreach ($units as $unit){
	if ($switch=='f'){
		$switch='s';
		$query="SELECT * FROM `units` WHERE `abbr`='$unit'";
		$result=mysql_query($query);
		$result=mysql_fetch_array($result);
		echo '<img src="units/'.$result['picture'].'" alt="'.$result['name'].'" />'.$result['name'].' <b>';
	}else{
		echo $unit.'</b><br/>';
		$switch='f';
	}
}

?>