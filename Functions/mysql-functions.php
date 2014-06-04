<?php

/*############ My SQL Functions  ###############*/

function  _dbconnect() 
        {
        global $database;
        $link = mysql_connect($database['dbhost'], $database['user'], $database['pass']);
        if (!$link) { die('Not connected : ' . mysql_error()); }
        $db_selected = mysql_select_db($database['dbname'], $link);
        if (!$db_selected) { die ('Can\'t use '.$database['dbname'].' : ' . mysql_error()); }        
        }

//_dbupdate executes a SQL statement, i.e for UPDATE, DROP etc statements.
function _dbupdate ($sql)
        {

        _dbconnect();
        $result = mysql_query($sql);
        if (!$result) {
            die("\n ".'<br><font color="red"><b>Invalid query:</b></font> ' . mysql_error().'<br>'.$sql);
                    }
	    return(mysql_insert_id());
        mysql_close();
        }

// _dbquery returns an array from a SELECT statement (OLD NON ZEND)    
function _isitindb ($sql)
        {
         // Connect to the database
         _dbconnect();
         $result = mysql_query($sql);
         $num_rows = mysql_num_rows($result);
         if ($num_rows > 0) {
            return true; } else {
            return false;
            }
        
        }

function _dbquery ($sql,$type=MYSQL_ASSOC,$print=false)  // type MYSQL_ASSOC , MYSQL_NUM , MYSQL_BOTH
        {
         global $_GET;  
        _dbconnect();
        $query = mysql_query($sql);
        $i=0;
        if ($print == true)
            {
             echo '<div class=debug>';
             echo '<h5>OUTPUT for '.$sql.'</h5>';   
            }
        while ($results = mysql_fetch_array($query,$type))
            {
            $output['themoviedb'][$i]=$results;
            $i++;
            }
        
        if ($print == true)
            {
            echo '<pre>';
            print_r($output['themoviedb']);
            echo '</pre>';
            }
        if ($print == true)
            {
             echo '</div>';   
            }        
        if (isset($output['themoviedb'])) { return $output['themoviedb']; } else { return false; }
        mysql_close();
        }
/*############ End of MYSQL Functions  ###############*/

?>
