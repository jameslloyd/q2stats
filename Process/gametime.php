<?php
require_once('../config.php');
$sql ="
	SELECT who,server FROM log 
	WHERE action = 'PLayerConnect' and who = 'KungFuMonkay'
	Group by who
";
$players = _dbquery($sql);

foreach ($players as $player)
	{
		$sql =
		"
		SELECT timestamp, action, who 
		FROM log 
		WHERE (action = 'PlayerConnect' OR action = 'PlayerLeft') 
		and who = '".$player['who']."' 
		and server = '".$player['server']."'
		ORDER BY timestamp ASC
		";
		
		$connections = _dbquery($sql);
		//print_r($connections);
		$i=0;
		$ii=0;
		foreach ($connections as $connection)
			{
				echo $connection['action'].'<br>';
				if ($connection['action'] == 'PlayerConnect')
					{
						$time[$ii]['in'][$i] = $connection['timestamp'];
					} else {
						$time[$ii]['out'] = $connection['timestamp'];
						$ii++;
						$i=-1;
					}
				$i++;
			}
	}
print_r($time);