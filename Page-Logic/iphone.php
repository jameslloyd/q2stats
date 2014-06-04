<?php
if (!isset($pathparams[0]))
	{
		//iphone home page
	$top10 = _dbquery ("
		SELECT * FROM `player_summary` 
		WHERE deaths IS NOT NULL AND suicides IS NOT NULL
		ORDER By Kills DESC Limit 0,10
	 ");

	$smarty->assign('top10', $top10);
	$smarty->assign('html', $html);
	$smarty->display('iphone/home.tpl');
	} elseif ($pathparams[0] == 'Players' && isset($pathparams[1])) {
	  //player page
		
		
	}
?>