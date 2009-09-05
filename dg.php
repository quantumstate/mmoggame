<?php include('ingamehead.php'); ?>
<?php
$query="SELECT * FROM `players` WHERE `username`='$username'";
$result=mysql_query($query);
$userresult=mysql_fetch_array($result);

$buildings=explode('|',$userresult['buildings']);

foreach ($buildings as $building){
	if ($next=='set'){
		$dglvl=$building;
		$next='unset';
	}
	if ($building=='dg'){
		$next='set';
	}
	#echo $building.'<br/>';
}
?>
<h1>Diplomats Guild level <?php echo $dglvl; ?></h1>
<?php
if ($dglvl==0){
	echo 'You shouldn\'t be here.  Go away!';
}elseif ($dglvl<3){
	if ($userresult['alliance']==''){
		$query="SELECT * FROM `invitations` WHERE `to`='$username'";
		$result=mysql_query($query);
		if (mysql_num_rows>0){
			echo 'Invitations:<br/>';
			while ($invite=mysql_fetch_array($result)){
				echo '<a href="alliance.php?name='.$invite['alliance'].'">Accept invitation from '.$invite['alliance'].'</a><br/>';
			}
			
		}else{
			echo 'You have no invitations.<br/><br/>If you wish to make an alliance please upgrade your Diplomats guild to level 3.';
		}		
	}else{
		echo "Your alliance is {$userresult['alliance']}<br/>";
		echo "<a href=\"alliance.php?name={$userresult['alliance']}\">Go to the alliance menu</a>";
	}
}else{
	if ($userresult['alliance']==''){
		$query="SELECT * FROM `invitations` WHERE `to`='$username'";
		$result=mysql_query($query);
		if (mysql_num_rows($result)>0){
			echo 'Invitations:<br/>';
			while ($invite=mysql_fetch_array($result)){
				echo '<a href="joinalliance.php?name='.$invite['alliance'].'">Accept invitation from '.$invite['alliance'].'</a><br/>';
			}
			
		}else{
			echo 'You have no invitations.';
		}
		?>
		<br/><br/>
		<b>Found an alliance</b><br/>
		<form action="newalliance.php" method="post">
		Name:<input type="text" name="name" class="boxes" style="margin-top:10px;"><br/>
		<input type="submit" value="Found alliance" style="margin-top:10px;">
		</form>
		<?php
	}else{
		echo "Your alliance is {$userresult['alliance']}<br/>";
		echo "<a href=\"alliance.php?name={$userresult['alliance']}\">Go to the alliance menu</a>";
	}
}
?>
</div>

<div id="right">
<?php include('stat.php'); ?>

<?php include('foot.php'); ?>
