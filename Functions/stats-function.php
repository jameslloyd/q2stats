<?php

function _getstats($player = '',$server = '')
	{
		if ($server !== '')
			{
				$clause = "server = '$server'";
			}
		if ($player !== '')
			{
				$clause .= ""
			}
		
		$kills = _dbquery("SELECT who, kills FROM total_kills_server WHERE server = '".$pathparams[0]."'");
		$deaths = _dbquery("SELECT target, deaths FROM total_deaths_server WHERE server = '".$pathparams[0]."'");
		$suicides = _dbquery("SELECT who, suicides FROM total_suicides_server WHERE server = '".$pathparams[0]."'");

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
						$data[$key]['k2d'] =  round($data[$key]['kills'] / ($data[$key]['suicides']+$data[$key]['deaths']), 2);
					} else {
						$data[$key]['k2d'] = 0;
					}

			}
		
	}