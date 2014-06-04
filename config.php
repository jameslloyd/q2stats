<?php
// Start Timer
function microtime_float () 
	{ 
	    list ($msec, $sec) = explode(' ', microtime()); 
	    $microtime = (float)$msec + (float)$sec; 
	    return $microtime; 
	}
$startglobaltimer = microtime_float();

// Start the session in here as it needs to be at the top of the code
        session_start();

// Paths
define( "DOMAIN", 'q2stats-dev.com'); // this is required for the subdomain stuff.
define( "PATH" , '/'); // Where the site sits relavtive to the wwwroot
define( "INSTALL" , $_SERVER['DOCUMENT_ROOT'] . PATH ); // Where the actual thing is located on the disk

// Setup Smarty 
require_once( 'Thirdparty/Smarty/libs/Smarty.class.php' );
$smarty = new Smarty();
$smarty->template_dir = 'Templates';
$smarty->compile_dir = 'Templates/smarty/templates_c';
$smarty->cache_dir = 'Templates/smarty/cache';
$smarty->config_dir = 'Templates/smarty/configs';

$database['dbhost'] = 'localhost';
$database['user']   = '';
//$database['pass']   = '';
$database['pass']       = '';
$database['dbname'] = 'q2stats';

//Default html elements
$html['domainname'] = DOMAIN;
$html['wwwroot'] = PATH;
$html['description'] = 'You haven\'t set a description you chump!';
$html['keywords'] = 'hello, and , stuff';
$html['name'] = 'Q2Stats';
$html['header'] = 'Q2Stats';
$html['session'] = $_SESSION;
$html['title'] = 'Q2Stats';
$guns = array('Blaster','Shotgun','Super Shotgun','Machinegun','Chaingun','Grenade Launcher','Rocket Launcher','Hyperblaster','Railgun','BFG10K','Hand Grenade','Telefrag','Grappling Hook');

if (isset($_SERVER['HTTP_REFERER'])) { $html['lastpage'] = $_SERVER['HTTP_REFERER']; }

require_once('Functions/mysql-functions.php');
require_once('Functions/microtime-functions.php');
require_once('Functions/graph-functions.php');
require_once('Functions/common-calcs.php');
require_once('Functions/file-functions.php');
require_once('Functions/report-functions.php');



if (!isset($html['revision'])) { 
    if (file_exists( '.svn' . DS . 'entries')) { 
        $svn = file( '.svn' . DS . 'entries'); 
        if (is_numeric(trim($svn[3]))) { 
            $version = $svn[3]; 
        } else { // pre 1.4 svn used xml for this file 
            $version = explode('"', $svn[4]); 
            $version = $version[1];     
        } 
        $html['revision'] = trim($version); 
        unset ($svn); 
        unset ($version); 
    } else { 
        $html['revision'] = 'no data'; // default if no svn data avilable 
    } 
}
?>
