<?php include('head.php'); ?>
<?php
include('dbinfo.php');

if (isset($_POST['submitted'])){
	$username=$_POST['username'];
	$query="SELECT * FROM `players` WHERE `username`='$username'";
	$result=mysql_query($query);
	if (mysql_num_rows($result)>0){
		echo '</div>';
		$url = "register.php?error=This username has already been taken.";
		echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL='.$url.'">';
	}else{
	if ($username !=''){
		$pattern='/[\'"]/';
		if (preg_match($pattern, $username)==false){
		if ($_POST['email']!=''){
			if ($_POST['civ']!=''){
				if ($_POST['terms']!=''){
						
						$passarray=str_split(md5($username),10);
						$pass=strrev($passarray[1]);
						$pass=md5($pass);
						
						$email=$_POST['email'];
						$civ=$_POST['civ'];
						$online=time();
						
						$resource='s|c|w|g|b|g|w|b|s|b|g|w|c|g|s|c|g|b|g|w|s|b|g|w';
						$resource=explode('|',$resource);
						shuffle($resource);
						foreach ($resource as $res){
							$resourcefields.=$res.'|1|';
						}
						
						$i='loop';
						while ($i=='loop'){
							$x=rand(-10,10);
							$y=rand(-10,10);
							$query="SELECT `terrain` FROM `map` WHERE `x`=$x AND `y`=$y";
							$result=mysql_query($query);
							$result=mysql_result($result,0);
							if ($result!='v'){
								$i='stop';
							}
						}
						
						$query="UPDATE `map` SET `terrain`='v', `player`='$username' WHERE `x`=$x AND `y`=$y";
						$result=mysql_query($query);
						
						$ip=$_SERVER['REMOTE_ADDR'];

						$query="INSERT INTO `players` VALUES ('','$username','$pass','$email','$online','$ip','$civ','25|20|25|15|35','1500|1500|1500|1500|1500|1500|1500|1500|1500|1500|15|35','tc|1|ba|0|st|0|mg|0|sw|0|wa|1|bk|1|dg|0','','mil|maccav|hop|pel','','$x,$y','','$resourcefields','','','15','','','')";
						$result=mysql_query($query);
						#echo $query; #debug value
						
						$query="SELECT * FROM `players` WHERE 1";
						$result=mysql_query($query);
						$users=mysql_num_rows($result);
						#echo $users; #debug value
						include('stats.php');
						$fp = fopen( "stats.php" , "w" );
						
						$inputstring="<?php\r\n\$registeredusers=$users;\r\n\$onlineusers=$onlineusers;\r\n?>";
						fwrite( $fp, $inputstring );
						fclose( $fp );
						
						$subject="Welcome to mmog";
						$text="Thankyou for signing up to mmog.\r\n\r\nYour password is $pass we suggest that you change this when you log in.";
						mail($email, $subject, $text, 'From: noreply@therisen.com');
						echo "<h1>Registration successful</h1>Registration successful.  Please check your email account for your password.\r\n";
						echo "<br/><br/>Contents of registration email (mailserver will be running when this gets put on a host):<br/>$text</div>";

				}else{
					$url = "register.php?error=You must accept the terms and conditions to be able to play.";
					echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL='.$url.'">';
				}
			}else{
				$url = "register.php?error=Please choose a civilisation.";
				echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL='.$url.'">';
			}
		}else{
			$url = "register.php?error=Please enter an email address.";
			echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL='.$url.'">';
		}
		}else{
			$url = "register.php?error=Please do not include ' or &#34; in your username.";
			echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL='.$url.'">';
		}
	}else{
		$url = "register.php?error=Please enter a username.";
		echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL='.$url.'">';
	}
	}
}else{
?>

<h1>Register</h1>
<?php if (isset($_GET['error'])){echo '<font color="red">'.stripslashes($_GET['error']).'<br/><br/></font>';}?>
<form action="register.php" method="post">
Username: <input type="text" name="username" class="boxes" style="margin-left:30px;margin-bottom:3px;" /><br/>
Email: <input type="text" name="email" class="boxes" style="margin-left:61px;margin-bottom:3px;" />
<br/>
<br/>
<u><b>Choose a Civilisation</b></u><br/>
<input type="radio" name="civ" value="1" />Phonecian<br/>
<input type="radio" name="civ" value="2" />Carthaginian<br/>
<input type="radio" name="civ" value="3" />Greek<br/>
<input type="radio" name="civ" value="4" />Egyptian<br/>
<br/>
<br/>
<input type="checkbox" name="terms" value="yes" />I accept the Term and Conditions and Rules of the game<br/>
<input type="hidden" name="submitted" value="set" />
<br/>
<input type="submit" value="Register" style="margin-left:140px;" />
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