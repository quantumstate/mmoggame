<?php include('head.php'); ?>

<h1>Online Users</h1>
<?php 
include('dbinfo.php');
$time=time()-900;
$query="SELECT * FROM `players` WHERE `online` > $time";
#echo $query;
$result=mysql_query($query);
while ($job=mysql_fetch_array($result)){
echo $job['username'].'<br/>';
}
?>

</div>

<div id="right">
<?php include('stat.php'); ?>

<?php include('foot.php'); ?>