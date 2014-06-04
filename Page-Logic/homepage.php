<?php
$starttimer = microtime_float();

if (isset($html['path'][1]))
	{
		$start=strtotime(str_replace('-',' ',$html['path'][1]));
		$end=$start+604800;	
	} else {
		$start=strtotime("Last Monday");
		$end=$start+604800;
	}
// Get the different servers involved
$sql = "SELECT DISTINCT rounds.server, sum(rounddetails.kills) as kills, count(rounddetails.kills) as rounds FROM rounddetails 
		LEFT JOIN rounds ON rounddetails.roundid = rounds.id 
		WHERE rounds.timestamp BETWEEN $start AND $end
		GROUP BY SERVER
		ORDER BY kills DESC";
$servers = _dbquery($sql);	
require_once('Thirdparty/lgsl/lgsl_files/lgsl_protocol.php');
foreach ($servers as $key => $server)
	{
		$ipport = explode (':',$server['server']);
		$servers[$key]['live'] = lgsl_query_live('quake2', $ipport[0], $ipport[1], $ipport[1], '0', 's');
	}

$email = _dbquery ("SELECT id, avatar, email, playername FROM users WHERE playername IS NOT NULL");
foreach ($email as $key => $value)
	{
		$emails[$value['playername']]['email'] = $value['email'];		
		$emails[$value['playername']]['id'] = $value['id'];
		$emails[$value['playername']]['avatar'] = $value['avatar'];
	}

//print_r($servers);
//echo $start .' '. $end .' ';
$sql = "SELECT winner, count(winner) as wins FROM rounds WHERE timestamp BETWEEN $start AND $end AND winner != '' group by winner ORDER BY wins DESC ";
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
	WHERE rounds.timestamp BETWEEN $start AND $end
	Group by who
	HAVING count(rounddetails.id) > 5
	order by score DESC
";
//echo date("dS F Y",$start) . ' - '. date("dS F Y",$end);
$data = _dbquery($sql);



if (!isset($data[0]['who']))
	{
		if (isset($html['path'][1]))
			{
				$start=strtotime(str_replace('-',' ',$html['path'][1])) -604800 ;
				$end=$start+604800 ;	
			} else {
				$start=strtotime("Last Monday") - 604800;
				$end=$start+604800;
			}
		$data = _dbquery($sql);	
	} 
	
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
				$data[$key]['email'] = $emails[$value['who']]['email'];
				$data[$key]['userid'] = $emails[$value['who']]['id'];
				$file =  INSTALL . 'Avatars/'.$emails[$value['who']]['id'].'/'.$emails[$value['who']]['avatar'];
				//echo $file;
				if (file_exists($file))
					{
					//	echo 'exists';
					$data[$key]['avatar'] = '/Avatars/'.$data[$key]['userid'].'/'.$emails[$value['who']]['avatar'];	
					} else {
					//	echo 'no';
					//$data[$key]['avatar'] = '/images/Quake-II-32.png';		
					}
				
			}
		
		//Skill = (K/(1+V+S)) * (1+(Mw/Mp))
		$data[$key]['skill'] = round(($value['kills'] / ( 1 + $value['deaths'] + $value['suicides'])) * ( 1 + ( $data[$key]['roundwins'] / $value['rnds']) ),2);
		$skill[$i]['score'] = $data[$key]['skill'];
		$skill[$i]['who'] = $value['who'];
		if (isset($data[$key]['email']))
			{
				$skill[$i]['email'] = $data[$key]['email'];
				if (isset($data[$key]['avatar']))
					{
						$skill[$i]['avatar'] = $data[$key]['avatar'];
					}
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


//print_r($skill);

// This is work out the previous week & next week 

$earliest = _dbquery("SELECT min(timestamp) as min FROM rounds");
//echo $start . ' ' . $end . ' ' . $earliest[0]['min'];

//if ($start-604800 < $earliest[0]['min'])
//	{
		$week['previous']['U'] = $start-604800;
		$week['previous']['display'] = date("dS F Y",$week['previous']['U']);
//	}
if ($start != strtotime("Last Monday"))
	{
		// if the $start != last monday then its not the current week and there will be a next week (does that make sense?)
		$week['next']['U'] = $start+604800;
		$week['next']['display'] = date("dS F Y",$week['next']['U']);
	}
//end of previous week next week
//print_r($data);

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
$smarty->assign('totalkills',_dbquery("SELECT count('action') as kills FROM log WHERE action ='kill'"));
$smarty->assign('servers',$servers);
$smarty->assign('week',$week);
$smarty->assign('skill',$skill);
$smarty->assign('data',$data);
$smarty->assign('timer',round(microtime_float() - $starttimer, 3));
//$smarty->assign('weeks',array_reverse($weeks));
$smarty->assign('start',date("dS F Y",$start));	
$smarty->assign('html',$html);

$smarty->display('homepage.tpl');

?>