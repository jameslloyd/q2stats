<?php
require_once('config.php');
include('Login/updateuser.php');  // Nasty code moved to seperate file checks to see is user is new, if it is add them to db.




//Mobile phone detection


    if(empty($agent)) $agent = $_SERVER['HTTP_USER_AGENT'];
    if(!empty($agent) and preg_match("~Mozilla/[^ ]+ \((iPhone|iPod); U; CPU [^;]+ Mac OS X; [^)]+\) AppleWebKit/[^ ]+ \(KHTML, like Gecko\) Version/[^ ]+ Mobile/[^ ]+ Safari/[^ ]+~",$agent,$match)) {
        $iphone = "YES";
    } elseif(stristr($agent,'iphone') or stristr($agent,'ipod')){
        $html['iphone'] = "YES";
    } else {
        $html['iphone'] = "NO";
    }
// End of mobile detection




if ($html['iphone'] == "disabled")
	{
	 include('Page-Logic/iphone.php');
	} else {
	if (PATH == '/') 
	    { 

			$pathparams = strtolower(substr($_SERVER['REQUEST_URI'],1));   
	    } else { 
	        $pathparams = strtolower(str_replace(PATH,'',$_SERVER['REQUEST_URI'])); 
	    }
		// Url switches thingies ( ?beans=poo) make them work 
		$switches = explode ('?',$pathparams);
		$pathparams = $switches[0]; // Make path params what ever the url was without the switches.
		$fullpath = $pathparams;  // fullpath used for page counter tracking at bottom of this page
		if (isset($switches[1]))
			{
			$switch = explode ('&',$switches[1]);
			foreach ($switch as $sw)
				{
					$s = explode('=',$sw);
					$html['get'][$s[0]]= $s[1];
				}
			}
		//
	 
	
	
	
	
		// remove the www from the url.
		$domain = explode ('.',$_SERVER['SERVER_NAME']);
		if ($domain[0] == 'www') 
			{ 
				header ('location: http://'.$domain[1].'.'.$domain[2].$_SERVER['REQUEST_URI'] ) ; 
			}
		//check to see if a subdomain was requested.
		if (isset($domain[2])) // if third item is .com then there is a subdomain set.
			{
				//some code to force the page requested to be the subdomain one.
				$subdomain = true; // stop usual page renderng
				$html['group'] = $domain[0];
				$page = 'Group.php';
			} else {
			    $pathparams = explode ('/',$pathparams);
				$html['path'] = $pathparams;
				if (empty($pathparams[0]) && !isset($subdomain))
					    {
					        $page = 'homepage.php'; // Root path called so home page
					    } else {
					       if (file_exists('Page-Logic/' . $pathparams[0] . '.php') && !isset($subdomain)) // Does that page exist? if not 404
					        {
					            $page = $pathparams[0].'.php';
					        } else {
					            $page = '404.php';
					        }
					    }			
			}
	//Render the normal page page

	include('Page-Logic/'.$page);
	}
$fullpath = urldecode($fullpath);
$pageviews = _dbquery("SELECT count FROM pagestats WHERE page = '".$fullpath."'");
if (isset($pageviews[0]['count']))
	{
		$html['pageviews'] = $pageviews[0]['count'];
	} else {
		$html['pageviews'] = 1;
	}




if (_isitindb("SELECT id FROM pagestats WHERE page = '".$fullpath."'"))
	{
	_dbupdate("UPDATE pagestats SET count = count + 1 WHERE page ='".$fullpath."';");	
	} else {
	$sql = "
	INSERT INTO  `q2stats`.`pagestats` (
	`id` ,
	`page` ,
	`count`
	)
	VALUES (
	NULL ,  '".$fullpath."',  '1'
	);
	";
	_dbupdate($sql);
	}

?>