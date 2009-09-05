<p><u><b>Statistics</b></u>
<br/>
<?php include('dbinfo.php');include('stats.php'); ?>
Users Registered :<?php echo $registeredusers;?> <br/>
Users Online :<?php 
$time=time()-900;
$query="SELECT * FROM `players` WHERE `online` > $time";
#echo $query;
$result=mysql_query($query);
$onlineusers=mysql_num_rows($result);
echo $onlineusers;
?> <br/>
</p>