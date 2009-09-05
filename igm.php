<?php include('ingamehead.php'); ?>

<h1><?php echo $_SESSION['username'];?>'s town</h1>
<a href="igm.php">Inbox</a> | <a href="writeigm.php">Write</a> | <a href="igm.php?b=from">Sent</a><br/><br/>
<table width="95%" border="1">
	<tr>
		<th width="25%"><?php if (isset($_GET['b'])){echo 'To';}else{echo 'From';}?></th>
		<th width="50%">Subject</th>
		<th width="25%">Sent</th>
	</tr>
	<?php
	$box='to';
	if (isset($_GET['b'])){
		$box=$_GET['b'];
	}
	$query="SELECT * FROM `igm` WHERE `$box`='$username' ORDER BY `time` DESC";
	$result=mysql_query($query);
	
	if ($box=='to'){
	$box='from';
	}else{
	$box='to';
	}
	while ($message=mysql_fetch_array($result)){
		$b='';
		$be='';
		if ($box=='to'){
			if ($message['read']==''){
			$b='(not read)';
			}
		}else{
			if ($message['read']==''){
			$b='<b>';
			$be='</b>';
			}
		}
		echo '<tr><td>'.$message[$box].'</td><td><a href="viewigm.php?id='.$message['id'].'">'.$b.$message['subject'].$be.'</a></td><td><a href="viewigm.php?id='.$message['id'].'">'.date('d.m.y H:i',$message['time']).'</a></td>';
	}
	?>
</table>
</div>

<div id="right">
<?php include('stat.php'); ?>

<?php include('foot.php'); ?>