<?php
include('../../config.php');  

_dbconnect();
print "<chart>\n";
print "
<chart_type>3d column</chart_type>
<axis_category shadow='low' size='12' color='dddddd' alpha='75' orientation='horizontal' />
<axis_ticks value_ticks='true' category_ticks='true' minor_color='777777' />
<axis_value alpha='50' steps='5' mode='stretch' color='dddddd' />
<axis_category alpha='50' size='5'  skip='0' orientation='horizontal'  />
<context_menu about='0' print='0'  full_screen='1' save_as_bmp='1'  save_as_jpeg='1'  save_as_png='1' />
<chart_transition type='slide_down' delay='1' duration='1' order='series'   />";
// that's the chart options
 
print "<chart_data>\n"; 
print "<row>\n"; 
print "<null/>\n";

//$player='KungFuMonkay';

$player = $_GET['player'];

       $result = mysql_query(" 
SELECT YEAR( FROM_UNIXTIME( timestamp ) ) AS year, MONTH( FROM_UNIXTIME( timestamp ) ) AS
MONTH , MONTHNAME( FROM_UNIXTIME( timestamp ) ) AS monthname, count( timestamp ) AS count
FROM log
WHERE ACTION = 'kill'
AND who = '".$player."'
GROUP BY year,
MONTH ORDER BY year,
MONTH ASC
LIMIT 0 , 30
	;") or die(mysql_error());
	

       while ($row = mysql_fetch_array($result)) {
            echo "<string>".substr($row['monthname'],0,3)."-".$row['year']."</string>\n";
       }     
print "</row>\n";
 

// Kills
print "<row>\n";
print "<string>Kills</string>\n";   
       $kresult = mysql_query(" 
SELECT YEAR( FROM_UNIXTIME( timestamp ) ) AS year, MONTH( FROM_UNIXTIME( timestamp ) ) AS
MONTH , MONTHNAME( FROM_UNIXTIME( timestamp ) ) AS monthname, count( timestamp ) AS count
FROM log
WHERE ACTION = 'kill'
AND who = '".$player."'
GROUP BY year,
MONTH ORDER BY year,
MONTH ASC
LIMIT 0 , 30
	;") or die(mysql_error());
       while ($row = mysql_fetch_array($kresult)) {
            echo "<number>".$row['count']."</number>\n";
       }    
print "</row>\n";


// DEATHs
print "<row>\n";
print "<string>Deaths</string>\n";   
       $dresult = mysql_query(" 
SELECT YEAR( FROM_UNIXTIME( timestamp ) ) AS year, MONTH( FROM_UNIXTIME( timestamp ) ) AS
MONTH , MONTHNAME( FROM_UNIXTIME( timestamp ) ) AS monthname, count( timestamp ) AS count
FROM log
WHERE ACTION = 'kill'
AND target = '".$player."'
GROUP BY year,
MONTH ORDER BY year,
MONTH ASC
LIMIT 0 , 30
	;") or die(mysql_error());
       while ($row = mysql_fetch_array($dresult)) {
            echo "<number>".$row['count']."</number>\n";
       }    
print "</row>\n";


/*

// this will eventually be suicides
print "<row>\n";
print "<string>Suicides</string>\n";   
       $result = mysql_query(" 
SELECT YEAR( FROM_UNIXTIME( timestamp ) ) AS year, MONTH( FROM_UNIXTIME( timestamp ) ) AS
MONTH , MONTHNAME( FROM_UNIXTIME( timestamp ) ) AS monthname, count( timestamp ) AS count
FROM log
WHERE ACTION = 'Suicide'
AND target = '".$player."'
GROUP BY year,
MONTH ORDER BY year,
MONTH ASC
LIMIT 0 , 30
	;") or die(mysql_error());
print "</row>\n";
*/

//finish the XML output
print "</chart_data>\n";
print "</chart>\n";
?>
