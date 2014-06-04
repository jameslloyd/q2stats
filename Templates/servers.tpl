{include file='html/html-header.tpl'} 
<table>
	<tr>
		<th>Group</th>
		<th>Stats Avaiable</th>
		<th>Status</th>
		<th>Name</th>
		<th>Address</th>
		<th>Map</th>
		<th>players</th>
	</tr>
	{foreach from=$servers key=key item=item}
	<tr>
	<td><a href="http://{$item.group}.{$html.domainname}">{$item.group}</a></td>
	<td>
	{if $item.stats eq 'true'}
	<img src="{$html.wwwroot}images/icon_online.gif"> <a href="http://{$item.group}.{$html.domainname}/{$item.serverip}:{$item.serverport}">Stats Available</a>
	{else}
	<img src="{$html.wwwroot}images/icon_no_response.gif"> No Stats :(
	{/if}	
	</td>
	<td>
		{if $item.live.b.status eq '1'}
		<img src="{$html.wwwroot}images/icon_online.gif">
		{else}
		<img src="{$html.wwwroot}images/icon_no_response.gif">
		{/if}
	</td>
	<td>{if $item.stats eq 'true'}<a href="http://{$item.group}.{$html.domainname}/{$item.serverip}:{$item.serverport}">{/if}{$item.servername}{if $item.stats eq 'true'}</a>{/if}</td>
	<td>{$item.serverip}:{$item.serverport}</td>
	<td>{$item.live.e.mapname}</td>
	<td>{$item.live.s.players}</td>
	</tr>
	{/foreach}
</table>

{include file='html/html-footer.tpl'} 