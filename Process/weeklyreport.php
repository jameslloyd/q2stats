<pre>
<?php 
require_once('../config.php');
/*
$earliest = _dbquery("SELECT min(timestamp) as min FROM log");
$monday = strtotime("Last Monday",$earliest[0]['min']);
$endoflastweek = strtotime("Last Monday");
$c=0;
for ($i = $monday; ; $i = $i + 604800) 
	{
	    if ($i > $endoflastweek) { break; }		
		$weeks[$c]=date ("l dS F Y",$i);
		$c++;
	}
array_reverse($weeks);
print_r(array_reverse($weeks));
*/

$end= strtotime("Last Monday");
$start = $end - 604800;
echo $end .' '.$start.'<br>';
print_r(_time_stats($start, $end));

?>
</pre>