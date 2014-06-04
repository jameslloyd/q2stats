
<pre><?php 
require_once('../config.php');
if (isset($_SESSION['googleusername']))
	{
		if (!file_exists( INSTALL . 'Logs/'. $_SESSION['googleusername']))
			{
				mkdir(INSTALL . 'Logs/' . $_SESSION['googleusername']);
			}
			$target_path = INSTALL . "Logs/" . $_SESSION['googleusername'] . '/';
			$target_path = $target_path . basename( $_FILES['uploadedfile']['name']);
			echo $target_path.'<br>';
			print_r($_POST);
			print_r($_FILES);
			if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)) {
			    echo "The file ".  basename( $_FILES['uploadedfile']['name']). 
			    " has been uploaded";
			$filename = $target_path;
			$serveripport = $_POST['serverip-port'];
			include ('../readlog.php');
			} else{
			    echo "There was an error uploading the file, please try again!";
			}

	}
?></pre>