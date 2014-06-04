{include file='html/html-header.tpl'} 
<div class="span-24">
<h2>{$playername}</h2>
Stats for the <a href="http://{$html.group}.{$html.domainname}">{$html.group}</a> servers

<table>
<thead>
	<tr>
		<th>Server Name</th>
		<th>Server Address</th>
		<th>Kills</th>
		<th>Deaths</th>
		<th>Suicides</th>
		<th>Efficiency</th>
		<th>K:D Ratio</th>
	</tr>
</thead>
<tbody>
{foreach from=$player key=key item=item}
	<tr>
		<td>{$item.name.0.servername}</td>
		<td>{$key}</td>
		<td>{$item.kills}</td>
		<td>{$item.deaths}</td>
		<td>{$item.suicides}</td>
		<td>{$item.eff}</td>
		<td>{$item.k2d}</td>
	</tr>
{/foreach}
</tbody>
<tfoot>
<tr>
	<th>Server Name</th>
	<th>Server Address</th>
	<th>Kills</th>
	<th>Deaths</th>
	<th>Suicides</th>
	<th>Efficiency</th>
	<th>K:D Ratio</th>
</tr>
</tfoot>
</table>
</div>
<div class="span-8">
<table>
	<thead>
		<tr>
			<th>Weapon</th>
			<th>Kills</th>
		</tr>
	</thead>
	<tbody>
		<tr>
		{foreach from=$weapons key=key item=item}
		<tr>
			<th>{$key}</th><td>{$item}</td>
		</tr>
		{/foreach}
		</tr>
	</tbody>
	<tfoot>
	</tfoot>
</table>
</div>
{include file='html/html-footer.tpl'}