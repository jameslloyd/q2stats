<?php
include ('config.php');
$servers = _dbquery("SELECT DISTINCT server FROM log");
foreach ($servers as $value)
	{
		$lastround[$value['server']]['rolledup'] = _dbquery("SELECT max(timestamp) as start FROM rounds WHERE server = '".$value['server']."' ");
		$lastround[$value['server']]['inlogs'] = _dbquery("SELECT max(gamedate) as end FROM log WHERE server ='".$value['server']."'");
	}


foreach ($lastround as $key => $value)
	{
		if (empty($value['rolledup'][0]['start'])) 
			{
				$start = 0;
			} else {
				$start = $value['rolledup'][0]['start'];
			}
		$end = $value['inlogs'][0]['end'] - 1; // dont want to rollup the last round incase not all the kills etc were in the last log import.
		echo $key;
		$gamedates = _dbquery("SELECT DISTINCT gamedate FROM log WHERE server = '$key' AND gamedate BETWEEN $start and $end AND (action = 'kill' or action ='suicide')");
		if ($gamedates)
			{
			
			foreach ($gamedates as $gamedate)
				{
				echo 'Server = '.$key.' Gamedate = '.$gamedate['gamedate'].' <br>';
				_getrounddata($gamedate['gamedate'],$key);
				}
			}
		
		
	}

// work out the round winner
$nowinners = _dbquery ("SELECT id FROM `rounds` WHERE winner IS NULL");
foreach ($nowinners as $value)
	{

		$winner = _dbquery ("SELECT who, (kills - suicides) as score FROM rounddetails WHERE roundid = '".$value['id']."' ORDER BY score DESC limit 0,1");
		if ($winner[0]['score'] > 0)
			{
				_dbupdate("UPDATE  `q2stats`.`rounds` SET  `winner` =  '".$winner[0]['who']."' WHERE  `rounds`.`id` =".$value['id'].";");
			} else {
				// score was 0 or negative 
				_dbupdate("UPDATE  `q2stats`.`rounds` SET  `winner` =  '' WHERE  `rounds`.`id` =".$value['id'].";");
			}
	}


?> 