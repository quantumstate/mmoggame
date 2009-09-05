<?php include('ingamehead.php'); ?>
<?php
include('dbinfo.php');

$username=$_SESSION['username'];
$query="SELECT * FROM `players` WHERE `username`='$username'";
$result=mysql_query($query);
$result=mysql_fetch_array($result);


if (isset($_POST['submitted'])){
		if (($result['password'] == $_POST['password']) || ($result['password'] == md5($_POST['password']))){
			$email=$_POST['email'];
			$newpassword=md5($_POST['newpassword']);
			$query="UPDATE `players` SET `password`='$newpassword', `email`='$email' WHERE `username`='$username' LIMIT 1";
			$result=mysql_query($query);
			
			echo '</div>';
			$url = "game.php";
			echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL='.$url.'">';
			die();
		}else{
			echo '</div>';
			$url = "settings.php?error=Wrong password please try again.";
			echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL='.$url.'">';
			die();
		}
}else{
?>

<h1>Settings</h1>
<?php if (isset($_GET['error'])){echo '<font color="red">'.$_GET['error'].'<br/><br/></font>';}?>
<form action="settings.php" method="post">
Email Address: <input type="text" value="<?php echo $result['email'];?>" name="email" class="boxes" style="margin-left:32px;margin-bottom:3px;" /><br/>
New Password: <input type="password" name="newpassword" class="boxes" style="margin-left:27px;margin-bottom:3px;" />
<br/>
<br/>
Old Password(for security): <input type="password" name="password" class="boxes" style="margin-left:34px;margin-bottom:3px;" /><br/>
<input type="hidden" name="submitted" value="set" />
<input type="submit" value="Change Settings" style="margin-left:142px;" />
</form>
</div>

<?php
}
?>


<div id="right">
<p><u><b>Statistics</b></u>
<br/>
<?php include('stats.php'); ?>
Users Registered :<?php echo $registeredusers;?> <br/>
Users Online :<?php echo $onlineusers;?> <br/>
</p>

<?php include('foot.php'); ?>