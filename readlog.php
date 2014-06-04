<?php
require_once('config.php');

$handle = fopen($filename, "r");
$lines = file($filename);
$counter = 0;
$loglineskipped = 0;
$loglineinserted = 0;
fclose($handle);
$i=0;$gameid=0;$added=0;
//_dbupdate ("TRUNCATE TABLE `log`");
$start = microtime_float();
foreach ($lines as $line => $item)
    {
        $counter++;
    $lineitem=explode("\\t",preg_replace("/\t/","\\t",$item));  // Explode on Tab!
    //print_r($lineitem);echo '<br>';
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
        		$databaseline[$i]=array(
							'timestamp'=> $ts +$lineitem[5],
							'gamedate' => strtotime($game['LogDate'] .' '.$game['LogTime']),
                            'map'      => mysql_escape_string($game['Map']),
                            'action'   => 'Kill',
                            'who'      => mysql_escape_string($lineitem[0]), 
                            'target'   => mysql_escape_string($lineitem[1]),
                            'weapon'   => mysql_escape_string($lineitem[3]),
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
//print_r($databaseline);
foreach ($databaseline as $line)
	{
		if (!_isitindb("SELECT `id` FROM `log` WHERE 
			`timestamp` = '".$line['timestamp']."' AND
			`gamedate`  = '".$line['gamedate']."' AND
			`map` 		= '".$line['map']."' AND
			`action`    = '".$line['action']."' AND
			`who`		= '".$line['who']."' AND
			`target` 	= '".$line['target']."' AND
			`weapon`	= '".$line['weapon']."' AND
			`server` 	= '".$serveripport."' "
		))
			{
			
			$sql="INSERT INTO `q2stats`.`log` (`id`, `timestamp`, `gamedate`, `map`, `action`, `who`, `target`, `weapon`, `server`) 
			VALUES (NULL, '".$line['timestamp']."', '".$line['gamedate']."', '".$line['map']."', '".$line['action']."', '".$line['who']."', '".$line['target']."', '".$line['weapon']."', '".$serveripport."');";
			_dbupdate($sql);
		$loglineinserted++;
			} else {
			$loglineskipped++;	
			}
	}

$end = microtime_float();
$sql = "
INSERT INTO `updates`
(`id`,`timestamp`,`lines`,`actions`,`processtime`,`inserted`,`skipped`)
VALUES
(NULL, '".date("U")."','".$counter."','".round($end - $start, 3)."','".$loglineinserted."','".INSERT INTO `updates`
(`id`,`timestamp`,`lines`,`actions`,`processtime`,`inserted`,`skipped`)
VALUES
(NULL, '1281861921','5292','317,'0.38','0','317' )
" )
";



?>