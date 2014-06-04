<?php
$starttimer = microtime_float();

// Get the different servers involved
$sql = "SELECT DISTINCT rounds.server, sum(rounddetails.kills) as kills, count(rounddetails.kills) as rounds FROM rounddetails 
		LEFT JOIN rounds ON rounddetails.roundid = rounds.id 
		GROUP BY SERVER
		ORDER BY kills DESC";
$servers = _dbquery($sql);	
require_once('Thirdparty/lgsl/lgsl_files/lgsl_protocol.php');
foreach ($servers as $key => $server)
	{
		$ipport = explode (':',$server['server']);
		$servers[$key]['live'] = lgsl_query_live('quake2', $ipport[0], $ipport[1], $ipport[1], '0', 's');
	}

$email = _dbquery ("SELECT email, playername FROM users WHERE playername IS NOT NULL");
foreach ($email as $key => $value)
	{
		$emails[$value['playername']] = $value['email'];		
	}

//print_r($servers);
//echo $start .' '. $end .' ';
$sql = "SELECT winner, count(winner) as wins FROM rounds WHERE winner != '' group by winner ORDER BY wins DESC ";
$winners = _dbquery($sql);
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
	round(((sum(kills) / (sum(kills) + sum(deaths) + sum(suicides)))* 100),1) as eff
	FROM rounddetails
	LEFT JOIN rounds ON rounddetails.roundid = rounds.id
	Group by who
	HAVING count(rounddetails.id) > 20
	order by score DESC
";
//echo date("dS F Y",$start) . ' - '. date("dS F Y",$end);
$data = _dbquery($sql);

	
$sql = "
	SELECT winner, count(id) as wins FROM rounds 
	WHERE winner != ''
	group by winner
";
$winners = _dbquery($sql);

foreach ($winners as $value)
	{
		$winplayer[$value['winner']] = $value['wins'];
	}
$i=0;
foreach ($data as $key => $value)
	{
		if (!isset($winplayer[$value['who']]))
			{
			 	$winplayer[$value['who']] = 0;
			}
		$data[$key]['roundwins'] = $winplayer[$value['who']];
		if (isset($emails[$value['who']]))
			{
				$data[$key]['email'] = $emails[$value['who']];
			}
		
		//Skill = (K/(1+V+S)) * (1+(Mw/Mp))
		$data[$key]['skill'] = round(($value['kills'] / ( 1 + $value['deaths'] + $value['suicides'])) * ( 1 + ( $data[$key]['roundwins'] / $value['rnds']) ),2);
		$skill[$i]['score'] = $data[$key]['skill'];
		$skill[$i]['who'] = $value['who'];
		if (isset($data[$key]['email']))
			{
				$skill[$i]['email'] = $data[$key]['email'];
			}
		$i++;
	}
//($value['kills'] / ( 1 + $value['deaths'] + $value['suicides'])) * ( 1 + ( $winplayer[$value['who']] / $value['rnds']) )

if (isset($skill)) { arsort($skill); } else { $skill = ''; }
function cmp($a, $b)
{
    if ($a['score'] == $b['score']) {
        return 0;
    }
    return ($a['score'] > $b['score']) ? -1 : 1;
}

usort($skill, "cmp");



$html['js'] = 
	'
	<script type="text/javascript"src="/js/jquery.1.3.min.js"></script>
	<script type="text/javascript"src="/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="/js/jquery.tinyTips.js"></script>
	<script type="text/javascript" src="/js/idtabs.js"></script>
	<script type="text/javascript">
	$(document).ready(function() {
		$("a.tTip").tinyTips("light","title");
	});
	</script>	
	
	
	
	';
$smarty->assign('servers',$servers);
$smarty->assign('skill',$skill);
$smarty->assign('data',$data);
$smarty->assign('timer',round(microtime_float() - $starttimer, 3));
$smarty->assign('html',$html);

$smarty->display('global.tpl');

?>