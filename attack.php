<?php include('ingamehead.php');
$query="SELECT * FROM `players` WHERE `username`='$username'";

$player=mysql_query($query);
$player=mysql_fetch_array($player);
$civ=$player['civ'];
?>

<h1>Attack</h1>
Player:<b> <?php echo $_GET['to'].$_POST['to'];?></b>
<br/><br/>
<?php
if ($_POST['work']!='yes'){
?>
<form action="attack.php" method="post">
			<b>Troops</b><br/>
			<br/>
			<table width="90%" cellpadding="0" cellspacing="0">
			<?php
			$query="SELECT `units` FROM `players` WHERE `username`='$username'";
			$result=mysql_query($query);
			$result=mysql_result($result,0);
			$unitse=explode('|',$result);

			$switch='f';
			foreach ($unitse as $unite){
				if ($switch=='f'){
					$switch='s';
					$save=$unite;
				}else{
					$playerunit[$save]=$unite;
					$switch='f';
				}
			}
			
			$query="SELECT * FROM `units` WHERE `civ`='$civ'";
			$result=mysql_query($query);
			while ($unit=mysql_fetch_array($result)){
				echo '<tr><td>'.$unit['name'].'</td><td><input class="boxes" type="text" size="3" style="padding:0 0 0 3px" name="att|'.$unit['abbr'].'" /> ('.intval($playerunit[$unit['abbr']]).')</td>';
			}
			?>
			</table>

	<br/>
	<input type="hidden" name="work" value="yes" />
	<input type="hidden" name="to" value="<?php echo $_GET['to'];?>" />
	<input type="submit" value="Go" />
	</form>
<?php
}else{
?>
<table width="100%" cellpadding="1" cellspacing="0" border="1">
		<tr><th>Troops</th><?php
		$query="SELECT * FROM `units` WHERE `civ`='$civ'";
				$result=mysql_query($query);
				while ($unit=mysql_fetch_array($result)){
					echo '<td><img src="units/'.$unit['picture'].'" alt="'.$unit['abbr'].'" /></td>';
				}
		?></tr>
		<tr><td>Troops</td><?php
		$fph=10000;
		$query="SELECT * FROM `units` WHERE `civ`='$civ'";
				$result=mysql_query($query);
				while ($unit=mysql_fetch_array($result)){
					if ($_POST['att|'.$unit['abbr']]==''){
						echo '<td><font color="#BBBBBB">0</font></td>';
					}else{
						echo '<td>'.$_POST['att|'.$unit['abbr']].'</td>';
						if ($fph>$unit['speed']){
							$fph=$unit['speed'];
						}
					}
				}
		?></tr></table>
		<br/>
		<b>Time:</b> <?php
		$query="SELECT `position` FROM `players` WHERE `username`='{$_POST['to']}'";
		$result=mysql_query($query);
		$result=mysql_result($result,0);
		list($x1,$y1)=explode(',',$result);
		list($x2,$y2)=explode(',',$player['position']);
		$dist=sqrt((($x1-$x2)*($x1-$x2))+(($y1-$y2)*($y1-$y2)));
		$outhour=$dist/$fph;
		$time=round($outhour*3600);
		$tmp=date('G',$time);
		$tmp-=1;
		echo $tmp.date(':i:s',$time);
		?>
		<form action="sendtroops.php?to=<?php echo $_POST['to'];?>" method="post">
		<?php
		$query="SELECT * FROM `units` WHERE `civ`='$civ'";
		$result=mysql_query($query);
		while ($unit=mysql_fetch_array($result)){
			if ($_POST['att|'.$unit['abbr']] != ''){
				echo '<input type="hidden" size="3" name="'.$unit['abbr'].'" value="'.$_POST['att|'.$unit['abbr']].'" />'."\n\r";
			}
		}
		?>
		<!--<input type="hidden" name="to" value="<?php echo $_POST['to'];?>" />-->
		<input type="submit" value="Attack" />
		</form>
<?php
}

?>	

</div>

<div id="right">
<?php include('stat.php'); ?>

<?php include('foot.php'); ?>