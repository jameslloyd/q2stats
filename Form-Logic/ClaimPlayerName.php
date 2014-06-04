<?php
require_once('../config.php');
echo '<pre>';
print_r($_SESSION);
print_r($html);
echo '</pre>';
if (isset($_POST) && isset($_SESSION['level']) && $_SESSION['level'] >= 1 )
	{
	print_r($_POST);
	if (_isitindb("SELECT id FROM users WHERE playername = '".mysql_escape_string($_POST['playername'])."'"))
		{
			header( 'location: http://'.DOMAIN .'/MyProfile?claim=fail&playername='.$_POST['playername']);
		} else {
			_dbupdate("UPDATE  `q2stats`.`users` SET  `playername` =  '".mysql_escape_string($_POST['playername'])."' WHERE  `users`.`googleusername` ='".$_SESSION['googleusername']."';");
			header( 'location: http://'.DOMAIN .'/MyProfile?claim=success&playername='.$_POST['playername']);
		}
		
	} else {
//	header( 'location: http://' DOMAIN . '/page-not-found');
	}

?>