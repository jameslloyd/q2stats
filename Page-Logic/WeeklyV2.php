<?php
$starttimer = microtime_float();

if (isset($html['path'][1]))
	{
		$start=strtotime(str_replace('-',' ',$html['path'][1]));
		$end=$start+604800;
		
		$report = _time_stats($start, $end);	
	} else {
		$start=strtotime("Last Monday");
		$end=$start+604800;
	}
	$end= 1283727600;
	$start = 1184332400;
$sql = "
	SELECT
	rounddetails.who,
	sum(rounddetails.blaster) as blaster, 
	sum(rounddetails.shotgun) as shotgun,
	sum(rounddetails.supershotgun) as supershotgun, 
	sum(rounddetails.machinegun) as machinegun,
	sum(rounddetails.chaingun) as chaingun,
	sum(rounddetails.grenadelauncher) as grenadelauncher,
	sum(rounddetails.rocketlauncher) as rocketlauncher,
	sum(rounddetails.bfg10k) as bfg10k,
	sum(rounddetails.handgrenade) as handgrenade,
	sum(rounddetails.telefrag) as telefrag,
	sum(rounddetails.grapplinghook) as grapplinghook,
	sum(rounddetails.kills) as kills,
	sum(rounddetails.deaths) as deaths,
	sum(rounddetails.suicides) as suicides,
	max(rounddetails.killstreak) as killstreak,
	max(rounddetails.deathstreak) as deathstreak,
	(sum(rounddetails.kills) - sum(rounddetails.suicides)) as score,
	(sum(kills) / sum(deaths)) as K2D,
	count(rounddetails.id) as rnds,
	round(((sum(kills) / (sum(kills) + sum(deaths) + sum(suicides)))* 100),1) as eff
	FROM rounddetails
	LEFT JOIN rounds ON rounddetails.roundid = rounds.id
	WHERE rounds.timestamp BETWEEN $start AND $end
	Group by who
	HAVING count(rounddetails.id) > 10
	order by score DESC
";
$data = _dbquery($sql);
$sql = "
	SELECT winner, count(id) as wins FROM rounds 
	WHERE timestamp BETWEEN $start AND $end AND winner != ''
	group by winner
";
$winners = _dbquery($sql);

foreach ($winners as $value)
	{
		$winplayer[$value['winner']] = $value['wins'];
	}
foreach ($data as $key => $value)
	{
		if (!isset($winplayer[$value['who']]))
			{
			 	$winplayer[$value['who']] = 0;
			}
		$data[$key]['roundwins'] = $winplayer[$value['who']];
		//Skill = (K/(1+V+S)) * (1+(Mw/Mp))
		$data[$key]['skill'] = round(($value['kills'] / ( 1 + $value['deaths'] + $value['suicides'])) * ( 1 + ( $data[$key]['roundwins'] / $value['rnds']) ),2);
		$skill[$value['who']] = $data[$key]['skill'];
			
	}
//($value['kills'] / ( 1 + $value['deaths'] + $value['suicides'])) * ( 1 + ( $winplayer[$value['who']] / $value['rnds']) )
arsort($skill);



$smarty->assign('skill',$skill);
$smarty->assign('data',$data);
$smarty->assign('timer',round(microtime_float() - $starttimer, 3));
//$smarty->assign('weeks',array_reverse($weeks));
$smarty->assign('start',date("dS F Y",$start));	
$smarty->assign('html',$html);
$smarty->display('weeklyV2.tpl');
?>