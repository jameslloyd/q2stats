<?php
require_once('../config.php');
if (isset($_POST) && $_SESSION['level'] >= 1 && isset($_POST['group']))
	{
		$group = mysql_escape_string($_POST['group']);
		_dbupdate("UPDATE  `q2stats`.`users` SET  `group` =  '".$group."' WHERE  `users`.`googleusername` = '".$_SESSION['googleusername']."';");
		header('Location: http://' . DOMAIN .'/manage');
	} else {
		include ('../Page-Logic/404.php');
		
	}
?>