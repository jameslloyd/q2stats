<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
 
<head> 
<meta content="yes" name="apple-mobile-web-app-capable" /> 
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" /> 
<meta content="minimum-scale=1.0, width=device-width, maximum-scale=0.6667, user-scalable=no" name="viewport" /> 
<meta name="apple-mobile-web-app-status-bar-style" content="black"/>
<link href="{$html.wwwroot}Thirdparty/iWebKit5.04/css/style.css" rel="stylesheet" media="screen" type="text/css" /> 
<script src="{$html.wwwroot}Thirdparty/iWebKit5.04/javascript/functions.js" type="text/javascript"></script> 
<title>Q2Stats</title> 
<meta content="keyword1,keyword2,keyword3" name="keywords" /> 
<meta content="Description of your page" name="description" /> 
<link href="{$html.wwwroot}images/startup.png" rel="apple-touch-startup-image" />
<link rel="apple-touch-icon" href="{$html.wwwroot}images/iphonefavicon.png"/>
</head> 
 
<body class="list"> 
 
<div id="topbar" class="transparent"> 
	<div id="title">Q2Stats</div>
	
</div> 
<div id="content"> 
<span class="graytitle">Welcome to Q2Stats</span> 
<ul>
	<li class="title">Top 10 Players by Kills</li>
	{foreach from=$top10 item=item}
		<li>

<a href="{$html.wwwroot}Player/{$item.player}"> 
		<span class="image" style="background-image: url('http://{$html.domainname}/images/iphonefavicon.png')"> 
		</span>
		<!-- <span class="comment">Games</span> -->
		<span class="name">{$item.player}</span>
		<!-- <span class="stars4"></span> -->
		<span class="comment">Kills {$item.kills} | Deaths {$item.deaths} | Suicides {$item.suicides} </span><span class="arrow"></span><!-- <span class="price">$6.99</span> --></a>
		</li>
	{/foreach}
</ul>
</div> 
<div id="footer"> 
	<!-- Support iWebKit by sending us traffic; please keep this footer on your page, consider it a thank you for our work :-) --> 
	<a class="noeffect" href="http://Q2Stats.com">Powered by Q2Stats</a></div> 
 
</body> 
 
</html>