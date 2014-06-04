<?php

function _list_dir($dir,$filetype='mp3'){ 

	if ($handle = opendir($dir)) {
	    while (false !== ($file = readdir($handle))) {
	        if ($file != "." && $file != ".." && strpos($file,'.') != 0) {
	        if (is_dir($dir.'/'.$file))
	    		{
				$output[$file] = _list_dir($dir.'/'.$file);
				} elseif (is_file($dir.'/'.$file)) {

				if (isset($filetype) && substr(strrchr($file, '.'), 1) == $filetype)
					{ 
						$output[$file]['filename'] = $file;	
						$output[$file]['extension']	= substr(strrchr($file, '.'), 1);
						if (is_writable($dir.'/'.$file))
							{
								$output[$file]['writable'] = 'true';
							}
					
					}

				}
	
				
	        }
	    }
	    closedir($handle);
	}
	if (!isset($output)) 
		{ 
			$output = false;
		}
	return($output);
}
function _get_file_properties($file)
	{
		
		
	}

?>