{include file='html/html-header.tpl'} 

<form method="post" action="{$html.wwwroot}Form-Logic/Change-Group.php">
Your Group Name: <input type="text" name="group" value="{$userinfo.group}"> <input type="submit" value="Change Group Name" />
</form>

<table>

		<tr>
			<th>Server Name</th>
			<th>Server IP</th>
			<th>Server Port</th>
			<th>Update</th>
		</tr>

	<tbody>
	{foreach from=$servers key=key item=item}
		<form method="POST" ACTION="{$html.wwwroot}Form-Logic/add-server.php">
		<input type='hidden' name='id' value='{$item.id}'>
		<tr>
			<td>
			{if $item.live.b.status eq '1'}
			<img src="{$html.wwwroot}images/icon_online.gif" alt="server online">
			{else}
			<img src="{$html.wwwroot}images/icon_no_response.gif" alt="server offline">
			{/if}
			{$item.live.s.name}</td>
			<input type='hidden' name='id' value='{$item.id}'>
			<td><input type='text' name='serverip' value='{$item.serverip}'></td>
			<td><input type='text' name='serverport' value='{$item.serverport}'></td>
			<td><input name='update' type="submit" value="Update Server" /></td>
			</form>
			<td>
		</tr>
	{/foreach}
	<tr><td colspan='4'>Add new server<td></tr>
	<form method="POST" ACTION="{$html.wwwroot}Form-Logic/add-server.php"> 
	<tr>
		<td></td>
		<td><input type='text' name='serverip'></td>
		<td><input type='text' name='serverport'></td>
		<td><input name='add' type="submit" value="Add Server" /></td>
		<td></td>
	</tr>
	
	</form>
	<tbody>
</table>

{include file='html/html-footer.tpl'}