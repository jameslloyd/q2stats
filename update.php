<?php
$options=getopt('i:p:f:v');
require_once('config.php');
//print_r($options);
foreach ($options as $option)
	{
		if (empty($option))
			{ die ('more stuff required'); }
	}
$serveripport = $options['i'].':'.$options['p'];
$dirname = $options['f'];
$dirlist = _list_dir($dirname,'log');
//print_r($dirlist);

if ($dirlist == false) { die ('nothing to do '); }	
foreach($dirlist as $key => $item)
	{
	$filename = $item['filename'];
	$handle = fopen($dirname.'/'.$filename, "r");
	$lines = file($dirname.'/'.$filename);
	$counter = 0;
	$loglineskipped = 0;
	$loglineinserted = 0;
	fclose($handle);
	$i=0;$gameid=0;$added=0;
	//_dbupdate ("TRUNCATE TABLE `log`");
	$sql = "SELECT max(timestamp) as timestamp FROM log where server = '".$serveripport."'";
	$latest = _dbquery ($sql);
	$start = microtime_float();
	foreach ($lines as $line => $item)
	    {
	        $counter++;
	    $lineitem=explode("\\t",preg_replace("/\t/","\\t",$item));  // Explode on Tab!
	    //print_r($lineitem);echo '<br>';
		if (isset($lineitem[2]))
			{
		    switch ($lineitem[2])
				{
		      		case "Map":
		        		$game['Map']=trim($lineitem[3]);
		        		break;
		      		case "LogDate":
		        		$game['LogDate']=trim($lineitem[3]);
		        		break;
		      		case "LogTime":
		       			$game['LogTime']=trim($lineitem[3]);
		        		break;
			      	case "GameStart":
			       			$game['GameStart']=trim($lineitem[5]);
			        		break; 
					case "GameEnd":
			       			$game['GameEnd']=trim($lineitem[5]);
			        		break;
		      		case "Kill":
						$ts = strtotime($game['LogDate'] .' '. $game['LogTime']);
		     			$timestamp = date ('d M Y H:i:s', $ts);
						//	echo $ts.'<br>';
						if (!isset($firstgame)) { $firstgame = strtotime($game['LogDate'] .' '.$game['LogTime']); }
						$lastgame = strtotime($game['LogDate'] .' '.$game['LogTime']);
		        		$databaseline[$i]=array(
									'timestamp'=> $ts +$lineitem[5],
									'gamedate' => strtotime($game['LogDate'] .' '.$game['LogTime']),
		                            'map'      => mysql_escape_string($game['Map']),
		                            'action'   => 'Kill',
		                            'who'      => mysql_escape_string($lineitem[0]), 
		                            'target'   => mysql_escape_string($lineitem[1]),
		                            'weapon'   => mysql_escape_string($lineitem[3]),
									'ping'	   => $lineitem[6],
		                            );
						$i++;
						break;
		      		case "Suicide":
					$ts = strtotime($game['LogDate'] .' '. $game['LogTime']);
		 			$timestamp = date ('d M Y H:i:s', $ts); 
		       			$databaseline[$i]=array(
									'timestamp'=> $ts +$lineitem[5],
									'gamedate' => strtotime($game['LogDate'] .' '.$game['LogTime']),						
		                            'map'      => mysql_escape_string($game['Map']), 
		                            'action'   => 'Suicide',
		                            'who'      => mysql_escape_string($lineitem[0]), 
		                            'target'   => mysql_escape_string($lineitem[0]),
		                            'weapon'   => mysql_escape_string($lineitem[3]),  
									'ping'	   => $lineitem[6],
		                            );
						$i++;
						break;
					case "PlayerConnect":
					$ts = strtotime($game['LogDate'] .' '. $game['LogTime']);
		 			$timestamp = date ('d M Y H:i:s', $ts);
						$databaseline[$i]=array(
							'timestamp'=> $ts +$lineitem[5],
							'gamedate' => strtotime($game['LogDate'] .' '.$game['LogTime']),						
		                    'map'      => mysql_escape_string($game['Map']), 
		                    'action'   => 'PlayerConnect',
		                    'who'      => mysql_escape_string($lineitem[3]), 
		                    'target'   => mysql_escape_string($lineitem[3]),
		                    'weapon'   => mysql_escape_string($lineitem[3]),					
							);
						$i++;
						break;
					case "PlayerLeft":
					$ts = strtotime($game['LogDate'] .' '. $game['LogTime']);
		 			$timestamp = date ('d M Y H:i:s', $ts);
						$databaseline[$i]=array(
							'timestamp'=> $ts +$lineitem[5],
							'gamedate' => strtotime($game['LogDate'] .' '.$game['LogTime']),						
		                    'map'      => mysql_escape_string($game['Map']), 
		                    'action'   => 'PlayerLeft',
		                    'who'      => mysql_escape_string($lineitem[3]), 
		                    'target'   => mysql_escape_string($lineitem[3]),
		                    'weapon'   => mysql_escape_string($lineitem[3]),					
							);
						$i++;
						break;
					case "PlayerRename":
					$ts = strtotime($game['LogDate'] .' '. $game['LogTime']);
		 			$timestamp = date ('d M Y H:i:s', $ts);
						$databaseline[$i]=array(
							'timestamp'=> $ts +$lineitem[5],
							'gamedate' => strtotime($game['LogDate'] .' '.$game['LogTime']),						
		                    'map'      => mysql_escape_string($game['Map']), 
		                    'action'   => 'PlayerRename',
		                    'who'      => mysql_escape_string($lineitem[3]), 
		                    'target'   => mysql_escape_string($lineitem[4]),
		                    'weapon'   => mysql_escape_string($lineitem[3]),					
							);
						$i++;
						break;
						case "PlayerTeamChange":
						$ts = strtotime($game['LogDate'] .' '. $game['LogTime']);
			 			$timestamp = date ('d M Y H:i:s', $ts);
							$databaseline[$i]=array(
								'timestamp'=> $ts +$lineitem[5],
								'gamedate' => strtotime($game['LogDate'] .' '.$game['LogTime']),						
			                    'map'      => mysql_escape_string($game['Map']), 
			                    'action'   => 'PlayerTeamChange',
			                    'who'      => mysql_escape_string($lineitem[3]), 
			                    'target'   => mysql_escape_string($lineitem[4]),
			                    'weapon'   => mysql_escape_string($lineitem[3]),					
								);
							$i++;
							break;
				}
			}
		}
	//print_r($databaseline);
	foreach ($databaseline as $line)
		{
		if (!isset($line['ping'])) { $line['ping'] = 'NULL';}
		if ($line['timestamp'] > $latest[0]['timestamp'])

				{
			
				$sql="INSERT INTO `q2stats`.`log` (`id`, `timestamp`, `gamedate`, `map`, `action`, `who`, `target`, `weapon`, `server`, `ping`) 
				VALUES (NULL, '".$line['timestamp']."', '".$line['gamedate']."', '".$line['map']."', '".$line['action']."', '".$line['who']."', '".$line['target']."', '".$line['weapon']."', '".$serveripport."', '".$line['ping']."');";
				_dbupdate($sql);
			$loglineinserted++;
				} else {
				$loglineskipped++;	
				}
		}

	$end = microtime_float();
	$sql = "
	INSERT INTO `updates`
	(`id`,`timestamp`,`lines`,`actions`,`processtime`,`inserted`,`skipped`,`server`)
	VALUES
	(NULL, '".date("U")."','".$counter."','".$i."','".round($end - $start, 3)."','".$loglineinserted."','".$loglineskipped."','".$serveripport."' )
	";
	_dbupdate($sql);
	//unset($databaseline);
	rename($dirname.'/'.$filename, $dirname.'/'.$filename.'.processed');
	//unlink($dirname.'/'.$filename);
	}
?>
