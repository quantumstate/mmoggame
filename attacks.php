<?php include('ingamehead.php'); ?>

<h1><?php echo $_SESSION['username'];?>'s town</h1>

<?php
$query="SELECT * FROM `attacks` WHERE `to`='$username'";
$userresult=mysql_query($query);
#$attacks=mysql_fetch_array($userresult);

while ($attack=mysql_fetch_array($userresult)){
	if ($attack['to']==$attack['from']){
		$reinforcement.="<tr><td>".date('G:i:s',$attack['time'])."</td></tr>";
	}
}
?>

</div>

<div id="right">
<?php include('stat.php'); ?>
<?php include('resourcestat.php');?>
<?php include('unitstat.php');?>

<?php include('foot.php'); ?>