<?php include('ingamehead.php'); ?>

<h1><?php echo $_SESSION['username'];?>'s town</h1>
<a href="igm.php">Inbox</a> | <a href="writeigm.php">Write</a> | <a href="igm.php?b=from">Sent</a><br/><br/>
<?php
	$query="SELECT * FROM `igm` WHERE `id`='{$_GET['id']}'";
	
	$result=mysql_query($query);
	$igm=mysql_fetch_array($result);
	if ($igm['to']==$username || $igm['from']==$username){
	$query="UPDATE `igm` SET `read`='yes' WHERE `id`='{$_GET['id']}'";
	$result=mysql_query($query);
	
	echo '<b>To:</b> '.$igm['to'].'<br/>';
	echo '<b>From:</b> '.$igm['from'].'<br/>';
	echo '<b>Subject:</b> '.$igm['subject'].'<br/>';
	echo '<b>Message:</b> '.$igm['content'].'<br/><br/>';
	echo '<a href="writeigm.php?to='.$igm['from'].'">Reply</a>';
	}
	?>


</div>

<div id="right">
<?php include('stat.php'); ?>

<?php include('foot.php'); ?>
