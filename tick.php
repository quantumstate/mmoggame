<?php
session_start();
include('dbinfo.php');
$time=time();
$query="SELECT * FROM `queue` WHERE `time`<=$time";
#echo $query;
$result=mysql_query($query);
#echo $result;


while ($job=mysql_fetch_array($result)){
	$username=$job['player'];

	$query="SELECT `construction` FROM `players` WHERE `username`='$username'";
	$construction=mysql_query($query);
	$construction=mysql_result($construction,0);
	list($buildid,$lvl,$thetime)=explode('|',$construction);
	
	$query="SELECT `buildings` FROM `players` WHERE `username`='$username'";
	$buildings=mysql_query($query);
	$buildings=mysql_result($buildings,0);
	
	switch ($buildid){
	case 'wa':
		$mult=pow(1.3,$lvl);
		$limit=1500*$mult;
		$query="SELECT `resources` FROM `players` WHERE `username`='$username'";
		$resources=mysql_query($query);
		$resources=mysql_result($resources,0);
		$resources=explode('|',$resources);
		$resources[1]=$limit;
		$resources[1]=round($resources[1]);
		$resources[3]=$limit;
		$resources[3]=round($resources[3]);
		$resources[5]=$limit;
		$resources[5]=round($resources[5]);
		$resources[7]=$limit;
		$resources[7]=round($resources[7]);
		$resource='';
		foreach ($resources as $res){
			$resource.=$res.'|';
		}
		$query="UPDATE `players` SET `resources`='$resource' WHERE `username`='$username'";
		$tpds=mysql_query($query);
	break;
	case 'bk':
		$mult=pow(1.3,$lvl);
		#echo $mult."<br/>";
		#echo $lvl;
		$limit=1500*$mult;
		#echo $limit."<br/>";
		$query="SELECT `resources` FROM `players` WHERE `username`='$username'";
		$resources=mysql_query($query);
		$resources=mysql_result($resources,0);
		#echo $resources."<br/>";
		$resources=explode('|',$resources);
		#echo $resources[9]."<br/>"."<br/>";
		$resources[9]=$limit;
		$resources[9]=round($resources[9]);
		$resource='';
		foreach ($resources as $res){
			$resource.=$res.'|';
			#echo $res."<br/>";
		}
		#echo $resource;
		$query="UPDATE `players` SET `resources`='$resource' WHERE `username`='$username'";
		$tpds=mysql_query($query);
	break;
	}
	
	$find=$buildid.'|'.($lvl-1);
	$replace=$buildid.'|'.$lvl;
	$buildings=str_replace($find,$replace,$buildings);
	$query="UPDATE `players` SET `buildings` = '$buildings' WHERE `username`='$username' LIMIT 1";
	$resulter=mysql_query($query);

	$query="UPDATE `players` SET `construction` = '' WHERE `username`='$username' LIMIT 1";
	#echo $query;
	$resulter=mysql_query($query);
}

$query="DELETE FROM `queue` WHERE `time`<=$time";
$result=mysql_query($query);


$time=time();
$query="SELECT * FROM `resqueue` WHERE `time`<=$time";
#echo $query;
$result=mysql_query($query);
#echo $result;

while ($job=mysql_fetch_array($result)){
	$username=$job['player'];

	$query="SELECT `resourceconstruction` FROM `players` WHERE `username`='$username'";
	$construction=mysql_query($query);
	$construction=mysql_result($construction,0);
	list($buildid,$lvl,$thetime)=explode('|',$construction);
	
	$query="SELECT `resourcefields` FROM `players` WHERE `username`='$username'";
	$buildings=mysql_query($query);
	$buildings=mysql_result($buildings,0);
	$buildings=explode('|',$buildings);
	$buildings[$buildid+1]++;
	$j=0;
	foreach ($buildings as $i){
		$j++;
		switch ($i){
		case 'w':
			$w+=((2*$buildings[$j]*$buildings[$j])-($buildings[$j]*2))+5;
		break;
		case 's':
			$s+=((2*$buildings[$j]*$buildings[$j])-($buildings[$j]*2))+5;
		break;
		case 'b':
			$b+=((2*$buildings[$j]*$buildings[$j])-($buildings[$j]*2))+5;
		break;
		case 'c':
			$c+=((2*$buildings[$j]*$buildings[$j])-($buildings[$j]*2))+5;
		break;
		case 'g':
			$g+=(((2*$buildings[$j]*$buildings[$j])-($buildings[$j]*2))+5);
		break;
		}
		$resourcesr.=$i.'|';
	}
			$query="SELECT `resources` FROM `players` WHERE `username`='$username'";
			$resources=mysql_query($query);
			$resources=mysql_result($resources,0);
			#echo $resources."<br/>";
			$resources=explode('|',$resources);
			#echo $resources[9]."<br/>"."<br/>";
			$resources[11]=$g;
			$resource='';
			foreach ($resources as $res){
				$resource.=$res.'|';
				#echo $res."<br/>";
			}
			#echo $resource;
			$query="UPDATE `players` SET `resources`='$resource' WHERE `username`='$username'";
			$tpds=mysql_query($query);
			$query="SELECT `resources` FROM `players` WHERE `username` = '$username'";
			$resultedssa=mysql_query($query);
			$resultedssa=mysql_result($resultedssa,0);
			list($wood,$woodlimit,$stone,$stonelimit,$bronze,$bronzelimit,$wheat,$wheatlimit,$coin,$coinlimit,$pop,$poplimit)=explode('|',$resultedssa);
				
	
	$production=$w.'|'.$s.'|'.$b.'|'.$c.'|'.$g;
	
	$query="UPDATE `players` SET `resourcefields` = '$resourcesr',`production` = '$production' WHERE `username`='$username' LIMIT 1";
	$resulter=mysql_query($query);

	$query="UPDATE `players` SET `resourceconstruction` = '' WHERE `username`='$username' LIMIT 1";
	$resulter=mysql_query($query);
	
	unset($resourcesr);	
}

$query="DELETE FROM `resqueue` WHERE `time`<=$time";
$result=mysql_query($query);

$time=time();
$query="SELECT * FROM `trade` WHERE `time`<=$time";
#echo $query;
$result=mysql_query($query);
while ($job=mysql_fetch_array($result)){
	list($woodinc,$stoneinc,$bronzeinc,$wheatinc,$coininc)=explode('|',$job['resources']);

	$query="SELECT `resources` FROM `players` WHERE `username`='{$job['to']}'";
	$rev=mysql_query($query);
	$rev=mysql_result($rev,0);

	list($wood,$woodlimit,$stone,$stonelimit,$bronze,$bronzelimit,$wheat,$wheatlimit,$coin,$coinlimit,$pop,$poplimit)=explode('|',$rev);
	
	#echo $woodinc;
	
	$wood+=$woodinc;
	$stone+=$stoneinc;
	$bronze+=$bronzeinc;
	$wheat+=$wheatinc;
	$coin+=$coininc;
	
	if ($wood>$woodlimit){
		$wood=$woodlimit;
	}
	if ($stone>$stonelimit){
		$stone=$stonelimit;
	}
	if ($bronze>$bronzelimit){
		$bronze=$bronzelimit;
	}
	if ($wheat>$wheatlimit){
		$wheat=$wheatlimit;
	}
	if ($coin>$coinlimit){
		$coin=$coinlimit;
	}
	
	$resources=$wood.'|'.$woodlimit.'|'.$stone.'|'.$stonelimit.'|'.$bronze.'|'.$bronzelimit.'|'.$wheat.'|'.$wheatlimit.'|'.$coin.'|'.$coinlimit.'|'.$pop.'|'.$poplimit;

	$buildings=str_replace($find,$replace,$buildings);
	$query="UPDATE `players` SET `resources` = '$resources' WHERE `username`='{$job['to']}' LIMIT 1";
	$resulter=mysql_query($query);
	

	
	
	$to=$job['to'];
	$from=$job['from'];
	$subject='Resources recieved from '.$job['from'];
	$content='<img src="images/wood.gif" alt="wood" style="margin-right:2px;" />'.$woodinc.
	'  <img src="images/stone.gif" alt="stone" style="margin-right:2px;" />'.$stoneinc.
	'  <img src="images/bronze.gif" alt="bronze" style="margin-right:2px;" />'.$bronzeinc.
	'  <img src="images/wheat.gif" alt="wheat" style="margin-right:2px;" />'.$wheatinc.
	'  <img src="images/coin.gif" alt="coin" style="margin-right:2px;" />'.$coininc;

	$time=time();
	
	$query="INSERT INTO `igm` ( `id` , `to` , `from` , `subject` , `content` , `read` , `time` ) VALUES (NULL , '$to', '$from', '$subject', '$content', '', $time)";
	
	$result=mysql_query($query);
}
$query="DELETE FROM `trade` WHERE `time`<=$time";
$result=mysql_query($query);



$time=time();
$query="SELECT * FROM `unitqueue` WHERE `time`<=$time";
$result=mysql_query($query);

while ($job=mysql_fetch_array($result)){
	$username=$job['player'];
		
	$query="SELECT * FROM `players` WHERE `username`='$username'";
	$rev=mysql_query($query);
	$player=mysql_fetch_array($rev);

	list($wood,$woodlimit,$stone,$stonelimit,$bronze,$bronzelimit,$wheat,$wheatlimit,$coin,$coinlimit,$pop,$poplimit)=explode('|',$player['resources']);
	
	$training=explode('|',$player['unitconstruction']);
	#echo $player['unitconstruction'].'<br>';
	
	$units=explode('|',$player['units']);
	#echo $player['units'].'<br>';
	
	$unitabbr=$training[0];
	#echo $unitabbr.'<br>';
	$training[1]--;
	$query="SELECT * FROM `units` WHERE `abbr`='$unitabbr'";
	$resulto=mysql_query($query);
	$unit=mysql_fetch_array($resulto);
	
	$i=0;
	foreach ($units as $aunit){
		$i++;
		if ($aunit==$unitabbr){
			$units[$i]++;
			#echo $units[$i].'<br>';
			$done='yes';
		}
	}
	
	foreach ($units as $aunit){
		$curunits.=$aunit.'|';
	}
	
	if ($done != 'yes'){
		$curunits.=$unitabbr.'|1';
	}
		
	$player['unitpop']+=$unit['pop'];
	
	if ($training[1]==0){
		$training[0]='';
		$training[1]='';
	}
	
	
	foreach ($training as $aunit){
		$thetraining.=$aunit.'|';
	}
	$thetraining=trim($thetraining,'|').'|';
	if ($thetraining=='|'){
		$thetraining='';
	}
	#echo $thetraining.'<br>';
	
	#echo $curunits.'<br>';
	$curunits=trim($curunits,'|');
	$query="UPDATE `players` SET `units` = '$curunits',`unitconstruction`='$thetraining',`unitpop` = '{$player['unitpop']}' WHERE `username`='$username' LIMIT 1";
	#echo $query.'<br>'.'<br>';
	$resulter=mysql_query($query);
	
	$barracks=explode('|',$player['buildings']);
	foreach ($barracks as $ba){
		if ($next=='yes'){
			$balvl=$ba;
		}
		if ($ba=='ba'){
			$next='yes';
		}
	}
	
	$bldtime=time()+($unit['time']*(1-($balvl*0.04)));
	
	$query="INSERT INTO `unitqueue` ( `id` , `player` , `time` ) VALUES (NULL , '$username', '$bldtime')";
	#echo $query.'<br>';
	if ($thetraining != ''){
		$resulto=mysql_query($query);
	}
	
	unset($job);
	unset($username);
	unset($thetraining);
	unset($curunits);
}
$query="DELETE FROM `unitqueue` WHERE `time`<=$time";
$result=mysql_query($query);


$time=time();
$query="SELECT * FROM `attacks` WHERE `time`<=$time ORDER BY `index` ASC";
$result=mysql_query($query);

while ($job=mysql_fetch_array($result)){
	$defuser=$job['to'];
	$attuser=$job['from'];
	
	if ($defuser==$attuser){
		$query="SELECT * FROM `players` WHERE `username`='$attuser'";
		$attplayer=mysql_query($query);
		$attplayer=mysql_fetch_array($attplayer);
		
		$attunits=array();
		$units=explode('|',$job['troops']);
		$x='f';
		foreach ($units as $unit){
			if ($x=='f'){
				$temp=$unit;
				$x='s';
			}else{
				$attunits[$temp]=$unit;
				$x='f';
			}
		}
		
		$curunits=array();
		$units=explode('|',$attplayer['units']);
		$x='f';
		foreach ($units as $unit){
			if ($x=='f'){
				$temp=$unit;
				$x='s';
			}else{
				$curunits[$temp]=$unit;
				$x='f';
			}
		}
		
		#print_r($curunits);
		#print_r($attunits);
		
		$civ=$attplayer['civ'];
			
		$query="SELECT * FROM `units` WHERE `civ`='$civ'";
		$resulta=mysql_query($query);
			while ($unit=mysql_fetch_array($resulta)){
				if ($attunits[$unit['abbr']]==''){
		
				}else{
					$curunits[$unit['abbr']]+=$attunits[$unit['abbr']];
					$unitpop+=$unit['pop']*$curunits[$unit['abbr']];
					
				}
				$theunits.=$unit['abbr'].'|'.$curunits[$unit['abbr']].'|';
			}
			
		#print_r($curunits);
		
			list($woodinc,$stoneinc,$bronzeinc,$wheatinc,$coininc)=explode('|',$job['resources']);
		
			list($wood,$woodlimit,$stone,$stonelimit,$bronze,$bronzelimit,$wheat,$wheatlimit,$coin,$coinlimit,$pop,$poplimit)=explode('|',$attplayer['resources']);
			
			#echo $woodinc;
			
			$wood+=$woodinc;
			$stone+=$stoneinc;
			$bronze+=$bronzeinc;
			$wheat+=$wheatinc;
			$coin+=$coininc;
			
			if ($wood>$woodlimit){
				$wood=$woodlimit;
			}
			if ($stone>$stonelimit){
				$stone=$stonelimit;
			}
			if ($bronze>$bronzelimit){
				$bronze=$bronzelimit;
			}
			if ($wheat>$wheatlimit){
				$wheat=$wheatlimit;
			}
			if ($coin>$coinlimit){
				$coin=$coinlimit;
			}
			
			$resources=$wood.'|'.$woodlimit.'|'.$stone.'|'.$stonelimit.'|'.$bronze.'|'.$bronzelimit.'|'.$wheat.'|'.$wheatlimit.'|'.$coin.'|'.$coinlimit.'|'.$pop.'|'.$poplimit;
		
		
		#echo '<br>'.$unitpop.'<br><br><br>';
		$query="UPDATE `players` SET `units`='$theunits', `unitpop`='$unitpop', `resources` = '$resources' WHERE `username`='$attuser'";
		#echo $query.'<br><br><br><br>';
		$resultb=mysql_query($query);
		
			
		$unitpop=0;
		$theunits='';
		
		#######################################################################################################################
		#######################################################################################################################
		#######################################################################################################################
	}else{
		$query="SELECT * FROM `players` WHERE `username`='$attuser'";
		$attplayer=mysql_query($query);
		$attplayer=mysql_fetch_array($attplayer);
		#echo $attuser;
		
		$attunits=array();
		$units=explode('|',$job['troops']);
		$x='f';
		foreach ($units as $unit){
			if ($x=='f'){
				$temp=$unit;
				$x='s';
			}else{
				$attunits[$temp]=$unit;
				$x='f';
			}
		}
		#print_r($attunits);
		#echo '<br>';
		
		$query="SELECT * FROM `players` WHERE `username`='$defuser'";
		$defplayer=mysql_query($query);
		$defplayer=mysql_fetch_array($defplayer);
		
		$defunits=array();
		$units=explode('|',$defplayer['units']);
		$x='f';
		foreach ($units as $unit){
			if ($x=='f'){
				$temp=$unit;
				$x='s';
			}else{
				$defunits[$temp]=$unit;
				$x='f';
			}
		}
		#print_r($defunits);
		#echo "<br/>$attuser | $defuser";
		
		
		$query="SELECT * FROM `units` WHERE `civ`='{$attplayer['civ']}'";
		$attacker=mysql_query($query);
		$att=array();
		while ($unit=mysql_fetch_array($attacker)){
			$att[$unit['type']]+=$attunits[$unit['abbr']];
		}
		if (($att[0]+$att[1]+$att[2])==0){
		$att[0]=1;
		}
		$attack=array();
		$attack[0]=$att[0]/($att[0]+$att[1]+$att[2]);
		$attack[1]=$att[1]/($att[0]+$att[1]+$att[2]);
		$attack[2]=$att[2]/($att[0]+$att[1]+$att[2]);
		
		
		$query="SELECT * FROM `units` WHERE `civ`='{$defplayer['civ']}'";
		$defender=mysql_query($query);
		$def=array();
		while ($unit=mysql_fetch_array($defender)){
			$def[$unit['type']]+=$defunits[$unit['abbr']];
		}
		
		if (($def[0]+$def[1]+$def[2])==0){
		$def[0]=1;
		}
		$defence=array();
		$defence[0]=$def[0]/($def[0]+$def[1]+$def[2]);
		$defence[1]=$def[1]/($def[0]+$def[1]+$def[2]);
		$defence[2]=$def[2]/($def[0]+$def[1]+$def[2]);
		
		
					$attigm='<table width="100%" cellpadding="1" cellspacing="0" border="1">';
					$attigm.='<tr><th>Attacker ('.$attuser.')</th>';
					$query="SELECT * FROM `units` WHERE `civ`='{$attplayer['civ']}'";
							$resulto=mysql_query($query);
							while ($unit=mysql_fetch_array($resulto)){
								$attigm.='<td><img src="units/'.$unit['picture'].'" alt="'.$unit['abbr'].'" /></td>';
							}
					$attigm.='</tr>
					<tr><td>Troops</td>';
					$query="SELECT * FROM `units` WHERE `civ`='{$attplayer['civ']}'";
							$resultoa=mysql_query($query);
							while ($unit=mysql_fetch_array($resultoa)){
								if ($attunits[$unit['abbr']]==''){
									$attigm.='<td><font color="#BBBBBB">0</font></td>';
								}else{
									$attigm.='<td>'.$attunits[$unit['abbr']].'</td>';
								}
							}
					$attigm.='</tr>';
					
					
					$defigm='<table width="100%" cellpadding="1" cellspacing="0" border="1">';
					$defigm.='<tr><th>Defender ('.$defuser.')</th>';
					$query="SELECT * FROM `units` WHERE `civ`='{$defplayer['civ']}'";
							$resulto=mysql_query($query);
							while ($unit=mysql_fetch_array($resulto)){
								$defigm.='<td><img src="units/'.$unit['picture'].'" alt="'.$unit['abbr'].'" /></td>';
							}
					$defigm.='</tr>
					<tr><td>Troops</td>';
					$query="SELECT * FROM `units` WHERE `civ`='{$defplayer['civ']}'";
							$resultoa=mysql_query($query);
							while ($unit=mysql_fetch_array($resultoa)){
								if ($defunits[$unit['abbr']]==''){
									$defigm.='<td><font color="#BBBBBB">0</font></td>';
								}else{
									$defigm.='<td>'.$defunits[$unit['abbr']].'</td>';
								}
							}
					$defigm.='</tr>';
		
		
		$query="SELECT * FROM `units` WHERE `civ`='{$attplayer['civ']}'";
		$attacker=mysql_query($query);
		while ($unit=mysql_fetch_array($attacker)){
			list($inf,$arc,$cav)=explode('|',$unit['attack']);
			$attforce+=$attunits[$unit['abbr']]*(($inf*$defence[0])+($arc*$defence[1])+($cav*$defence[2]));
		}
		#echo '<br/>Attack:'.$attforce;
		
		$query="SELECT * FROM `units` WHERE `civ`='{$defplayer['civ']}'";
		$defender=mysql_query($query);
		while ($unit=mysql_fetch_array($defender)){
			list($inf,$arc,$cav)=explode('|',$unit['defence']);
			
			$defforce+=$defunits[$unit['abbr']]*(($inf*$attack[0])+($arc*$attack[1])+($cav*$attack[2]));
		}
		#echo '<br/>Defence:'.$defforce.'<br/><br/>';
		
		if ($defforce>=$attforce){
			$attloss=1;
			$defloss=($attforce/$defforce);#-( (($defforce-$attforce)/($attforce+$defforce)) /5);
			#echo '<br/>attack/defence'.$defloss;
		}else{
			$defloss=1;
			$attloss=$defforce/$attforce;
		}
		
		#echo '<br/>Attack Loss:'.$attloss;
		#echo '<br/>Defence Loss:'.$defloss;
		
		#echo '<br/>Attack:';
		$query="SELECT * FROM `units` WHERE `civ`='{$attplayer['civ']}'";
		$resulto=mysql_query($query);
		while ($unit=mysql_fetch_array($resulto)){
			if ($attunits[$unit['abbr']]==''){
				#echo ' <font color="#BBBBBB">0</font>';
			}else{
				$loss=($attunits[$unit['abbr']]*$attloss);
				$loss-=sqrt($attunits[$unit['abbr']]-$loss);
				if ($loss<0){$loss=0;}
				$attunits[$unit['abbr']]-=round($loss);
				#echo ' '.round($loss).'';
				$carry+=$unit['carry']*$attunits[$unit['abbr']];
				if ($attunits[$unit['abbr']]!=0){
					$attackers.=$unit['abbr'].'|'.$attunits[$unit['abbr']].'|';
				}
			}
		}
		
		#echo '<br/>Defence:';
		$query="SELECT * FROM `units` WHERE `civ`='{$defplayer['civ']}'";
		$resulto=mysql_query($query);
		while ($unit=mysql_fetch_array($resulto)){
			if ($defunits[$unit['abbr']]==''){
				#echo ' <font color="#BBBBBB">0</font>';
			}else{
				$loss=($defunits[$unit['abbr']]*$defloss);
				$loss-=sqrt($defunits[$unit['abbr']]-$loss);
				if ($loss<0){$loss=0;}
				$defunits[$unit['abbr']]-=round($loss);
				if ($defunits[$unit['abbr']]!=0){
					$defenders.=$unit['abbr'].'|'.$defunits[$unit['abbr']].'|';
				}
				
				#echo ' '.round($loss).'';
			}
		}
		

					$attigm.='<tr><td>Remaining Troops</td>';
					$query="SELECT * FROM `units` WHERE `civ`='{$attplayer['civ']}'";
							$resultoa=mysql_query($query);
							while ($unit=mysql_fetch_array($resultoa)){
								if ($attunits[$unit['abbr']]==''){
									$attigm.='<td><font color="#BBBBBB">0</font></td>';
								}else{
									#$loss=($attunits[$unit['abbr']]*$defloss);
									#$loss-=sqrt($attunits[$unit['abbr']]-$loss);
									#if ($loss<0){$loss=0;}
									#echo '<td>'.round($loss).'</td>';
									$attigm.='<td>'.$attunits[$unit['abbr']].'</td>';
								}
							}
					$attigm.='</tr>';
					
					$attigm.='</table><br/>';

		#echo $attigm;
		
		
					$defigm.='<tr><td>Remaining Troops</td>';
					$query="SELECT * FROM `units` WHERE `civ`='{$defplayer['civ']}'";
							$resultoa=mysql_query($query);
							while ($unit=mysql_fetch_array($resultoa)){
								if ($defunits[$unit['abbr']]==''){
									$defigm.='<td><font color="#BBBBBB">0</font></td>';
								}else{
									#$loss=($defunits[$unit['abbr']]*$defloss);
									#$loss-=sqrt($defunits[$unit['abbr']]-$loss);
									#if ($loss<0){$loss=0;}
									#echo '<td>'.round($loss).'</td>';
									$defigm.='<td>'.$defunits[$unit['abbr']].'</td>';
								}
							}
					$defigm.='</tr>';
					
				$defigm.='</table>';
		#echo $defigm;

		
		if ($attackers!=''){
			list($wood,$woodlimit,$stone,$stonelimit,$bronze,$bronzelimit,$wheat,$wheatlimit,$coin,$coinlimit,$pop,$poplimit)=explode('|',$defplayer['resources']);
			$tot=$wood+$stone+$bronze+$wheat+$coin;
			$proportion=$carry/$tot;
			
			if ($proportion>1){
				$proportion=1;
			}
			
			$wood*=$proportion;
			$stone*=$proportion;
			$bronze*=$proportion;
			$wheat*=$proportion;
			$coin*=$proportion;
			
			$resources="$wood|$stone|$bronze|$wheat|$coin";
			
			#echo '<br>';
			#print_r($attunits);
			#echo $attackers.'<br>';
			
			#print_r($defunits);
			#echo $defenders.'<br>'.$carry.' | '.($wood+$stone+$bronze+$wheat+$coin).' | '.$tot;
			
			
			#echo '<br/><br/>';
			
			$civ=$attplayer['civ'];
			
			$fph=10000;
			$query="SELECT * FROM `units` WHERE `civ`='$civ'";
			$resulta=mysql_query($query);
				while ($unit=mysql_fetch_array($resulta)){
					if ($attunits[$unit['abbr']]==''){
			
					}else{
			
						if ($fph>$unit['speed']){
							$fph=$unit['speed'];
						}
					}
				}
			#echo '<br>'.$fph.'<br>';
			
			list($x1,$y1)=explode(',',$attplayer['position']);
			list($x2,$y2)=explode(',',$defplayer['position']);
			$dist=sqrt((($x1-$x2)*($x1-$x2))+(($y1-$y2)*($y1-$y2)));
			$outhour=$dist/$fph;
			$time=round($outhour*3600);
			
			#echo $time;
			$time=time()+$time;
			
			list($twood,$woodlimit,$tstone,$stonelimit,$tbronze,$bronzelimit,$twheat,$wheatlimit,$tcoin,$coinlimit,$pop,$poplimit)=explode('|',$defplayer['resources']);
			
			$twood-=$wood;
			$tstone-=$stone;
			$tbronze-=$bronze;
			$twheat-=$wheat;
			$tcoin-=$coin;
			
			$reses="$twood|$woodlimit|$tstone|$stonelimit|$tbronze|$bronzelimit|$twheat|$wheatlimit|$tcoin|$coinlimit|$pop|$poplimit";
			
			$query="UPDATE `players` SET `resources`='$reses', `units`='', `unitpop`='0' WHERE `username`='$defuser'";
			#echo $query.'<br>';
			$resultb=mysql_query($query);
			
			$query="UPDATE `attacks` SET `to`='$attuser', `troops`='$attackers', `time`='$time',`resources`='$resources' WHERE `index`='{$job['index']}'";
			#echo $query.'<br><br><br><br>';
			$resultb=mysql_query($query);
			
			
			$resigm='<img src="images/wood.gif" alt="wood" style="margin-right:2px;" />'.round($wood);
			$resigm.='  <img src="images/stone.gif" alt="stone" style="margin-right:2px;" />'.round($stone);
			$resigm.='  <img src="images/bronze.gif" alt="bronze" style="margin-right:2px;" />'.round($bronze);
			$resigm.='  <img src="images/wheat.gif" alt="wheat" style="margin-right:2px;" />'.round($wheat);
			$resigm.='  <img src="images/coin.gif" alt="coin" style="margin-right:2px;" />'.round($coin);

			#echo $resigm.'<br><br><br><br>';
			$time=time();
			$subject='Attack on '.$defuser;
			$content=$attigm.$defigm.$resigm;
			$query="INSERT INTO `igm` ( `id` , `to` , `from` , `subject` , `content` , `read` , `time` ) VALUES (NULL , '$attuser', '$attuser', '$subject', '$content', '', $time)";
			$resultb=mysql_query($query);
			
			$subject='Attack from '.$attuser;
			$content=$attigm.$defigm.$resigm;
			$query="INSERT INTO `igm` ( `id` , `to` , `from` , `subject` , `content` , `read` , `time` ) VALUES (NULL , '$defuser', '$defuser', '$subject', '$content', '', $time)";
			$resultb=mysql_query($query);
			
		}else{
			$civ=$defplayer['civ'];
			
			$query="SELECT * FROM `units` WHERE `civ`='$civ'";
			$resulta=mysql_query($query);
				while ($unit=mysql_fetch_array($resulta)){
					if ($defunits[$unit['abbr']]==''){
			
					}else{
			
							$unitpop+=$unit['pop']*$defunits[$unit['abbr']];

					}
				}
		
			$query="UPDATE `players` SET `units`='$defenders', `unitpop`='$unitpop' WHERE `username`='$defuser'";
			#echo $query.'<br><br><br><br>';
			$resultb=mysql_query($query);
			
			$time=time();
			$subject='Attack on '.$defuser;
			$content='None of your soldiers have returned';
			#echo $unitpop.'<br>'.$content.'<br><br><br><br>';
			$query="INSERT INTO `igm` ( `id` , `to` , `from` , `subject` , `content` , `read` , `time` ) VALUES (NULL , '$attuser', '$attuser', '$subject', '$content', '', $time)";
			$resultb=mysql_query($query);
			
			$subject='Attack from '.$attuser;
			$content=$attigm.$defigm;
			$query="INSERT INTO `igm` ( `id` , `to` , `from` , `subject` , `content` , `read` , `time` ) VALUES (NULL , '$defuser', '$defuser', '$subject', '$content', '', $time)";
			$resultb=mysql_query($query);
		}
		
		$defforce=0;
		$attforce=0;
		$unitpop=0;
		$carry=0;
		$defenders='';
		$attackers='';
		
	}	
}
$query="DELETE FROM `attacks` WHERE `time`<=$time";
$result=mysql_query($query);
?>