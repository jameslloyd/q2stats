{include file='html/html-header.tpl'} 
<div style='height:200px;text-align:right;' class='span-16'>
</div>

<div style='text-align:right;' class='span-8 last'>
<h2>{if $playerinfo.0.playername neq ''}{$playerinfo.0.playername}{else}{$playername}{/if}</h2><br>Last Seen {$lastplayed}
	<fieldset>
		<center>
			{if $playerinfo.0.avatar neq ''}
			<img src="/Avatars/{$playerinfo.0.id}/{$playerinfo.0.avatar}" width="125">
			{else}	
				{if $playerinfo.0.email neq ''}
				<img src="{gravatar email="`$playerinfo.0.email`" size="125"}">
				{else}
				<img src="/images/Quake-II-256.png" width="100">
				{/if}
			{/if}
		</center>
	</fieldset>
</div>
<div class='span-24'>
<table>
	<thead>
		<tr>
			<th class="tabletitle" colspan='9'>Summary</th>
		</tr>
		<tr>
			<th></th>
			<th>Server</th>
			<th>Kills</th>
			<th>Deaths</th>
			<th>K2D</th>
			<th>Efficiency</th>
			<th>Suicides</th>
			<th>Longest Kill Streak</th>
			<th>Longest Desth Streak</th>
		</tr>
	</thead>
	<tbody>
	<tr>
		<td></td>
		<td class='playername'>Global Totals</td>
		<td>{$playerdata.0.kills}</td>
		<td>{$playerdata.0.deaths}</td>
		<td>{$playerdata.0.K2D}</td>
		<td>{$playerdata.0.eff}</td>
		<td>{$playerdata.0.suicides}</td>
		<td>{$playerdata.0.killstreak}</td>
		<td>{$playerdata.0.deathstreak}</td>
	</tr>
	{foreach from=$serverdata key=key item=item}
	<tr {if $key is even} class='even'{/if}>	
		<td>{if $item.live.s.name neq ''}<img src="{$html.wwwroot}images/icon_online.gif">{else}<img src="{$html.wwwroot}images/icon_no_response.gif">{/if}</td>
		<td class='playername'>{if $item.live.s.name neq ''}<a class="tTip" title='<b>Players</b>: {$item.live.s.players}<br><b>Map</b>: {$item.live.s.map}' href='http://{$html.domainname}/Server/{$item.server}' title='Stats for server {$item.live.s.name}'>{$item.live.s.name}</a>{else}<a href='http://{$html.domainname}/Server/{$item.server}' title='Stats for server {$item.server}'>{$item.server}</a>{/if}</td>
		<td>{$item.kills}</td>
		<td>{$item.deaths}</td>
		<td>{$item.K2D}</td>
		<td>{$item.eff}</td>
		<td>{$item.suicides}</td>
		<td>{$item.killstreak}</td>
		<td>{$item.deathstreak}</td>
	</tr>
		
	{/foreach}
	<tbody>
</table>
</div>
<div class='span-8'>
<table>
	<thead>
		<tr>
			<th class="tabletitle" colspan='2'>Killed</th>
		</tr>
		<tr>
			<th>Player</th>
			<th>Kills</th>
		</tr>
	</thead>
	<tbody>
		
		{foreach from=$killsperplayer key=key item=item}
		<tr {if $key is odd}class='even'{/if}>
			<td class='playername'><a href="/Player/{$item.target}">{$item.target}</a></td>
			<td>{$item.kills}</td>
		</tr>
		{/foreach}
	
	</tbody>
</table>
</div>
<div class='span-8'>
<table>
	<thead>
		<tr>
			<th class="tabletitle" colspan='2'>Killed By</th>
		</tr>
		<tr>
			<th>Player</th>
			<th>Kills</th>
		</tr>
	</thead>
	<tbody>
		
		{foreach from=$deathsperplayer key=key item=item}
		<tr {if $key is odd}class='even'{/if}>
			<td class='playername'><a href="/Player/{$item.who}">{$item.who}</a></td>
			<td>{$item.kills}</td>
		</tr>
		{/foreach}
	
	</tbody>
</table>
</div>
<div class='span-8 last'>
<table>
	<thead>
		<tr>
			<th colspan='3' class='tabletitle'>Weapons</th>
		</tr>
		<tr>
			<th>Weapons</th>
			<th>Kills</th>
			<th>Rank</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td class='playername'>Blaster</td>
			<td>{$playerdata.0.blaster}</td>
			<td>{if $playerdata.0.blaster gt 0}{$weaponranks.blaster.0.rank}{else}<a href='#' class="tTip" title='Not Ranked'>N/A</a>{/if}</td>
		</tr>
		<tr class='even'>
			<td class='playername'>Shotgun</td>
			<td>{$playerdata.0.shotgun}</td>
			<td>{if $playerdata.0.shotgun gt 0}{$weaponranks.shotgun.0.rank}{else}<a href='#' class="tTip" title='Not Ranked'>N/A</a>{/if}</td>
		</tr>
		<tr>
			<td class='playername'>Super Shotgun</td>
			<td>{$playerdata.0.supershotgun}</td>
			<td>{if $playerdata.0.supershotgun gt 0}{$weaponranks.supershotgun.0.rank}{else}<a href='#' class="tTip" title='Not Ranked'>N/A</a>{/if}</td>
		</tr>
		<tr class='even'>
			<td class='playername'>Machine Gun</td>
			<td>{$playerdata.0.machinegun}</td>
			<td>{if $playerdata.0.machinegun gt 0}{$weaponranks.machinegun.0.rank}{else}<a href='#' class="tTip" title='Not Ranked'>N/A</a>{/if}</td>
		</tr>
		<tr>
			<td class='playername'>Chain Gun</td>
			<td>{$playerdata.0.chaingun}</td>
			<td>{if $playerdata.0.chaingun gt 0}{$weaponranks.chaingun.0.rank}{else}<a href='#' class="tTip" title='Not Ranked'>N/A</a>{/if}</td>
		</tr>
		<tr class='even'>
			<td class='playername'>Grenade Launcher</td>
			<td>{$playerdata.0.grenadelauncher}</td>
			<td>{if $playerdata.0.grenadelauncher gt 0}{$weaponranks.grenadelauncher.0.rank}{else}<a href='#' class="tTip" title='Not Ranked'>N/A</a>{/if}</td>
		</tr>
		<tr>
			<td class='playername'>Rocket Launcher</td>
			<td>{$playerdata.0.rocketlauncher}</td>
			<td>{if $playerdata.0.rocketlauncher gt 0}{$weaponranks.rocketlauncher.0.rank}{else}<a href='#' class="tTip" title='Not Ranked'>N/A</a>{/if}</td>
		</tr>
		<tr class='even'>
			<td class='playername'>BFG10k</td>
			<td>{$playerdata.0.bfg10k}</td>
			<td>{if $playerdata.0.bfg10k gt 0}{$weaponranks.bfg10k.0.rank}{else}<a href='#' class="tTip" title='Not Ranked'>N/A</a>{/if}</td>
		</tr>
		<tr>
			<td class='playername'>Rail Gun</td>
			<td>{$playerdata.0.railgun}</td>
			<td>{if $playerdata.0.railgun gt 0}{$weaponranks.railgun.0.rank}{else}<a href='#' class="tTip" title='Not Ranked'>N/A</a>{/if}</td>
		</tr>
		<tr class='even'>
			<td class='playername'>Hyper Blaster</td>
			<td>{$playerdata.0.hyperblaster}</td>
			<td>{if $playerdata.0.hyperblaster gt 0}{$weaponranks.hyperblaster.0.rank}{else}<a href='#' class="tTip" title='Not Ranked'>N/A</a>{/if}</td>
		</tr>
		<tr>
			<td class='playername'>Hand Grenade</td>
			<td>{$playerdata.0.handgrenade}</td>
			<td>{if $playerdata.0.handgrenade gt 0}{$weaponranks.handgrenade.0.rank}{else}<a href='#' class="tTip" title='Not Ranked'>N/A</a>{/if}</td>
		</tr>
		<tr class='even'>
			<td class='playername'>Tele Frag</td>
			<td>{$playerdata.0.telefrag}</td>
			<td>{if $playerdata.0.telefrag gt 0}{$weaponranks.telefrag.0.rank}{else}<a href='#' class="tTip" title='Not Ranked'>N/A</a>{/if}</td>
		</tr>
		<tr>
			<td class='playername'>Grappling Hook</td>
			<td>{$playerdata.0.grapplinghook}</td>
			<td>{if $playerdata.0.grapplinghook gt 0}{$weaponranks.grapplinghook.0.rank}{else}<a href='#' class="tTip" title='Not Ranked'>N/A</a>{/if}</td>
		</tr>
	</tbody>
</table>
	
</div>

{include file='html/html-footer.tpl'} 