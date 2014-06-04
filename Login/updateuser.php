<?php
// user bit
if (isset($_SESSION['email']) && isset($_SESSION['fname']) && isset($_SESSION['lname'])) // if they are indeed loggedin
	{
	if (!_isitindb("SELECT `email` FROM `users` WHERE `email` = '".$_SESSION['email']."'") && $_SESSION['loggedin'] == 'true')
		{
		$googleusername= explode('@',$_SESSION['email']);
		$_SESSION['googleusername'] = $googleusername[0];
		_dbupdate("INSERT INTO `users` (`id` ,`timestamp`,`email`,`googleusername`,`fname`,`lname`)
				VALUES (NULL , UNIX_TIMESTAMP() ,  '".$_SESSION['email']."', '".$googleusername[0]."', '".$_SESSION['lname']."', '".$_SESSION['fname']."')");
		$html['displayname'] = $_SESSION['fname'];  // this is for the first time you log in, it's going to default to first name anyway so im forcing it.
		} else {
		//user already exists refresh
		$userid = _dbupdate("UPDATE `users` SET  `fname` =  '".$_SESSION['fname']."', `lname` =  '".$_SESSION['lname']."' WHERE  `users`.`email` = '".$_SESSION['email']."' LIMIT 1;");
		$_SESSION['userid'] = $userid[0]['id'];
		$googleusername= explode('@',$_SESSION['email']);	
		$_SESSION['googleusername'] = $googleusername[0];
		
		//get all user data
		$userdbdata = _dbquery("SELECT * FROM `users` WHERE `email` = '".$_SESSION['email']."'");
		$_SESSION['level'] = $userdbdata[0]['level'];
		if (!$userdbdata[0]['status'] == 'enabled') { die('account temporarily disabled by admin'); }
		$html['userdbdata']=$userdbdata[0];
		switch ($html['userdbdata']['knownas']){
			case 'First Name':
				$displayname = $_SESSION['fname'];
				break;
			case 'Last Name':
				$displayname = $_SESSION['lname'];
				break;
			case 'Nick Name':
				$displayname = $html['userdbdata']['nick'];
				break;
				}
		$html['displayname'] = $displayname;
		}
		if (!isset($_SESSION['userid']))
			{
				$userid = _dbquery("SELECT id FROM users WHERE email = '".$_SESSION['email']."'");
				$_SESSION['userid'] = $userid[0]['id'];
			}
	}
// end of user bit
?>