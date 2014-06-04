<?php
include('config.php');
_dbupdate("SET @rank=0;");
$sql ="
	SELECT @rank := @rank+1 as rank, who, railgun
	FROM 
	(SELECT who, sum(railgun) as railgun 
	FROM rounddetails
	GROUP BY who
	ORDER BY railgun DESC) AS temptable
	WHERE who = 'kungfumonkay'
";
_dbquery($sql,MYSQL_ASSOC,true);
?>