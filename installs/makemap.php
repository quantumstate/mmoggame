<?php 
include('dbinfo.php');

for ($x=-10;$x<=10;$x++){
for ($y=-10;$y<=10;$y++){	
$query="INSERT INTO `map` ( `id` , `terrain` , `player` , `x` , `y` ) VALUES (NULL , 'g', '', '$x', '$y')";
$result=mysql_query($query);
}
}
?>