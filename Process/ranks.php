<?php
require_once('/var/www/html/q2stats/config.php');

$kills = _total_kills();
$deaths = _total_deaths();
$suicides = _total_suicides();

foreach ($kills as $key => $kill)
	{
	$rank = $key + 1;
		if (_isitindb("SELECT id FROM ranks WHERE name = '".mysql_escape_string($kill['who'])."'"))
			{
				$id = _dbquery("SELECT id FROM ranks WHERE name = '".mysql_escape_string($kill['who'])."'");

				$sql = "
				UPDATE `ranks` SET  `kills` =  '".$kill['kills']."', 
									`killsrank` =  '". $rank ."' 
				WHERE  `ranks`.`id` =".$id[0]['id'];
				_dbupdate($sql);
			} else {
				$who = mysql_escape_string($kill['who']);
				$sql = "INSERT INTO `q2stats`.`ranks` (`id`, `name`, `kills`, `killsrank`, `deaths`, `deathsrank`, `suicides`, `suicidesrank`) VALUES (NULL, '". $who ."', '".$kill['kills']."', '".$rank."', '0', '0', '0', '0');";
				_dbupdate($sql);
			}
	}
	foreach ($deaths as $key => $death)
		{
		$rank = $key + 1;
		$who = mysql_escape_string($death['target']);
		$count = $death['deaths'];
		
			if (_isitindb("SELECT id FROM ranks WHERE name = '".$who."'"))
				{
					$id = _dbquery("SELECT id FROM ranks WHERE name = '".$who."'");

					$sql = "
					UPDATE `ranks` SET  `deaths` =  '".$count."', 
										`deathsrank` =  '". $rank ."' 
					WHERE  `ranks`.`id` =".$id[0]['id'];
					_dbupdate($sql);
				} else {
					$sql = "
					INSERT INTO `q2stats`.`ranks` (`id`, `name`, `kills`, `killsrank`, `deaths`, `deathsrank`, `suicides`, `suicidesrank`) 
					VALUES (NULL, '". $who ."', '0', '0', '". $count ."', '". $rank ."', '0', '0')";
					_dbupdate($sql);
				}
		}
foreach ($suicides as $key => $suicide)
	{
	$rank = $key + 1;
	$who = mysql_escape_string($suicide['who']);
	$count = $suicide['suicides'];

		if (_isitindb("SELECT id FROM ranks WHERE name = '".$who."'"))
			{
				$id = _dbquery("SELECT id FROM ranks WHERE name = '".$who."'");

				$sql = "
				UPDATE `ranks` SET  `suicides` =  '".$count."', 
									`suicidesrank` =  '". $rank ."' 
				WHERE  `ranks`.`id` =".$id[0]['id'];
				_dbupdate($sql);
			} else {
				$sql = "
				INSERT INTO `q2stats`.`ranks` (`id`, `name`, `kills`, `killsrank`, `deaths`, `deathsrank`, `suicides`, `suicidesrank`) 
				VALUES (NULL, '". $who ."', '0', '0', '0', '0', '". $count ."', '". $rank ."')";
				_dbupdate($sql);
			}
	}
?>
