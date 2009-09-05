<?php 
include('ingamehead.php');
$query="SELECT * FROM `players` WHERE `username`='$username'";
$result=mysql_query($query);
$userresult=mysql_fetch_array($result);

$query="SELECT * FROM `alliance` WHERE `name`='$alliance'";
$result=mysql_query($query);
$allianceresult=mysql_fetch_array($result);


$privi=explode('|',$userresult['allianceoptions']);

foreach ($privi as $priv){
	$opt[$priv]='yes';
}
?>

<h1>Allaince Options</h1>
<a href="alliance.php">Overview</a> | 
<a href="allianceoptions.php">Options</a>


<?php
$opto=$_POST['option'];


	if ($opto == 'quit'){
		if (md5($_POST['password']) == $userresult['password']){
			$query="UPDATE `players` SET `alliance`='',`allianceoptions`='' WHERE `username`='$username'";
			$result=mysql_query($query);
			echo '';
		}
	}

	if ($opt['in'] == 'yes' || $opt['all'] == 'yes'){
		if ($opto == 'invite'){
			$alliance=$userresult['alliance'];
			$query="INSERT INTO `invitations` ( `id` , `to` , `alliance` ) VALUES (NULL , '{$_POST['player']}', '$alliance')";
			$result=mysql_query($query);
			echo 'You have invited '.$_POST['player'];
		}
	}
	
	if ($opt['ki'] == 'yes' || $opt['all'] == 'yes'){
		if ($opto == 'kick'){
			if (md5($_POST['password']) == $userresult['password']){
				$query="UPDATE `players` SET `alliance`='', `allianceoptions`='' WHERE `username`='{$_POST['player']}'";
				$result=mysql_query($query);
				echo 'You have kicked '.$_POST['player'];
			}
		}
	}
	?>	
		<br/><br/>
		<b>Quit Alliance</b>
		<form action="allianceoptions.php" method="post">
		Password (for security): <input type="password" name="password"><br/>
		<input type="hidden" name="option" value="quit">
		<input type="submit" value="Quit alliance"><br/><br/>
		</form>
	<?php

if ($opt['in'] == 'yes' || $opt['all'] == 'yes'){
	?>
		<b>Invite player</b>
		<form action="allianceoptions.php" method="post">
		Invite Player: <input type="text" name="player"><br/>
		<input type="hidden" name="option" value="invite">
		<input type="submit" value="Invite"><br/><br/>
		</form>
	<?php
}

if ($opt['ki'] == 'yes' || $opt['all'] == 'yes'){
	?>
		<b>Kick player</b>
		<form action="allianceoptions.php" method="post">
		Kick Player: <input type="text" name="player"><br/>
		Password (for security): <input type="password" name="password"><br/>
		<input type="hidden" name="option" value="kick">
		<input type="submit" value="Kick"><br/><br/>
		</form>
	<?php
}

if ($opt['de'] == 'yes' || $opt['all'] == 'yes'){
	?>
		<b>Change description</b>
		<form action="allianceoptions.php" method="post">
		<textarea cols="50" rows="7"><?php echo $allianceresult['description'];?></textarea><br/>
		<input type="hidden" name="option" value="kick">
		<input type="submit" value="Change"><br/><br/>
		</form>
	<?php
}

if ($opt['pr'] == 'yes' || $opt['all'] == 'yes'){
	?>	
		<form action="privs.php" method="post">
		<b>Set privileges</b><br/>
		Player: <input type="text" name="player"><br/>
		<input type="submit" value="Change Privileges"><br/><br/>
		</form>
	<?php
}

?>
</div>

<div id="right">
<?php include('stat.php'); ?>

<?php include('foot.php'); ?>