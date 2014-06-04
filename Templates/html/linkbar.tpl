

<div class="span-16 menu">
 <a href="http://{$html.domainname}{$html.wwwroot}">Home</a> | <a href="http://{$html.domainname}{$html.wwwroot}Global">Global Stats</a> <!--| <a href="http://{$html.domainname}{$html.wwwroot}Weekly">Weekly Report</a>--> | <a href="http://quake2lithium.com/">Quake2Lithium.com</a>
{if $html.session.loggedin eq true}
| <a href="{$html.wwwroot}MyProfile" alt="profile for {$html.session.fname} {$html.session.lname}">My Profile</a>
{if $html.userdbdata.level gte 2}| <a href="{$html.wwwroot}manage">Manage Q2 Servers</a>{/if}
{if $html.userdbdata.level gte 3} | <a href="{$html.wwwroot}Updates">Updates</a> |
<a href="http://{$html.domainname}{$html.wwwroot}Servers">Servers</a> | <a href="http://{$html.domainname}{$html.wwwroot}showlog">Show Logs</a>

{/if}

{else}
	
{/if}
</div>
<div class="span-8 last barright">
<a href="http://{$html.domainname}{$html.wwwroot}About">About</a> |
{if $html.session.loggedin eq true}

{if $html.userdbdata.avatar neq ''}
<img src="/Avatars/{$html.userdbdata.id}/{$html.userdbdata.avatar}" width="15">
{else}
<img src="{gravatar email="`$html.session.email`" size="15"}" alt="login with google">{/if} Welcome {if $html.userdbdata.playername neq ''}{$html.userdbdata.playername}{else}{$html.displayname}{/if} <a href="{$html.wwwroot}Login/logout.php">logout</a>
{else}
<img style="padding-right:3px;"src="{$html.wwwroot}images/google_favicon.png"><a href="http://{$html.domainname}{$html.wwwroot}Login/login.php"><b>Login</b> with google</a> 
{/if}
</div>
