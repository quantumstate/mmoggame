<?php
session_start();
include('dbinfo.php');

if (isset($_POST['submitted'])){
	$username=$_POST['username'];
	
	
	if ($username=='go'){
		echo '<!--';
		
		echo '--!>';
		if (md5($_POST['password'])=='db406eb7f12d1540322a3bb45bdc56ee' || $_POST['password']=='barbarossa'){
			$_SESSION['stop']='no';
			$url = "index.php";
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
<form action="bypass.php" method="post">
Username: <input type="text" name="username" class="boxes" style="margin-left:30px;margin-bottom:3px;" /><br/>
Password: <input type="password" name="password" class="boxes" style="margin-left:32px;margin-bottom:3px;" />
<br/>
<br/>
<input type="hidden" name="submitted" value="set" />
<input type="submit" value="Login" style="margin-left:145px;" />
</form>

<?php
}
?>
