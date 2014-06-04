{include file='html/html-header.tpl'} 
<div class="span-24">
<h2>Log Imports</h2>
<table class="sortabletable">
<thead>
	<tr>
		<th>id</th>
		<th>timestamp</th>
		<th>No. of lines</th>
		<th>No. of actions</th>
		<th>Process time in Seconds</th>
		<th>actions inserted</th>
		<th>actions skipped</th>
		<th>server</th>
	</tr>
</thead>
<tbody>
{foreach from=$updates key=key item=item}
	<tr>
		<td>{$item.id}</td>
		<td>{$item.timestamp|date_format:"%A, %B %e, %Y	: %H:%M"}</td>
		<td>{$item.lines}</td>
		<td>{$item.actions}</td>
		<td>{$item.processtime}</td>
		<td>{$item.inserted}</td>
		<td>{$item.skipped}</td>
		<td>{$item.server}</td>
	</tr>
{/foreach}
</tbody>
<tfoot>
	<tr>
		<th>id</th>
		<th>timestamp</th>
		<th>No. of lines</th>
		<th>No. of actions</th>
		<th>Process time in Seconds</th>
		<th>lines inserted</th>
		<th>lined skipped</th>
		<th>server</th>
	</tr>
</tfoot>
</table>
</div>
{include file='html/html-footer.tpl'} 
