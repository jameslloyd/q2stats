{include file='html/Group-header.tpl'} 
<div class='span-24'>
<table>
	<tr>
		<th>Status</th>
		<th>Stats Avaiable</th>
		<th>Name</th>
		<th>Address</th>
		<th>Map</th>
		<th>players</th>
	</tr>
	{foreach from=$servers key=key item=item}
	<tr>
	<td>
		{if $item.live.b.status eq '1'}
		<img src="{$html.wwwroot}images/icon_online.gif">
		{else}
		<img src="{$html.wwwroot}images/icon_no_response.gif">
		{/if}
	</td>
	<td>
	{if $item.stats eq 'true'}
	<img src="{$html.wwwroot}images/icon_online.gif"> <a href="http://{$item.group}.{$html.domainname}/{$item.serverip}:{$item.serverport}">Stats Available</a>
	{else}
	<img src="{$html.wwwroot}images/icon_no_response.gif"> No Stats :(
	{/if}	
	</td>	

	<td>{if $item.stats eq 'true'}<a href="http://{$item.group}.{$html.domainname}/{$item.serverip}:{$item.serverport}">{/if}{$item.servername}{if $item.stats eq 'true'}</a>{/if}</td>
	<td>{$item.serverip}:{$item.serverport}</td>
	<td>{$item.live.e.mapname}</td>
	<td>{$item.live.s.players}</td>
	</tr>
	{/foreach}
</table>

<table class="sortabletable">
<thead>
	<tr>
		<th>Player Name</th>
		<th>Kills</th>
		<th>Deaths</th>
		<th>Suicides</th>
		<th>K:D Ratio</th>
		<th>Kill Streak</th>
	</tr>
</thead>
<tbody>
{foreach from=$data key=key item=item}
	<tr>
		<td><a href="http://{$html.domainname}{$html.wwwroot}player/{$key}">{$key}</a></td>
		<td>{$item.kills}</td>
		<td>{$item.deaths}</td>
		<td>{$item.suicides}</td>
		<td>{$item.k2d}</td>
		<td>{$item.killstreak}</td>
	</tr>
{/foreach}
</tbody>
<tfoot>
<tr>
	<th>Player Name</th>
	<th>Kills</th>
	<th>Deaths</th>
	<th>Suicides</th>
	<th>K:D Ratio</th>
	<th>Kill Streak</th>
</tr>
</tfoot>
</table>
</div>
{literal}
<script type="text/javascript" charset="utf-8">
                $(document).ready(function() {
                        $('.sortabletable').dataTable(
                                {
                                        "bFilter": true,
                                        "aaSorting":[[1,'desc']],

                                }
                                );
                } );
        </script>
{/literal}

{include file='html/html-footer.tpl'} 
