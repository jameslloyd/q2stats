<?php
$pathparams[1] = urldecode($pathparams[1]);
$sql ="
	SELECT count(action) as kills, weapon, who
	FROM log 
	WHERE action = 'kill' and weapon = '".$pathparams[1]."'
	GROUP BY who
	ORDER BY kills DESC
";

$killwith = _dbquery($sql);

$sql ="
	SELECT count(action) as kills, weapon, target
	FROM log 
	WHERE action = 'kill' and weapon = '".$pathparams[1]."'
	GROUP BY target
	ORDER BY kills DESC
";
$killedby = _dbquery($sql);
$smarty->assign('weaponname', $pathparams[1]);
$smarty->assign('killedby', $killedby);
$smarty->assign('killwith', $killwith);
$smarty->assign('html', $html);
$smarty->display('weapon.tpl');
?>