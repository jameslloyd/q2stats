<?php
require_once('../config.php');
if ((($_FILES["file"]["type"] == "image/gif")
|| ($_FILES["file"]["type"] == "image/jpeg")
|| ($_FILES["file"]["type"] == "image/pjpeg"))
&& ($_FILES["file"]["size"] < 20000))
  {
  if ($_FILES["file"]["error"] > 0)
    {
		header( 'location: http://'.DOMAIN .'/MyProfile?avatar=fail&error='.$_FILES["file"]["error"]);    
    }
  else
    {
   // echo "Upload: " . $_FILES["file"]["name"] . "<br />";
   // echo "Type: " . $_FILES["file"]["type"] . "<br />";
   // echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
   // echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br />";
	
	
	if (!file_exists(dirname(__FILE__) . "/../Avatars/" . $_SESSION['userid']))
		{
			mkdir(dirname(__FILE__) . "/../Avatars/" . $_SESSION['userid'], 0777);
		}
		
      move_uploaded_file($_FILES["file"]["tmp_name"],
      dirname(__FILE__) . "/../Avatars/" . $_SESSION['userid'] .'/'. $_FILES["file"]["name"]);
   //   echo "Stored in: " . dirname(__FILE__) . "/../Avatars/" . str_replace('@','\@',$_SESSION['email']) .'/'. $_FILES["file"]["name"];
//print_r($_SESSION);
		_dbupdate("UPDATE  `q2stats`.`users` SET  `avatar` =  '".$_FILES["file"]["name"]."' WHERE  `users`.`email` ='".$_SESSION['userid']."';");
      header( 'location: http://'.DOMAIN .'/MyProfile?avatar=success&type='.$_FILES["file"]["type"]);    
    }
  }
else
  {
  	header( 'location: http://'.DOMAIN .'/MyProfile?avatar=fail&error=invalidfile');   
  }
?>