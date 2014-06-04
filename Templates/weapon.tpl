{include file='html/html-header.tpl'} 
<div class="span-12">
<h3>Kills with {$weaponname}</h3>
<table>
	<thead>
		<tr>
			<th>Weapon</th>
			<th>Kills</th>
		</tr>
	</thead>
	<tbody>
		<tr>
		{foreach from=$killwith key=key item=item}
		<tr>
			<th><a href="{$html.wwwroot}player/{$item.who}" title="global stats for the player {$item.who}">{$item.who}</th></a>
			<td>{$item.kills}</td>
		</tr>
		{/foreach}
		</tr>
	</tbody>
	<tfoot>
	<tr>
		<th>Weapon</th>
		<th>Kills</th>
	</tr>
	</tfoot>
</table>
</div>
<div class="span-12 last">
<h3>Killed by {$html.path.0}</h3>
<table>
	<thead>
		<tr>
			<th>Weapon</th>
			<th>Kills</th>
		</tr>
	</thead>
	<tbody>
		<tr>
		{foreach from=$killedby key=key item=item}
		<tr>
			<th><a href="{$html.wwwroot}player/{$item.target}" title="global stats for the player {$item.target}">{$item.target}</th></a>
			<td>{$item.kills}</td>
		</tr>
		{/foreach}
		</tr>
	</tbody>
	<tfoot>
	<tr>
		<th>Weapon</th>
		<th>Kills</th>
	</tr>
	</tfoot>
</table>
</div>
{include file='html/html-footer.tpl'} 
