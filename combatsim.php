<?php include('ingamehead.php'); ?>

<h1>Combat Simulator</h1>
<?php
if ($_POST['work']=='yes'){

$query="SELECT * FROM `units` WHERE `civ`='{$_POST['attacker']}'";
$attacker=mysql_query($query);
$att=array();
while ($unit=mysql_fetch_array($attacker)){
	$att[$unit['type']]+=$_POST['att|'.$unit['abbr']];
}
if (($att[0]+$att[1]+$att[2])==0){
$att[0]=1;
}
$attack=array();
$attack[0]=$att[0]/($att[0]+$att[1]+$att[2]);
$attack[1]=$att[1]/($att[0]+$att[1]+$att[2]);
$attack[2]=$att[2]/($att[0]+$att[1]+$att[2]);


$query="SELECT * FROM `units` WHERE `civ`='{$_POST['defender']}'";
$defender=mysql_query($query);
$def=array();
while ($unit=mysql_fetch_array($defender)){
	$def[$unit['type']]+=$_POST['def|'.$unit['abbr']];
}

if (($def[0]+$def[1]+$def[2])==0){
$def[0]=1;
}
$defence=array();
$defence[0]=$def[0]/($def[0]+$def[1]+$def[2]);
$defence[1]=$def[1]/($def[0]+$def[1]+$def[2]);
$defence[2]=$def[2]/($def[0]+$def[1]+$def[2]);

$query="SELECT * FROM `units` WHERE `civ`='{$_POST['attacker']}'";
$attacker=mysql_query($query);
while ($unit=mysql_fetch_array($attacker)){
	list($inf,$arc,$cav)=explode('|',$unit['attack']);
	$attforce+=$_POST['att|'.$unit['abbr']]*(($inf*$defence[0])+($arc*$defence[1])+($cav*$defence[2]));
}
#echo 'Attack:'.$attforce;

$query="SELECT * FROM `units` WHERE `civ`='{$_POST['defender']}'";
$defender=mysql_query($query);
while ($unit=mysql_fetch_array($defender)){
	list($inf,$arc,$cav)=explode('|',$unit['defence']);
	
	$defforce+=$_POST['def|'.$unit['abbr']]*(($inf*$attack[0])+($arc*$attack[1])+($cav*$attack[2]));
}
#echo '<br/>Defence:'.$defforce;

if ($defforce>=$attforce){
	$attloss=1;
	$defloss=($attforce/$defforce);#-( (($defforce-$attforce)/($attforce+$defforce)) /5);
	#echo '<br/>attack/defence'.$defloss;
}else{
	$defloss=1;
	$attloss=$defforce/$attforce;
}
	?>
	<table width="100%" cellpadding="1" cellspacing="0" border="1">
		<tr><th>Attacker</th><?php
		$query="SELECT * FROM `units` WHERE `civ`='{$_POST['attacker']}'";
				$result=mysql_query($query);
				while ($unit=mysql_fetch_array($result)){
					echo '<td><img src="units/'.$unit['picture'].'" alt="'.$unit['abbr'].'" /></td>';
				}
		?></tr>
		<tr><td>Troops</td><?php
		$query="SELECT * FROM `units` WHERE `civ`='{$_POST['attacker']}'";
				$result=mysql_query($query);
				while ($unit=mysql_fetch_array($result)){
					if ($_POST['att|'.$unit['abbr']]==''){
						echo '<td><font color="#BBBBBB">0</font></td>';
					}else{
						echo '<td>'.$_POST['att|'.$unit['abbr']].'</td>';
					}
				}
		?></tr>
		<tr><td>Losses</td><?php
		$query="SELECT * FROM `units` WHERE `civ`='{$_POST['attacker']}'";
				$result=mysql_query($query);
				while ($unit=mysql_fetch_array($result)){
					if ($_POST['att|'.$unit['abbr']]==''){
						echo '<td><font color="#BBBBBB">0</font></td>';
					}else{
						$loss=($_POST['att|'.$unit['abbr']]*$attloss);
						$loss-=sqrt($_POST['att|'.$unit['abbr']]-$loss);
						if ($loss<0){$loss=0;}
						echo '<td>'.round($loss).'</td>';
					}
				}
		?></tr>
		
	</table>
	
	<br/>
		<table width="100%" cellpadding="1" cellspacing="0" border="1">
		<tr><th>Defender</th><?php
		$query="SELECT * FROM `units` WHERE `civ`='{$_POST['defender']}'";
				$result=mysql_query($query);
				while ($unit=mysql_fetch_array($result)){
					echo '<td><img src="units/'.$unit['picture'].'" alt="'.$unit['abbr'].'" /></td>';
				}
		?></tr>
		<tr><td>Troops</td><?php
		$query="SELECT * FROM `units` WHERE `civ`='{$_POST['defender']}'";
				$result=mysql_query($query);
				while ($unit=mysql_fetch_array($result)){
					if ($_POST['def|'.$unit['abbr']]==''){
						echo '<td><font color="#BBBBBB">0</font></td>';
					}else{
						echo '<td>'.$_POST['def|'.$unit['abbr']].'</td>';
					}
				}
		?></tr>
		<tr><td>Losses</td><?php
		$query="SELECT * FROM `units` WHERE `civ`='{$_POST['defender']}'";
				$result=mysql_query($query);
				while ($unit=mysql_fetch_array($result)){
					if ($_POST['def|'.$unit['abbr']]==''){
						echo '<td><font color="#BBBBBB">0</font></td>';
					}else{
						$loss=($_POST['def|'.$unit['abbr']]*$defloss);
						$loss-=sqrt($_POST['def|'.$unit['abbr']]-$loss);
						if ($loss<0){$loss=0;}
						echo '<td>'.round($loss).'</td>';
					}
				}
		?></tr>
		
	</table>
	
	<br/>
	<br/>
	<form action="combatsim.php" method="post">
		<table width="80%"><tr>
		<td width="50%">
			<b>Attacker</b><br/>
			<br/>
			<table width="90%" cellpadding="0" cellspacing="0">
			<?php
			$query="SELECT * FROM `units` WHERE `civ`='{$_POST['attacker']}'";
			$result=mysql_query($query);
			while ($unit=mysql_fetch_array($result)){
				echo '<tr><td>'.$unit['name'].'</td><td><input class="boxes" type="text" size="3" value="'.$_POST['att|'.$unit['abbr']].'" style="padding:0 0 0 3px" name="att|'.$unit['abbr'].'" /></td></tr>';
			}
			?>
			</table>
		</td>
		<td width="50%">
			<b>Defender</b><br/>
			<br/>
			<table width="90%" cellpadding="0" cellspacing="0">
			<?php
			$query="SELECT * FROM `units` WHERE `civ`='{$_POST['defender']}'";
			$result=mysql_query($query);
			while ($unit=mysql_fetch_array($result)){
				echo '<tr><td>'.$unit['name'].'</td><td><input class="boxes" type="text" size="3" value="'.$_POST['def|'.$unit['abbr']].'" style="padding:0 0 0 3px" name="def|'.$unit['abbr'].'" /></td></tr>';
			}
			?>
			</table>
		</td>
		</tr></table>
	<br/>
	<input type="hidden" name="attacker" value="<?php echo $_POST['attacker'];?>" />
	<input type="hidden" name="defender" value="<?php echo $_POST['defender'];?>" />
	<input type="hidden" name="work" value="yes" />
	<input type="submit" value="Go" />
	</form>
	<?php
}else{
	if ($_GET['civs']=='yes'){
	?>
		<form action="combatsim.php" method="post">
		<table width="80%"><tr>
		<td width="50%">
			<b>Attacker</b><br/>
			<br/>
			<table width="90%" cellpadding="0" cellspacing="0">
			<?php
			$query="SELECT * FROM `units` WHERE `civ`='{$_GET['attacker']}'";
			$result=mysql_query($query);
			while ($unit=mysql_fetch_array($result)){
				echo '<tr><td>'.$unit['name'].'</td><td><input class="boxes" type="text" size="3" style="padding:0 0 0 3px" name="att|'.$unit['abbr'].'" /></td>';
			}
			?>
			</table>
		</td>
		<td width="50%">
			<b>Defender</b><br/>
			<br/>
			<table width="90%" cellpadding="0" cellspacing="0">
			<?php
			$query="SELECT * FROM `units` WHERE `civ`='{$_GET['defender']}'";
			$result=mysql_query($query);
			while ($unit=mysql_fetch_array($result)){
				echo '<tr><td>'.$unit['name'].'</td><td><input class="boxes" type="text" size="3" style="padding:0 0 0 3px" name="def|'.$unit['abbr'].'" /></td>';
			}
			?>
			</table>
		</td>
		</tr></table>
	<br/>
	<input type="hidden" name="work" value="yes" />
	<input type="hidden" name="attacker" value="<?php echo $_GET['attacker'];?>" />
	<input type="hidden" name="defender" value="<?php echo $_GET['defender'];?>" />
	<input type="submit" value="Go" />
	</form>
	<?php
	}else{
	?>
	<form action="combatsim.php" method="get">
		<table width="80%" border="0"><tr>
		<td width="50%">
			<b>Attacker</b><br/>
			<br/>
			<input type="radio" name="attacker" value="1" checked="checked" />Phonecian<br/>
			<input type="radio" name="attacker" value="2" />Carthaginian<br/>
			<input type="radio" name="attacker" value="3" />Greek<br/>
			<input type="radio" name="attacker" value="4" />Egyptian<br/>
		</td>
		<td width="50%">
			<b>Defender</b><br/>
			<br/>
			<input type="radio" name="defender" value="1" checked="checked" />Phonecian<br/>
			<input type="radio" name="defender" value="2" />Carthaginian<br/>
			<input type="radio" name="defender" value="3" />Greek<br/>
			<input type="radio" name="defender" value="4" />Egyptian<br/>		
		</td>
		</tr></table><br/>
		<input type="hidden" value="yes" name="civs" />
		<input type="submit" value="Ok" />
	</form>
	<?
	}
}
?>
</div>

<div id="right">
<?php include('stat.php'); ?>

<?php include('foot.php'); ?>