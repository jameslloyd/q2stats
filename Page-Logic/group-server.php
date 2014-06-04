<?php
require_once('Thirdparty/lgsl/lgsl_files/lgsl_protocol.php');
$serveraddress = explode (':',$pathparams[0]);
//get data for kills per day graph

$graph['kills'] = _getgraph_data($pathparams[0],'kill');
$graph['suicides'] = _getgraph_data($pathparams[0],'suicide');




$kills = _dbquery("SELECT who, kills FROM total_kills_server WHERE server = '".$pathparams[0]."' ");
$deaths = _dbquery("SELECT target, deaths FROM total_deaths_server WHERE server = '".$pathparams[0]."' ");
$suicides = _dbquery("SELECT who, suicides FROM total_suicides_server WHERE server = '".$pathparams[0]."' ");

foreach ($kills as $kill)
	{
		$data[$kill['who']]['kills'] = $kill['kills']; 
	}
foreach ($deaths as $death)
	{
		$data[$death['target']]['deaths'] = $death['deaths']; 
	}
foreach ($suicides as $suicide)
	{
		$data[$suicide['who']]['suicides'] = $suicide['suicides']; 
	}
foreach ( $data as $key => $value)
	{
		if (!isset($value['kills']))
			{
			 $data[$key]['kills']=0;	
			}
		if (!isset($value['deaths']))
			{
			 $data[$key]['deaths']=0;	
			}
		if (!isset($value['suicides']))
			{
			 $data[$key]['suicides']=0;	
			}
		if ($data[$key]['kills'] > 0)
			{
				$data[$key]['k2d'] =  _k2d($data[$key]['kills'],$data[$key]['deaths'],$data[$key]['suicides']);
				$data[$key]['eff'] =  _efficiency($data[$key]['kills'],$data[$key]['deaths'],$data[$key]['suicides']);
			} else {
				$data[$key]['k2d'] = 0;
			}
  					
	}
$server['live'] = lgsl_query_live('quake2', $serveraddress[0], $serveraddress[1], $serveraddress[1], '0', 's');
$smarty->assign('server', $data);
$smarty->assign('graph', $graph);
$smarty->assign('html', $html);
$smarty->display('group-server.tpl');
?>
