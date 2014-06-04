<?php
require_once('../config.php');
//print_r($_SESSION);

if (isset($_POST) && $_SESSION['level'] >= 1 )
	{
	if (isset($_POST['id']))
		{
		_dbupdate("	UPDATE  `q2stats`.`servers` SET  `serverip` =  '".mysql_escape_string($_POST['serverip'])."', `serverport` =  '".mysql_escape_string($_POST['serverport'])."' WHERE  `servers`.`id` =7;");
		} else {
		//print_r($_POST);
		$sql = "
				INSERT INTO  `q2stats`.`servers` (
				`id` ,
				`serverip` ,
				`serverport` ,
				`owner`
				)
				VALUES (
				NULL ,  
				'".mysql_escape_string($_POST['serverip'])."',  
				'".mysql_escape_string($_POST['serverport'])."',  
				'".$_SESSION['googleusername']."'
				);
				";
		_dbupdate($sql);		
		
		}
	header('Location: http://' . DOMAIN .'/manage');	

	} else {
		include ('Page-Logic/404.php');
		
	}

?>