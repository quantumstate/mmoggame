<?php include('head.php');include('dbinfo.php'); ?>

<h1>THE RISEN</h1>
<!--<h1 style="color:red;">To report bugs please go to the forum.  Telling the admin about any problems results in a ban.  No offensive account names.</h1>-->
<p><b><u>What is The Risen? </u></b>
<br/>
The Risen is a browser based MMOG (massive multiplayer online game) 
where players become one of the major civilisations of the ancient world and 
attempt to dominate the Mediterranean.</p>
<u><b>Features</b></u>
<ul>
<li> Four different civilisations </li>
<li> Five different resources </li>
<li> Lots of different units and ships </li>
<li> A diverse technology tree </li>
<li> And much much more ... </li>
</ul>

<div style="position:absolute;left:420px;top:300px;">
<img src="images/soldier<?php echo $_SESSION['stylesheet'];?>.gif">
</div>

<a class="pop" href="#"><div class="cover"><div class="middle">
<?php
$query="SELECT * FROM `units` WHERE `id`='1'";
$result=mysql_query($query);
$unit=mysql_fetch_array($result);
echo '<h1>'.$unit['name'].'</h1>';
list($bldwood,$bldstone,$bldbronze,$bldwheat,$bldcoin)=explode('|',$unit['resources']);

$tmp=date('G',$unit['time']);
$tmp-=1;

echo '<b>Resources</b><br/><font color="black"><img src="images/wood.gif" alt="wood" style="margin-right:2px;" />'.$bldwood;
echo '  <img src="images/stone.gif" alt="stone" style="margin-right:2px;" />'.$bldstone;
echo '  <img src="images/bronze.gif" alt="bronze" style="margin-right:2px;" />'.$bldbronze;
echo '  <img src="images/wheat.gif" alt="wheat" style="margin-right:2px;" />'.$bldwheat;
echo '  <img src="images/coin.gif" alt="coin" style="margin-right:2px;" />'.$bldcoin;
echo '  <img src="images/pop.gif" alt="population" style="margin-right:2px;" />'.$unit['pop'];
echo '  <img src="images/time.gif" alt="build time" style="margin-right:2px;" />'.$tmp.date(':i:s',$unit['time']);

list($inf,$cav,$arch)=explode('|',$unit['attack']);
?>
<br/><br/>
<table width="48%" border="1" style="float:left; margin-right:12px;">
	<tr>
		<th colspan="3">Attack vs</th>
	</tr>
	<tr>
		<td>Infantry</td>
		<td>Archers</td>
		<td>Cavalry</td>
	</tr>
	<tr>
		<td><?php echo $inf;?></td>
		<td><?php echo $arch;?></td>
		<td><?php echo $cav;?></td>
	</tr>
</table>
<?php
list($inf,$cav,$arch)=explode('|',$unit['defence']);
?>
<table width="48%" border="1">
	<tr>
		<th colspan="3">Defence vs</th>
	</tr>
	<tr>
		<td>Infantry</td>
		<td>Archers</td>
		<td>Cavalry</td>
	</tr>
	<tr>
		<td><?php echo $inf;?></td>
		<td><?php echo $arch;?></td>
		<td><?php echo $cav;?></td>
	</tr>
</table>
</font>
<br/>
<?php
echo $unit['description'];
?>
</div></div></a>
</div>

<div id="right">
<?php include('stat.php'); ?>

<?php include('foot.php'); ?>