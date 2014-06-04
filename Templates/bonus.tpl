{include file='html/html-header.tpl'}
<div class="span-24">
<h2>Gun Bonus'</h2>
<table>
 <thead>
	<tr>
	<th>Weapon</th>
	<th>1st Place Bonus</th>
	<th>2nd Place Bonus</th>
	<th>3rd Place Bonus</th>
	</tr>
 </thead>
 <tbody>
{foreach from=$bonus.guns key=key item=item}
<tr>
  <th>{$key}</th>
  <td>{$item.1st}</td>
 <td>{$item.2nd}</td>
<td>{$item.3rd}</td>
</tr>


{/foreach}
</tbody>
</table>
</div>
{include file='html/html-footer.tpl'}

