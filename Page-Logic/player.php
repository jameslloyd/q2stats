<?php
$pathparams[1] = urldecode($pathparams[1]);
if (isset($pathparams[2])) // is the server set 
	{
		$and = " server = '$pathparams[2]' ";
		
	} else {
		$and = '';
	}

$lastplayed = _dbquery("SELECT rounds.timestamp	FROM rounddetails LEFT JOIN rounds on rounds.id = rounddetails.roundid WHERE rounddetails.who = '".$pathparams[1]."' ORDER BY rounds.timestamp DESC limit 1,1");
$lastplayed = $lastplayed[0]['timestamp'];
$weapons = array ('blaster','shotgun','supershotgun','machinegun','chaingun','grenadelauncher','rocketlauncher','railgun','hyperblaster','bfg10k','handgrenade','telefrag','grapplinghook');

foreach ($weapons as $key => $item)
	{
	if (isset($pathparams[2])) // if server is set change the SQL to allow the server in the where clause which is messy as requires a join on the rounds table.
		{
		$sql = "
			SELECT rank, who, $item,server
			FROM 
			(SELECT @rank := @rank+1 AS rank, $item,who,server  FROM (SELECT rounds.server as server, rounddetails.who as who, sum($item) as $item 
			FROM rounddetails
			LEFT JOIN rounds on rounds.id = rounddetails.roundid
			GROUP BY who
			ORDER BY $item DESC) AS temptable) as temp2	
			";
		} else {
	
		$sql = "
			SELECT rank, who, $item
			FROM 
			(SELECT @rank := @rank+1 AS rank, $item,who  FROM (SELECT who, sum($item) as $item 
			FROM rounddetails 
			GROUP BY who
			ORDER BY $item DESC) AS temptable) as temp2
			WHERE who ='".$pathparams[1]."'
		";
		}
	_dbupdate("SET @rank=0;");
	$weaponranks[$item] = _dbquery($sql);	
	}

$ping = _dbquery("SELECT AVG(ping) as ping FROM log WHERE who = '".$pathparams[1]."' AND ping  IS NOT NULL AND ping > 0");
if (isset($averageping['0']['ping']))
	{
		$averageping = $ping[0]['ping'];
	} else {
		$averageping = '';
	}
		
$sql ="
	SELECT
	rounddetails.who,
	sum(rounddetails.blaster) as blaster, 
	sum(rounddetails.shotgun) as shotgun,
	sum(rounddetails.supershotgun) as supershotgun, 
	sum(rounddetails.machinegun) as machinegun,
	sum(rounddetails.chaingun) as chaingun,
	sum(rounddetails.grenadelauncher) as grenadelauncher,
	sum(rounddetails.rocketlauncher) as rocketlauncher,
	sum(rounddetails.railgun) as railgun,
	sum(rounddetails.hyperblaster) as hyperblaster,
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
	round((sum(kills) / sum(deaths)),2) as K2D,
	count(rounddetails.id) as rnds,
	round(((sum(kills) / (sum(kills) + sum(deaths) + sum(suicides)))* 100),1) as eff
	FROM rounddetails
	WHERE rounddetails.who = '".$pathparams[1]."'
";
$playerdata = _dbquery($sql);
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
	sum(rounddetails.railgun) as railgun,
	sum(rounddetails.hyperblaster) as hyperblaster,
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
	round((sum(kills) / sum(deaths)),2) as K2D, 
	count(rounddetails.id) as rnds, 
	round(((sum(kills) / (sum(kills) + sum(deaths) + sum(suicides)))* 100),1) as eff ,
	rounds.server

	FROM rounddetails 

	LEFT JOIN rounds on rounds.id = rounddetails.roundid

	WHERE rounddetails.who = '".$pathparams[1]."'
	group by rounds.server
";
$serverdata = _dbquery($sql);
require_once('Thirdparty/lgsl/lgsl_files/lgsl_protocol.php');
foreach ($serverdata as $key => $server)
	{
		$ipport = explode (':',$server['server']);
		$serverdata[$key]['live'] = lgsl_query_live('quake2', $ipport[0], $ipport[1], $ipport[1], '0', 's');
	}


$sql = "
	SELECT count(log.action) as kills, log.who, users.email
	FROM log 
  LEFT JOIN users ON users.playername = log.who
	WHERE log.action = 'kill' 
	and log.target = '".$pathparams[1]."' 
	GROUP BY who 
	ORDER BY kills DESC
";
$deathsperplayer = _dbquery($sql);
$sql = "
	SELECT count(log.action) as kills, log.target, users.email as email
	FROM log 
  LEFT JOIN users ON users.playername = log.target 
	WHERE log.action = 'kill' 
	and log.who = '".$pathparams[1]."' 
	GROUP BY target 
	ORDER BY kills DESC
";
$killperplayer = _dbquery($sql);


$playerinfo = _dbquery("SELECT * FROM users WHERE playername ='".$pathparams[1]."'");
$html['js'] = '
<script type="text/javascript"src="/js/jquery.1.3.min.js"></script>
<script type="text/javascript" src="/js/jquery.tinyTips.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	$("a.tTip").tinyTips("light","title");
});
</script>
';
$smarty->assign('averageping',$averageping);
$smarty->assign('lastplayed',date("dS F Y",$lastplayed));
$smarty->assign('weaponranks',$weaponranks);
$smarty->assign('killsperplayer',$killperplayer);
$smarty->assign('deathsperplayer',$deathsperplayer);
$smarty->assign('serverdata',$serverdata);
$smarty->assign('playerdata',$playerdata);
$smarty->assign('playerinfo',$playerinfo);
$smarty->assign('playername',$pathparams[1]); 
$smarty->assign('html', $html);
$smarty->display('player.tpl');
?>