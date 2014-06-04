<?php 
require_once('../config.php');

$min = '10';   // i.e the min number before its ranked i.e. 5 will only count people with more than 5 kills
$top = '5';    // i.e. the number to be ranked i.e. 5 giving top 5 xx


$servers = _dbquery("SELECT DISTINCT server FROM log",MYSQL_ASSOC,true);


$sql_topkills = "
	SELECT *
	FROM (
	SELECT count(action) as kills,who FROM log 
	WHERE server = '".$server."' 

	GROUP BY who
	) as tmp
	WHERE kills > ".$min."
	ORDER BY kills DESC
	LIMIT 0,".$top."
";




foreach ($servers as $server)
	{
		foreach (_dbquery($sql_topkills) as $key => $rank)
			{
			$sql = "
			INSERT INTO 		
			`awards` (`id`, `award`, `group`, `server`, `timestamp`, `who`, `position`, `score`, `period`) 
			VALUES (NULL, 'top".$top." kills', ' ', '".$server."', ".date("U").", '".$rank['who']."', '', '', '');
			";
				
			}
		
	}


?>