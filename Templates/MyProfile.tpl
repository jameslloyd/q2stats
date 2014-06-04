{include file='html/html-header.tpl'} 
<div style='height:200px;text-align:right;' class='span-16'>
</div>
<div style='text-align:right;' class='span-8 last'>
<h2>My Profile</h2>
<fieldset>
	<legend>My Avatar</Legend>
	<center>
{if $html.userdbdata.avatar neq ''}
<img src="/Avatars/{$html.userdbdata.id}/{$html.userdbdata.avatar}" width="125">
{else}	
<img src="{gravatar email="`$html.userdbdata.email`" size="125"}">
{/if}
	</center>
</fieldset>
</div>
<div class="span-12 claimplayername">
<fieldset>
	<legend>Claim Your Player Name</legend>
	{if $html.get.claim eq 'fail'}
	<div class="error">
	That Playername {$html.get.playername} is already claimed.
	</div>
	{/if}
	{if $html.get.claim eq 'success'}
	<div class="success">
	That Playername {$html.get.playername} has been successfully claimed.
	</div>
	{/if}	
<p>Claim your playername this will attach your google account to your playername to allow you to use a gravatar</p>

<form method="post" action="{$html.wwwroot}Form-Logic/ClaimPlayerName.php">
<input type="text" name='playername' value="{$html.userdbdata.playername}"><input name='claim' type="submit" value="Claim" />

</form>

</fieldset>
<fieldset>
	<legend>Avatar Upload</legend>
	<form action="{$html.wwwroot}Form-Logic/avatarupload.php" method="post"
	enctype="multipart/form-data">
	<label for="file">Filename:</label>
	<input type="file" name="file" id="file" /> 
	<br />
	<input type="submit" name="submit" value="Submit" />
	</form>

</fieldset>
</div
<div class='span-12 last'>
<fieldset>
	<legend>About the Avatar</legend>
	
<p><img align='right' style="padding:3px" src="{$html.wwwroot}images/gravatar.png">The default avatars used by q2stats.com are grabbed from <a href="http://gravatar.com">gravatar.com</a>.  Gravatar allows to one place to upload your avatars, the system was built and is maintained by Automatic the people behind Wordpress.  It works by assigning an avatar to your email address.</p>
<p>To be able to use a gravatar on q2stats.com create a gravatar account and assign an avatar to your email address {$html.userdbdata.email}</p>
<small>
<p>Please note: q2stats.com will never:
	<ul>
		<li>Email you unless you turn on a feature to recieve email</li>
		<li>Give a thirdparty your emailaddress</li>
		<li>Place your email address only any crawlable html page</li>
	<ul>
Q2Stats will not behave in a facebook way!
</p>
</small>


</div>



{include file='html/html-footer.tpl'} 