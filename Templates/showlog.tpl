{include file='html/html-header.tpl'} 
<div class="span-24">
<h2>Show Action Log</h2>
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
<table class="sortabletable">
<thead>
	<tr>
		<th>id</th>
		<th>timestamp</th>
		<th>gamestart</th>
		<th>map</th>
		<th>action</th>
		<th>who</th>
		<th>target</th>
		<th>weapon</th>
		<th>server</th>
	</tr>
</thead>
<tbody>
{foreach from=$log key=key item=item}
<tr>
	<td>{$item.id}</td>
	<td>{$item.timestamp|date_format:"%D %H:%M:%S"}</td>
	<td>{$item.gamedate|date_format:"%D %H:%M:%S"}</td>
	<td>{$item.map}</td>
	<td>{$item.action}</td>
	<td>{$item.who}</td>
	<td>{$item.target}</td>
	<td>{$item.weapon}</td>
	<td>{$item.server}</td>
</tr>
{/foreach}
</tbody>
<tfoot>
	<tr>
		<th>id</th>
		<th>timestamp</th>
		<th>gamestart</th>
		<th>map</th>
		<th>action</th>
		<th>who</th>
		<th>target</th>
		<th>weapon</th>
		<th>server</th>
	</tr>
</tfoot>
</table>
</div>
{include file='html/html-footer.tpl'} 