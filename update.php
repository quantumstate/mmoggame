<?php

include('dbinfo.php');


$time=time();
$query="SELECT * FROM `players`";
#echo $query;
$result=mysql_query($query);
#echo $result;

while ($job=mysql_fetch_array($result)){
	$username=$job['username'];

	
	$query="SELECT `resourcefields` FROM `players` WHERE `username`='$username'";
	$buildings=mysql_query($query);
	$buildings=mysql_result($buildings,0);
	$buildings=explode('|',$buildings);

	$j=0;
	foreach ($buildings as $i){
		$j++;
		switch ($i){
		case 'w':
			$w+=((2*$buildings[$j]*$buildings[$j])-($buildings[$j]*2))+5;
		break;
		case 's':
			$s+=((2*$buildings[$j]*$buildings[$j])-($buildings[$j]*2))+5;
		break;
		case 'b':
			$b+=((2*$buildings[$j]*$buildings[$j])-($buildings[$j]*2))+5;
		break;
		case 'c':
			$c+=((2*$buildings[$j]*$buildings[$j])-($buildings[$j]*2))+5;
		break;
		case 'g':
			$g+=(((2*$buildings[$j]*$buildings[$j])-($buildings[$j]*2))+5);
		break;
		}
		$resourcesr.=$i.'|';
	}
			
					
	$resourcesr=trim($resourcesr,'|');
	$production=$w.'|'.$s.'|'.$b.'|'.$c.'|'.$g;
	
	$query="UPDATE `players` SET `resourcefields` = '$resourcesr',`production` = '$production' WHERE `username`='$username' LIMIT 1";
	echo $query.'<br>';
	$resulter=mysql_query($query);

	$w=0;
	$s=0;
	$b=0;
	$c=0;
	$g=0;
	
	$production='';
	$resourcesr='';
}

?>