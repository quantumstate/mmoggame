<br/><u><b>Production</b></u><br/>
<?php
$query="SELECT * FROM `players` WHERE `username`='$username'";
$result=mysql_query($query);
$result=mysql_fetch_array($result);

list($woodprod,$stoneprod,$bronzeprod,$wheatprod,$coinprod)=explode('|',$result['production']);

list($wood,$woodlimit,$stone,$stonelimit,$bronze,$bronzelimit,$wheat,$wheatlimit,$coin,$coinlimit,$pop,$poplimit)=explode('|',$result['resources']);
$coinprod-=$pop+$result['unitpop'];

echo "Wood: <b>$woodprod</b> per hour<br/>";
echo "Stone: <b>$stoneprod</b> per hour<br/>";
echo "Bronze: <b>$bronzeprod</b> per hour<br/>";
echo "Wheat: <b>$wheatprod</b> per hour<br/>";
echo "Coin: <b>$coinprod</b> per hour<br/>";
?>