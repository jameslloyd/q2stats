<?php
function _roundreport($start,$end,$server)
	{
	$sql = "SELECT DISTINCT `gamedate` FROM log WHERE timestamp BETWEEN $start AND $end AND server = '$server' AND (action = 'Kill' OR action = 'Suicide')";
//	echo $sql;
	$games = _dbquery($sql);

	foreach ($games as $key => $game)
		{
			
			$output[$game['gamedate']] = _getrounddata($game['gamedate'],$server);

		}
	return $output;
		
	}
	
function _putweekdata($weekstart,$server)
	{
		$start = strtotime("midnight last monday", $weekstart);
		$end = $start + 604800;
		$sql = "
		SELECT distinct gamedate FROM log 
		WHERE server = '$server' 
		AND action = 'kill' OR action = 'suicide' 
		AND gamedate BETWEEN '$start' and '$end'";
		//echo $sql; 
		$rounds = _dbquery($sql);
		
		$i=0;
		foreach ($rounds as $round)
			{
			 $data[$i] = _getrounddata($round['gamedate'],$server);
			$i++;
			
		
			
			}
print_r($data);
		
	
	return($output);
	}
	
function _getweekstats($weekstart,$server)
	{
		if (!_isitindb("SELECT id FROM week WHERE server ='".$server."' AND weekstart = '".$weekstart."'"))
			{
				_getweekdata($weekstart,$server);
			} else {
				
				
			}
	}
function _putrounddata($gamedate,$server)
	{
		// Count the kills in this round if there arn't any ignore the round
		$sql ="
		SELECT count(action) FROM log 
		WHERE action = 'Kill' 
		AND gamedate = $gamedate
		AND server = '$server'
		";
		$killroundcount = _dbquery($sql);
		if ($killroundcount[0] >= 1)
			{
		// Get the logs
		$sql = "
		SELECT timestamp,gamedate , who, target,action,weapon,map FROM log 
		WHERE (action = 'Kill' or action = 'Suicide')
		AND gamedate = $gamedate
		AND server = '$server'
		ORDER BY timestamp ASC		
		";	
		//echo $sql;
		$logs = _dbquery($sql);


		$sql = "INSERT INTO `rounds` (`id`, `server`, `timestamp`, `map` ) VALUES (NULL, '".$server."', '".$gamedate."', '".mysql_escape_string($logs[0]['map'])."');";
		$id = _dbupdate($sql);




		foreach ($logs as $log)
			{
			if (!isset($output['player'][$log['who']]['kills'])) { $output['player'][$log['who']]['kills'] = 0; }
			if (!isset($output['player'][$log['target']]['deaths'])) { $output['player'][$log['target']]['deaths'] = 0; }
			if (!isset($output['player'][$log['who']]['suicides'])) { $output['player'][$log['who']]['suicides'] = 0; }		
			// was it a kill or suicide
			if ($log['action'] == 'Kill')
				{
					//add one death
					$output['player'][$log['who']]['kills']++;
					//add one death to victim
					$output['player'][$log['target']]['deaths']++;
				} elseif ($log['action'] == 'Suicide') {
					//add one suicide
					$output['player'][$log['who']]['suicides']++;
				}		
			//weapon 
			if (!isset($output['player'][$log['who']]['weapon'][$log['weapon']]) && $log['action'] == 'Kill') { $output['player'][$log['who']]['weapon'][$log['weapon']] = 0; }
			if ($log['action'] == 'Kill')
				{
					$output['player'][$log['who']]['weapon'][$log['weapon']]++;
				}
			//streaks
			if (!isset($output['player'][$log['who']]['killstreak']['count'])) { $output['player'][$log['who']]['killstreak']['count'] = 0; }
			if (!isset($output['player'][$log['target']]['deathstreak']['count'])) { $output['player'][$log['target']]['deathstreak']['count'] = 0; }
			if (!isset($output['player'][$log['who']]['killstreak']['max'])) { $output['player'][$log['who']]['killstreak']['max'] = 0; }
			if (!isset($output['player'][$log['who']]['deathstreak']['max']))	{ $output['player'][$log['who']]['deathstreak']['max'] = 0; }			
			if (!isset($output['player'][$log['target']]['killstreak']['max'])) { $output['player'][$log['target']]['killstreak']['max'] = 0; }
			if (!isset($output['player'][$log['target']]['deathstreak']['max'])) { $output['player'][$log['target']]['deathstreak']['max'] = 0; }
			// increase the kill streak counter		
			$output['player'][$log['who']]['killstreak']['count']++;
			// reset the targets counter
			$output['player'][$log['target']]['killstreak']['count']=0;
			// reset the killers death streak counter
			$output['player'][$log['who']]['deathstreak']['count']=0;
			// increase the death streak targets 
			$output['player'][$log['target']]['deathstreak']['count']++;				
			if ($output['player'][$log['who']]['killstreak']['count'] > $output['player'][$log['who']]['killstreak']['max'])
				{
					$output['player'][$log['who']]['killstreak']['max'] = $output['player'][$log['who']]['killstreak']['count'];
				}
			if ($output['player'][$log['target']]['deathstreak']['count'] > $output['player'][$log['target']]['deathstreak']['max'])
				{
					$output['player'][$log['target']]['deathstreak']['max'] = $output['player'][$log['target']]['deathstreak']['count'];
				}				
			//end of streaks
			$output['map'] = $log['map'];
			} // end of foreach 


					foreach ($output['player'] as $key => $player )
						{
					
					if (isset($player['weapon']['Blaster'])) { $blaster = $player['weapon']['Blaster']; } else { $blaster = 0; }
					if (isset($player['weapon']['Shotgun'])) { $shotgun = $player['weapon']['Shotgun']; } else { $shotgun = 0; }
					if (isset($player['weapon']['Super Shotgun'])) { $supershotgun = $player['weapon']['Super Shotgun']; } else { $supershotgun = 0; }
					if (isset($player['weapon']['Machinegun'])) { $machinegun = $player['weapon']['Machinegun']; } else { $machinegun = 0; }
					if (isset($player['weapon']['Chaingun'])) { $chaingun = $player['weapon']['Chaingun']; } else { $chaingun = 0; }
					if (isset($player['weapon']['Grenade Launcher'])) { $grenadelauncher = $player['weapon']['Grenade Launcher']; } else { $grenadelauncher = 0; }
					if (isset($player['weapon']['Rocket Launcher'])) { $rocketlauncher = $player['weapon']['Rocket Launcher']; } else { $rocketlauncher = 0; }
					if (isset($player['weapon']['Hyperblaster'])) { $hyperblaster = $player['weapon']['Hyperblaster']; } else { $hyperblaster = 0; }
					if (isset($player['weapon']['Railgun'])) { $railgun = $player['weapon']['Railgun']; } else { $railgun = 0; }
					if (isset($player['weapon']['BFG10K'])) { $bfg10k = $player['weapon']['BFG10K']; } else { $bfg10k = 0; }
					if (isset($player['weapon']['Hand Grenade'])) { $handgrenade = $player['weapon']['Hand Grenade']; } else { $handgrenade = 0; }
					if (isset($player['weapon']['Telefrag'])) { $telefrag = $player['weapon']['Telefrag']; } else { $telefrag = 0; }
					if (isset($player['weapon']['Grappling Hook'])) { $grapplinghook = $player['weapon']['Grappling Hook']; } else { $grapplinghook = 0; }
					if (isset($player['kills'])) { $kills = $player['kills']; } else { $kills = 0;}
					if (isset($player['deaths'])) { $deaths = $player['deaths']; } else { $deaths = 0; }
					if (isset($player['suicides'])) {$suicides = $player['suicides']; } else { $suicides = 0; }
					if (isset($player['killstreak'])) {$killstreak = $player['killstreak']['max']; } else { $killstreak = 0; }
					if (isset($player['deathstreak'])) { $deathstreak = $player['deathstreak']['max']; } else { $deathstreak = 0; }

					
					$sql = "
					INSERT INTO `q2stats`.`rounddetails` 
					(`id`, `roundid`, `who`, `blaster`, `shotgun`, `supershotgun`, `machinegun`, `chaingun`, `grenadelauncher`, `rocketlauncher`, `hyperblaster`, `railgun`, `bfg10k`, `handgrenade`, `telefrag`, `grapplinghook`, `kills`, `deaths`, `suicides`, `killstreak`, `deathstreak`) 
					VALUES (NULL, '".$id."', '".mysql_escape_string($key)."', '".$blaster."', '".$shotgun."', '".$supershotgun."', '".$machinegun."', '".$chaingun."', '".$grenadelauncher."', '".$rocketlauncher."', '".$hyperblaster."', '".$railgun."', '".$bfg10k."', '".$handgrenade."', '".$telefrag."', '".$grapplinghook."', '".$kills."', '".$deaths."', '".$suicides."', '".$killstreak."', '".$deathstreak."');
					";
					_dbupdate($sql);
					}
				}
		
	}

function _getrounddata($gamedate,$server)
	{
	//	$starttimer = microtime_float();

	if (!_isitindb("SELECT id FROM rounds WHERE server = '".$server."' AND timestamp ='".$gamedate."'"))
		{	
			_putrounddata($gamedate,$server);
		}	
				
			$sql = "
				SELECT *, (rounddetails.kills - rounddetails.suicides) as score FROM rounds
				LEFT JOIN rounddetails on rounds.id = rounddetails.roundid
				WHERE rounds.timestamp = '$gamedate' AND server = '$server'
				ORDER BY  score DESC, deaths ASC
			";
			
		$getdboutput = _dbquery ($sql);

		foreach ($getdboutput as $k => $v)
			{
				$out[$k + 1] = $v;
			}
		
	//	$out['timetaken'] = round(microtime_float() - $starttimer, 5);
		return($out);
	}
	
function _killstreaks_report($start = '1', $end  = '20000000', $player ='*',$timer = false)
	{
	if ($timer = true)
		{
		$starttimer = microtime_float();	
		}
		
	if ($player == '*')
		{ 
			$and = '';
		} else {
			$and = "AND (target = '$player' OR who = '$player')";
		}
		
		
	$sql ="
		SELECT timestamp, who, target,action FROM log 
		WHERE action = 'kill' or action ='suicide'
		AND timestamp between $start and $end
		$and
		ORDER BY timestamp ASC
	";
	
	//echo $sql;
	$logs = _dbquery($sql);
	
	foreach ($logs as $log)
		{
			
			// this bollocks is just getting rid of the undefined index warnings
		if (!isset($output[$log['who']]['killstreak']['count']))
			{ $output[$log['who']]['killstreak']['count'] = 0; }
		if (!isset($output[$log['target']]['deathstreak']['count']))
			{ $output[$log['target']]['deathstreak']['count'] = 0; }
			
		if (!isset($output[$log['who']]['killstreak']['max']))
			{ $output[$log['who']]['killstreak']['max'] = 0; }
		if (!isset($output[$log['who']]['deathstreak']['max']))
			{ $output[$log['who']]['deathstreak']['max'] = 0; }			
			
		if (!isset($output[$log['target']]['killstreak']['max']))
			{ $output[$log['target']]['killstreak']['max'] = 0; }
		if (!isset($output[$log['target']]['deathstreak']['max']))
			{ $output[$log['target']]['deathstreak']['max'] = 0; }	
			// end of bollocks.
			
			// increase the kill streak counter		
			$output[$log['who']]['killstreak']['count']++;
			// reset the targets counter
			$output[$log['target']]['killstreak']['count']=0;
			// reset the killers death streak counter
			$output[$log['who']]['deathstreak']['count']=0;
			// increase the targets 
			$output[$log['target']]['deathstreak']['count']++;
			
			
			//check if kill streak count is higher than the current max?
			if ($output[$log['who']]['killstreak']['count'] > $output[$log['who']]['killstreak']['max'])
				{
					$output[$log['who']]['killstreak']['max'] = $output[$log['who']]['killstreak']['count'];
				}
			if ($output[$log['target']]['deathstreak']['count'] > $output[$log['target']]['deathstreak']['max'])
				{
					$output[$log['target']]['deathstreak']['max'] = $output[$log['target']]['deathstreak']['count'];
				}
			
			
		}
		
	if ($timer = true)
		{
			$endtimer = microtime_float();
			$output['processtime'] = round($endtimer - $starttimer, 3);	
		}
		
	return($output);	
	}

function _gunbonus($start, $end)
	{
	global $bonus;
	$sql ="
	SELECT COUNT( 
	ACTION ) AS count, weapon
	FROM log
	WHERE 
	 ACTION =  'kill' AND
	 timestamp BETWEEN $start and $end
	GROUP BY weapon
	ORDER BY count DESC 
	LIMIT 0 , 30
	";
	$guncounts = _dbquery($sql);
	$i=1;

	$scores['1st']=0;
	$scores['2nd']=0;
	$scores['3rd']=0;


	foreach ($guncounts as $gun)
		{
		$bonusinfo['guns'][$gun['weapon']][1]= $scores['1st'] * $i;
		$bonusinfo['guns'][$gun['weapon']][2]= $scores['2nd'] * $i;
		$bonusinfo['guns'][$gun['weapon']][3]= $scores['3rd'] * $i;
		$i++;
		}	
		return($bonusinfo);
	}
function _time_stats($start, $end, $server ='*')
	{
		$bonus['kills']= array(1 => 200,2 => 100,3 => 50,); // i.e. positive bonus
		$bonus['deaths'] = array(1 => 0,2 => 0,3 => 0,); // negative bonus
		$output['start'] = $start;
		$output['end'] = $end;
		
	if (!_isitindb("SELECT id FROM report WHERE start = '$start'"))
		{
		$starttimer = microtime_float();
		$output['bonus'] = _gunbonus($start, $end);
		$gunssql =
		"
		SELECT DISTINCT weapon 
		FROM log 
		WHERE 
		timestamp BETWEEN $start and $end AND action = 'kill'
		";
		$guns = _dbquery($gunssql);
		foreach ($guns as $gun)
			{
				$gunkillssql = 
				"
				SELECT count(action)as kills ,who, weapon
				FROM log 
				WHERE 
				      timestamp BETWEEN $start and $end
				  AND action = 'kill'
				  AND weapon = '".$gun['weapon']."'
				GROUP BY who
				ORDER BY kills DESC
				";
				//echo	$gunkillssql;
				$gunskills = _dbquery($gunkillssql);
				$i=1;
			foreach ($gunskills as $gunskill)
				{
				$output['weapons'][$gun['weapon']][$i]['rank'] = $i;
				$output['weapons'][$gun['weapon']][$i]['who'] = $gunskill['who'];
				$output['weapons'][$gun['weapon']][$i]['kills'] = $gunskill['kills'];
				
				if (isset($output['bonus']['guns'][$gun['weapon']][$i]))
					{
			//	if ($output['weapons'][$gun['weapon']][$i]['kills'] == $output['weapons'][$gun['weapon']][$i - 1]['kills'] )	

						
					$output['weapons'][$gun['weapon']][$i]['bonus'] = $output['bonus']['guns'][$gun['weapon']][$i];
					$output['awards'][$gun['weapon']][$i]['player'] = $gunskill['who'];
					

						$output['awards'][$gun['weapon']][$i]['bonus'] = $output['bonus']['guns'][$gun['weapon']][$i];		

					
					
						
					
					} else {
					$output['weapons'][$gun['weapon']][$i]['bonus'] = 0;	
					}
				$i++;
				}
			}
/*
		$mapkillssql = 
		"
		SELECT count(action) as kills, who,map
		FROM LOG 
		WHERE 
		action = 'kill' AND
		timestamp BETWEEN $start and $end
		GROUP by who,map

		";
		$mapkills = _dbquery($mapkillssql);
*/
		//Kills 
		$killssql =
		"
		SELECT count(action) as kills, who
		FROM log 
		WHERE 
		action = 'kill' AND
		timestamp BETWEEN $start and $end
		GROUP by who
		ORDER by kills DESC
		";
		$kills    = _dbquery($killssql);
		$i=1;
		//print_r($bonus);
		foreach ($kills as $kill)
			{

				$output['player'][$kill['who']]['kills']['rank'] = $i;
				$output['player'][$kill['who']]['kills']['count'] = $kill['kills'];
				$output['player'][$kill['who']]['score'] = $kill['kills'];
				// add bonus
				if (isset($bonus['kills'][$i]))
					{
					$output['player'][$kill['who']]['kills']['bonus'] = $bonus['kills'][$i];
					$output['awards']['kills'][$i]['player'] = $kill['who'];
					$output['awards']['kills'][$i]['bonus']  = $bonus['kills'][$i];
						
					} else {
					$output['player'][$kill['who']]['kills']['bonus'] = 0;
					}
				$output['kills'][$i]['who'] = $kill['who'];
				$output['kills'][$i]['kills'] = $kill['kills'];
				$i++;

			}
			$deathssql = 
			"
		SELECT count(action) as deaths, target
		FROM log
		WHERE 
		action = 'kill' AND
		timestamp BETWEEN $start and $end
		GROUP by target
		ORDER by target DESC
		";
		$deaths   = _dbquery($deathssql);
		$i=1;
		foreach ($deaths as $death)
			{
				$output['player'][$death['target']]['deaths']['rank'] = $i;
				$output['player'][$death['target']]['deaths']['count']= $death['deaths'];
				$output['deaths'][$i]['target'] = $death['target'];
				$output['deaths'][$i]['deaths'] = $death['deaths'];
				//add bonus
				if (isset($bonus['deaths'][$i]))
					{
					$output['player'][$death['target']]['deaths']['bonus'] = $bonus['deaths'][$i];	
					$output['awards']['deaths'][$i]['player'] = $death['target'];
					$output['awards']['deaths'][$i]['bonus']  = $bonus['deaths'][$i];
					} else {
					$output['player'][$death['target']]['deaths']['bonus'] = 0;	
					}
				
				$i++;
			}
		$suicidessql =
		"
		SELECT count(action) as suicides, who
		FROM log 
		WHERE 
		action = 'suicide' AND
		timestamp BETWEEN $start and $end
		GROUP by who
		ORDER by suicides DESC
		";
		$suicides = _dbquery($suicidessql);
		$i=1;
		foreach ($suicides as $suicide)
			{
				$output['player'][$suicide['who']]['suicides']['rank'] = $i;
				$output['player'][$suicide['who']]['suicides']['count'] = $suicide['suicides'];
				if (!isset($output['player'][$suicide['who']]['score']))
					{
						$output['player'][$suicide['who']]['score'] = 0;
					}
				$output['player'][$suicide['who']]['score'] = $output['player'][$suicide['who']]['score'] - $suicide['suicides'];
				$output['suicides'][$i]['who'] = $suicide['who'];
				$output['suicides'][$i]['suicides']= $suicide['suicides'];
				//add bonus
				if (isset($bonus['deaths'][$i]))
					{
					$output['player'][$suicide['who']]['suicides']['bonus'] = $bonus['deaths'][$i];
					$output['awards']['suicides'][$i]['player'] = $suicide['who'];
					$output['awards']['suicides'][$i]['bonus']  = $bonus['deaths'][$i];
					} else {
					$output['player'][$suicide['who']]['suicides']['bonus'] = 0;	
					}
				
				$i++;
			}	

	
		foreach ($output['player'] as $key => $player)
			{
			if (!isset($output['player'][$key]['deaths']['count']))
				{
					$output['player'][$key]['deaths']['count'] = 0;
				}
			if (!isset($output['player'][$key]['suicides']['count']))
				{
					$output['player'][$key]['suicides']['count'] = 0;
				}
			if (!isset($output['player'][$key]['kills']['count']))
				{
					$output['player'][$key]['kills']['count'] = 0;
				}
				$output['player'][$key]['k2d']['value'] = _k2d ($output['player'][$key]['kills']['count'],$output['player'][$key]['deaths']['count'],$output['player'][$key]['suicides']['count']);	
				$output['player'][$key]['eff']['value'] = _efficiency ($output['player'][$key]['kills']['count'],$output['player'][$key]['deaths']['count'],$output['player'][$key]['suicides']['count']);
				$output['k2d'][$key] = $output['player'][$key]['k2d']['value'] ;

				

			}
		// add bonus's to k2d's
		arsort($output['k2d']);
		$i=1;
		foreach ($output['k2d'] as $key => $value)
			{
			$output['player'][$key]['k2d']['rank']= $i;
			if (isset($bonus['kills'][$i]))
				{
					$output['player'][$key]['k2d']['bonus'] = $bonus['kills'][$i];
					$output['awards']['k2d'][$i]['player'] = $key;
					$output['awards']['k2d'][$i]['bonus'] = $bonus['kills'][$i];
					
				} else {
					$output['player'][$key]['k2d']['bonus'] = 0;
				}
			 $i++;
			}
		
		
		// add the streaks.
		$streaks= _killstreaks_report($start, $end);
		foreach ($streaks as $key => $streak)
			{
				$output['player'][$key]['killstreak']['value'] = $streak['killstreak']['max'];
				$output['player'][$key]['deathstreak']['value'] = $streak['deathstreak']['max'];
				$output['killstreak'][$key] = $streak['killstreak']['max'];
				$output['deathstreak'][$key] = $streak['deathstreak']['max'];
			}
		// add bonus's to streaks;
		arsort($output['killstreak']);
		arsort($output['deathstreak']);
		$i=1;
		foreach ($output['killstreak'] as $key => $value)
			{
				$output['player'][$key]['killstreak']['rank'] = $i;
				if (isset($bonus['kills'][$i]))
					{
					$output['player'][$key]['killstreak']['bonus'] = $bonus['kills'][$i];
					$output['awards']['killstreak'][$i]['player'] = $key;
					$output['awards']['killstreak'][$i]['bonus']  = $bonus['kills'][$i];
					} else {
					$output['player'][$key]['killstreak']['bonus'] = 0;	
					}
				$i++;
			}
		$i=1;
		foreach ($output['deathstreak'] as $key => $value)
			{
				$output['player'][$key]['deathstreak']['rank'] = $i;
				if (isset($bonus['deaths'][$i]))
					{
					$output['player'][$key]['deathstreak']['bonus'] = $bonus['deaths'][$i];
					$output['awards']['deathstreak'][$i]['player'] = $key;
					$output['awards']['deathstreak'][$i]['bonus']  = $bonus['deaths'][$i];
					} else {
					$output['player'][$key]['deathstreak']['bonus'] = 0;	
					}
				$i++;
			}	
	
		// add up the bonus totals 
		
		foreach ($output['awards'] as $key => $value)
			{
				foreach ($value as $b)
					{
						if (!isset($output['bonustotal'][$b['player']]))
							{
								$output['bonustotal'][$b['player']] =0;
							}
						
						$output['bonustotal'][$b['player']] = $output['bonustotal'][$b['player']] + $b['bonus'];
						$output['player'][$b['player']]['bonustotal'] = $output['bonustotal'][$b['player']] + $b['bonus'];
					}
				
				
				
				
			}
	    foreach ($output['player'] as $key => $value)
			{
			if (!isset($output['player'][$key]['bonustotal']))
				{
					$output['player'][$key]['bonustotal'] = 0;
				}
			if (!isset($output['player'][$key]['score']))
				{
					$output['player'][$key]['score'] = 0;
				}
			 $output['player'][$key]['totalscore'] = $output['player'][$key]['bonustotal'] + $output['player'][$key]['score'];	
			 $output['totalscore'][$key] = $output['player'][$key]['totalscore'];	
			}
	
		//set rank by total score
		arsort($output['totalscore']);
		$i=1;
		foreach ($output['totalscore'] as $key => $value)
			{
				$output['player'][$key]['rank'] = $i;
				$i++;
			}

	
		// Rounds 
		$sql = "SELECT * FROM log WHERE action = 'kill' AND timestamp BETWEEN $start and $end";
		$rounds = _dbquery($sql);
		$round = 1;
		$i = 1;
		foreach ($rounds as $key => $value)
			{
				if (!isset($currentgame)) { $currentgame = $value['gamedate'];}


				$roundsplayed['rounds'][$value['gamedate']]['map'] 	= $value['map']; 
				if (!isset($roundsplayed['rounds'][$value['gamedate']]['players'][$value['who']])) 
					{ 
					$roundsplayed['rounds'][$value['gamedate']]['players'][$value['who']]  = 0; 
					}
				$roundsplayed['rounds'][$value['gamedate']]['players'][$value['who']] ++;
				
				
			}

	//print_r($roundsplayed['rounds']);
		foreach ($roundsplayed['rounds'] as $key => $value)
			{
			arsort($value['players']);
			//$values = array_values($value['players']);
			$keys = array_keys($value['players']);
			if (!isset($output['roundswon'][$keys[0]]))
				{
					$output['roundswon'][$keys[0]] = 0;
				}
			$output['roundswon'][$keys[0]]++;
			$output['player'][$keys[0]]['roundswon'] = $output['roundswon'][$keys[0]];
				foreach ($value['players'] as $key => $player)
					{
						if (!isset($output['roundsplayed'][$key]))
							{
								$output['roundsplayed'][$key] = 0 ;
								if (!isset($output['roundswon'][$key]))
									{
										$output['roundswon'][$key] = 0;
									}
							}
						$output['roundsplayed'][$key]++;
						$output['player'][$key]['roundsplayed'] = $output['roundsplayed'][$key];
					}
				

				
			}
		arsort($output['roundsplayed']);	
	    arsort($output['roundswon']);
		foreach ($output['player'] AS $key => $value)
			{
				 /*
				K = Kills
				V = Victims
				S = Suicides
				Mp = Maps played
				Mw = Maps won
				Skill = (K/(1+V+S)) * (1+(Mw/Mp))
				Skill = (K/(1+V+S)) * (1+(Mp/Mw))
				Skill = (K/(1+V+S)) * (1+(Mw/Mp))
				*/
			    if (isset($value['kills']['count']) && 
					isset($value['deaths']['count']) && 
					isset($value['suicides']['count']) && 
					isset($value['roundswon']) &&
					isset($value['roundsplayed']))
					{
						$K = $value['kills']['count'];
						$D = $value['deaths']['count'];
						$S = $value['suicides']['count'];
						$RP = $value['roundsplayed'];
						$RW = $value['roundswon'];
						
						$output['player'][$key]['skill'] = round(($K / (1 + $D + $S)) * (1+($RW/$RP)),2);
					}



				
				
			}
	
		$endtimer = microtime_float();
		$output['processtime'] = round($endtimer - $starttimer, 3);	
		
		return($output);
		}
	}