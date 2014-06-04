<?php  
include('../config.php');
include('../Thirdparty/GoogleAuth/GoogleOpenID.php');
$_SESSION['loginreturn'] = $html['lastpage'];
// is there a handle in the db
$sql = "SELECT * FROM `googleauth`";
$googlehandle = _dbquery($sql);
if (!$googlehandle)
	{

	$handle = GoogleOpenID::getAssociationHandle();
	$sql = "INSERT INTO `googleauth` (`handle`, `timestamp`) VALUES ('".$handle."', UNIX_TIMESTAMP());";
	_dbupdate($sql);
	} else {

	// there is one check the timestamp
	$twoweeks='1209600';
	if ($googlehandle[0]['timestamp']+$twoweeks < date('U'))
		{ 	
			$handle = $googlehandle[0]['handle'];
		} else {
			// handle expired get a new one
			$handle = GoogleOpenID::getAssociationHandle();
			$sql = "UPDATE `googleauth` SET `handle` = '".$handle."', `timestamp` = UNIX_TIMESTAMP() 
					WHERE `googleauth`.`handle` = '".$googlehandle[0]['handle']."' AND `googleauth`.`timestamp` = '".$googlehandle[0]['timestamp']."' LIMIT 1;";
			_dbupdate($sql);
		}
	
	}

$googleLogin = GoogleOpenID::createRequest(PATH . "Login/return.php", $handle, true);
$googleLogin->redirect();
?>
