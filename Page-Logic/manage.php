<?php
$servers = _dbquery("SELECT * FROM `servers` WHERE `owner` = '".$_SESSION['googleusername']."'");
$userinfo = _dbquery("SELECT * FROM `users` WHERE googleusername = '".$_SESSION['googleusername']."' ");

require_once('Thirdparty/lgsl/lgsl_files/lgsl_protocol.php');
if (!empty($servers))
	{
	foreach ($servers as $key => $server)
		{
	
			$servers[$key]['live'] = lgsl_query_live('quake2', $server['serverip'], $server['serverport'], $server['serverport'], '0', 's');
		$sql = 
			"
			UPDATE  `q2stats`.`servers` 
			SET  `servername` =  '".$servers[$key]['live']['s']['name']."' 
			WHERE  `servers`.`id` = ".$server['id'].";
			";	
			//echo $sql;
			_dbupdate($sql);
	
		}
	$smarty->assign('servers', $servers);
	}

$smarty->assign('html', $html);
$smarty->assign('userinfo', $userinfo[0]);
$smarty->display('manage.tpl');
?>