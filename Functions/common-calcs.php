<?php
function _deathstreaks_player($player)
	{ 
		$servers = _dbquery ("SELECT DISTINCT server FROM log WHERE who = '".$player."'");
		foreach ($servers as $server)
			{
				$sql = "
					SELECT * FROM log
					WHERE (who = '".$player."' OR target = '".$player."') AND server = '".$server['server']."'
				";				
				$logs = _dbquery($sql);

				$i=0;
				$count=0;
				$max=0;

				foreach ($logs as $log)
					{
						if ($log['who'] != $player && $log['target'] ==$player )
							{
								$count++;
								if ($count > $max)
									{
										$max = $count;
									}
							} else {
								$count = 0;
							}
					}
					//echo $max;
					$deathstreak[$server['server']] = $max;
									
			}
		arsort($deathstreak);
		return($deathstreak);
	}
function _killstreaks_player($player)
	{ 
		$servers = _dbquery ("SELECT DISTINCT server FROM log WHERE who = '".$player."'");
		foreach ($servers as $server)
			{
				$sql = "
					SELECT * FROM log
					WHERE (who = '".$player."' OR target = '".$player."') AND server = '".$server['server']."'
				";				
				$logs = _dbquery($sql);

				$i=0;
				$count=0;
				$max=0;

				foreach ($logs as $log)
					{
						if ($log['who'] == $player && $log['target'] !=$player )
							{
								$count++;
								if ($count > $max)
									{
										$max = $count;
									}
							} else {
								$count = 0;
							}
					}
					//echo $max;
					$killstreak[$server['server']] = $max;
									
			}
		arsort($killstreak);
		return($killstreak);
	}
function _deathstreaks_server($server)
	{
		$players = _dbquery("SELECT DISTINCT who FROM log WHERE server = '".$server."'");
		if (isset($players[0]))
			{
		foreach ($players as $player)
			{
			$playername = $player['who'];
			$sql = "
				SELECT * FROM log
				WHERE (who = '".$playername."' OR target = '".$playername."') AND server = '".$server."'
			";
			$logs = _dbquery($sql);

			$i=0;
			$count=0;
			$max=0;

			foreach ($logs as $log)
				{
					if ($log['target'] == $playername && $log['who'] !=$playername )
						{
							$count++;
							if ($count > $max)
								{
									$max = $count;
								}
						} else {
							$count = 0;
						}
				}
				//echo $max;
				$deathstreak[$player['target']] = $max;
			}
			}
	 if (isset($deathstreak))	
		{ 
		arsort($deathstreak); 
		return($deathstreak);		
		}
	}
function _killstreaks_server($server)
	{
		$players = _dbquery("SELECT DISTINCT who FROM log WHERE server = '".$server."'");
		if (isset($players[0]))
			{
		foreach ($players as $player)
			{
			$playername = $player['who'];
			$sql = "
				SELECT * FROM log
				WHERE (who = '".$playername."' OR target = '".$playername."') AND server = '".$server."'
			";
			$logs = _dbquery($sql);

			$i=0;
			$count=0;
			$max=0;

			foreach ($logs as $log)
				{
					if ($log['who'] == $playername && $log['target'] !=$playername )
						{
							$count++;
							if ($count > $max)
								{
									$max = $count;
								}
						} else {
							$count = 0;
						}
				}
				//echo $max;
				$killstreak[$player['who']] = $max;
			}
			}
		if (isset($killstreak))
			{
				arsort($killstreak);
				return($killstreak);		
			}
	}


function _efficiency ($kills,$deaths,$suicides,$round = 1)
	{
	/*	if ($kills == 0)
			{
					$output = 0;
				} else {
		$output = round((($kills - ($suicides+$deaths)) / $kills) * 100,$round); 
		$output = round(($kills * 100) / ($suicides + $deaths), $round);
			//} */
		$output = round(($kills / ($kills + $deaths + $suicides)) * 100,$round);
		return($output);
	}
function _k2d ($kills,$deaths,$suicides,$round = 2)
	{
		if ($kills == 0)
			{
				$output = 0;
			} elseif ($suicides+$deaths == 0) {
				$output = 1;
			} else {
		$output = round($kills / ($suicides+$deaths) , $round);
			}
		return($output);
	}
function _total_kills($server='*')
	{
		if ($server == '*')
			{
				$and = '';
			} else {
				$and = " AND server = '".$server."'";
			}
			
			$sql = "
			SELECT *
			FROM ( SELECT count(action) as kills,who
			FROM log 
			WHERE action = 'kill'
			GROUP BY who
			) as tmp
			ORDER BY kills DESC";
		return(_dbquery($sql));
	}
function _total_deaths	($server='*')
		{
			if ($server == '*')
				{
					$and = '';
				} else {
					$and = " AND server = '".$server."'";
				}
		$sql ="
			SELECT *
			FROM ( SELECT count(action) as deaths,target
			FROM log 
			WHERE action = 'kill'
			GROUP BY target
			) as tmp
			ORDER BY deaths DESC
		";
		return(_dbquery($sql));
	}
function _total_suicides	($server='*')
		{
			if ($server == '*')
				{
					$and = '';
				} else {
					$and = " AND server = '".$server."'";
				}
		$sql ="
			SELECT *
			FROM ( SELECT count(action) as suicides,who
			FROM log 
			WHERE action = 'suicide'
			GROUP BY who
			) as tmp
			ORDER BY suicides DESC
		";
		return(_dbquery($sql));
	}
?>
