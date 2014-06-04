<?php
function _getgraph_data($server,$action = 'kills',$time = '86400')
	{
		$guns = array('Blaster','Shotgun','Super Shotgun','Machinegun','Chaingun','Grenade Launcher','Rocket Launcher','Hyperblaster','Railgun','BFG10K','Hand Grenade','Telefrag','Grappling Hook');
		$sql = "
			SELECT timestamp FROM log 
			WHERE server = '".$server."'
			AND action = '".$action."'
			ORDER BY timestamp DESC
		";	
		$dbdata = _dbquery($sql);
		$now = date("U");
		$count = 0;
		$i=0;
		foreach ($dbdata as $kill)
			{
				if ($kill['timestamp'] > $now - $time)
					{
						$count++;
						$data[$i]['count']=$count;
						$data[$i]['time'] =$now;
						
					} else {
						$count=0;
						$now = $now - $time;
						$i++;
						$data[$i]['count']=$count;
						$data[$i]['time'] =$now;
					}

			}
		return($data); 
	}
function _getgraph_player_data($player,$action = 'kill',$time = '86400')
	{
		$servers = _dbquery("SELECT DISTINCT server FROM log WHERE who = '".$player."'");
		foreach ($servers as $server)
			{
			$sql = "
				SELECT timestamp FROM log 
				WHERE who = '".$player."' 
				AND server = '".$server['server']."'
				AND action = '".$action."'
				ORDER BY timestamp DESC
			";	

			$dbdata = _dbquery($sql);
			$now = date("U");
			$allcount=0;
			$count = 0;
			$i=0;
			foreach ($dbdata as $kill)
				{
					if ($kill['timestamp'] > $now - $time)
						{
							$count++;
							$data[$i]['count']=$count;
							$data[$i]['time'] =$now;

						} else {
							$count =0;
							$now = $now - $time;
							$i++;
							$data[$i]['count']=$count+1;
							$data[$i]['time'] =$now;
						}

				}
			  $output[$server['server']]=$data;
			 unset($data);
			}
			 
		return($output); 
	}
?>