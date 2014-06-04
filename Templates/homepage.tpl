{include file='html/html-header.tpl'}
<div style='height:200px;text-align:right;' class='span-24'>
<h2>Report week starting {$start}</h2>
<h6>{$totalkills.0.kills} Kills Tracked</h6>
</div>
<div class="span-12">
{if $week.previous.display neq ''}
<a class='weekbutton' href="http://{$html.domainname}/Homepage/{$week.previous.display|replace:' ':'-'}"> < Previous Week</a> 
{/if}
</div>
<div class="span-12 last">
{if $week.next.display neq ''}
<div style="text-align:right;">
<a class='weekbutton' href="http://{$html.domainname}/Homepage/{$week.next.display|replace:' ':'-'}">Next Week > </a>
</div>
{else}
&nbsp;
{/if}
</div>
<div class='span-10'>
<table>
<thead>
	<tr>
		<th class="tabletitle" colspan="3">Top Ranked Players</th>
	</tr>
</thead>
<tbody>
	{assign var=i value='1'}
	{foreach from=$skill item=item}
		{if $i le '3'}
		{if $i is even}<tr class='even'>{else}<tr>{/if}
		 <td>
		{* is the avatar been uploaded? *}
		{if $item.avatar neq ''}
			<img src="{$item.avatar}" width='48'> 
		{else}
		 {* avatar not set if an email address is set use gravatar *}		
			{if $item.email neq ''}
				<img src="{gravatar email="`$item.email`" size="48"}">
			{else}
			<img src="/images/Quake-II-48.png" width="48">
			{/if}
		{/if}
		</td>
		 <td><h{$i}>{$i}<sup>{if $i eq '1'}st{elseif $i eq '2'}nd{elseif $i eq '3'}rd{/if}</sup> {$item.who}</h{$i}></td>
		</tr>
		{/if}
		{assign var=i value=$i + 1}
	{/foreach}
</tbody>
</table>
</div>
<div class='span-7'>
<table id="skill">
<thead>
	<tr>	
		<th class="tabletitle" colspan="4">Players By Skill</th>
	</tr>
	<tr>
		<th>Rank</th>
		<th></th>
		<th>Player</th>
		<th>Skill <a class="tTip" href="#" title="Skill is Calulated as<br> ( [Kills] / ( 1 + [Deaths] + [Suicides] )) * ( 1 + ( [Rounds Won] / [Rounds Played] ))">?</a></th>
	</tr>
</thead>
<tbody>
{foreach from=$skill key=key item=item}
<tr><td>{counter}</td>
<td>
{* is the avatar been uploaded? *}
{if $item.avatar neq ''}
	<img src="{$item.avatar}" width='15'> 
{else}
 {* avatar not set if an email address is set use gravatar *}		
	{if $item.email neq ''}
		<img src="{gravatar email="`$item.email`" size="15"}">
	{else}
	<img src="/images/Quake-II-15.png" width="15">
	{/if}
{/if}
</td>
<td class='playername'>
<a href='http://{$html.domainname}/Player/{$item.who}' title='global stats for {$item.who}'>{$item.who}</a></td>
<td>{$item.score}</td></tr>
{/foreach}
</tbody>
</table>
</div>
<div class="span-7 last">
<table>
	<thead>
		<tr>
			<th class="tabletitle" colspan='4'>Kills by Server</th>
		</tr>
		<tr>
			<th></th>
			<th>Server</th>
			<th>Rounds</th>
			<th>Kills</th>
		</tr>
	</thead>
	<tbody>
	{foreach from=$servers key=key item=item}
		{if $key is odd}<tr class='even'>{else}<tr>{/if}
			<td>{if $item.live.s.name neq ''}<img src="{$html.wwwroot}images/icon_online.gif">{else}<img src="{$html.wwwroot}images/icon_no_response.gif">{/if}</td>
			<td class='playername'>{if $item.live.s.name neq ''}<a href='http://{$html.domainname}/Server/{$item.server}' class="tTip" title='<b>Players</b>: {$item.live.s.players}<br><b>Map</b>: {$item.live.s.map}'>{$item.live.s.name}</a>{else}<a href='http://{$html.domainname}/Server/{$item.server}' title='Stats for server {$item.server}'>{$item.server}</a>{/if}</td>
			<td>{$item.rounds}</td>
			<td>{$item.kills}</td>
		</tr>
	{/foreach}
	<tbody>
</table>
</div>
<div class='span-24'>
<div id="tablessummary" class="tabs"> 
  <ul>
	<li><a href='#playersummary'>Player Summary</a></li>
	<li><a href='#weaponssummary'>Weapons Summary</a></li>
  </ul>

</div>

<div id="playersummary"><br>
	<table id="summary">
	<thead>
		<tr>
			<th class="tabletitle" colspan='11'>Player Summary</th>
		</tr>
		<tr>
			<th></th>
			<th style="width:15px;">Player</th>
			<th>Kills <a class="tTip" href="#" title="Total Number of Kills">?</a></th>
			<th>Deaths <a class="tTip" href="#" title="Total Number of Deaths">?</a></th>
			<th>K:D <a class="tTip" href="#" title="Kill to Death Ratio">?</a></th>
			<th>Eff <a class="tTip" href="#" title="Efficiency">?</a></th>
			<th>Suicides <a class="tTip" href="#" title="Total Number of Suicides">?</a></th>
			<th>Killstreak <a class="tTip" href="#" title="Longest Kill Streak in one round">?</a></th>
			<th>Deathstreak <a class="tTip" href="#" title="Longest Death Streak in one round">?</a></th>
			<th>Played <a class="tTip" href="#" title="Total number of rounds played">?</a></th>
			<th>Won <a class="tTip" href="#" title="Number of rounds won">?</a></th>
		</tr>
	</thead>
	<tbody>
	{foreach from=$data key=key item=item}
	<tr>
		<td>
		{* is the avatar been uploaded? *}
		{if $item.avatar neq ''}
			<img src="{$item.avatar}" width='15'> 
		{else}
		 {* avatar not set if an email address is set use gravatar *}		
			{if $item.email neq ''}
				<img src="{gravatar email="`$item.email`" size="15"}">
			{else}
			<img src="/images/Quake-II-15.png" width="15">
			{/if}
		{/if}
		</td>
		<td class='playername'>
		<a href='http://{$html.domainname}/Player/{$item.who}' title='global stats for {$item.who}'>{$item.who}</a></td>
		<td>{$item.kills}</td>
		<td>{$item.deaths}</td>
		<td>{$item.K2D}</td>
		<td>{$item.eff}</td>
		<td>{$item.suicides}</td>
		<td>{$item.killstreak}</td>
		<td>{$item.deathstreak}</td>
		<td>{$item.rnds}</th>
		<td>{$item.roundwins}</td>
	</tr>
	{/foreach}
	</tbody>
	</table>
</div>

<div id="weaponssummary"><br>
	<table id="wpnsummary">
	<thead>
		<tr>
			<th class="tabletitle" colspan='15'>Weapons Summary</th>
		</tr>
		<tr>
			<th></th>
			<th>Player</th>
			<th>Blaster</th>
			<th>Shotgun</th>
			<th>Super Shotgun</th>
			<th>Machinegun</th>
			<th>Chaingun</th>
			<th>Grenade Launcher</th>
			<th>Rocket Launcher</th>
			<th>Rail Gun</th>
			<th>Hyperblaster</th>			
			<th>BFG10k</th>
			<th>Hand Grenade</th>
			<th>Telefrag</th>
			<th>Grappling Hook</th>
		</tr>
	</thead>
	<tbody>
	{foreach from=$data key=key item=item}
	<tr>
	<td>
	{* is the avatar been uploaded? *}
	{if $item.avatar neq ''}
		<img src="{$item.avatar}" width='15'> 
	{else}
	 {* avatar not set if an email address is set use gravatar *}		
		{if $item.email neq ''}
			<img src="{gravatar email="`$item.email`" size="15"}">
		{else}
		<img src="/images/Quake-II-15.png" width="15">
		{/if}
	{/if}
	</td>
		<td class='playername'><a href='http://{$html.domainname}/Player/{$item.who}' title='global stats for {$item.who}'>{$item.who}</a></td>
		<td>{$item.blaster}</td>
		<td>{$item.shotgun}</td>
		<td>{$item.supershotgun}</td>
		<td>{$item.machinegun}</td>
		<td>{$item.chaingun}</td>
		<td>{$item.grenadelauncher}</th>
		<td>{$item.rocketlauncher}</td>
		<td>{$item.railgun}</td>
		<td>{$item.hyperblaster}</td>
		<td>{$item.bfg10k}</td>
		<td>{$item.handgrenade}</td>
		<td>{$item.telefrag}</td>
		<td>{$item.grapplinghook}</td>
	</tr>
	{/foreach}
	</tbody>
	</table>
</div>
</div>
<div class="span-12">
{if $week.previous.display neq ''}
<a href="http://{$html.domainname}/Homepage/{$week.previous.display|replace:' ':'-'}">Previous Week</a> 
{/if}
</div>
<div class="span-12 last">

{if $week.next.display neq ''}
<div style="text-align:right;">
<a href="http://{$html.domainname}/Homepage/{$week.next.display|replace:' ':'-'}">Next Week</a>
</div>
{/if}
</div>
{literal}
<script type="text/javascript" charset="utf-8"> 
		$(document).ready(function() {
			$('#skill').dataTable(
				{
					"bFilter": false	,
					"aaSorting":[[0,'asc']],
					"bLengthChange": false,
					"bInfo": false
				}
				);
		} );
	</script>
<script type="text/javascript" charset="utf-8"> 
		$(document).ready(function() {
			$('#summary').dataTable(
				{
					"bFilter": false	,
					"aaSorting":[[2,'desc']],
					
				}
				);
		} );
	</script>
	<script type="text/javascript" charset="utf-8"> 
			$(document).ready(function() {
				$('#wpnsummary').dataTable(
					{
						"bFilter": false	,
						"aaSorting":[[2,'desc']],

					}
					);
			} );
		</script>
{/literal}
<script type="text/javascript"> 
  $("#tablessummary ul").idTabs(); 
</script>
<div class='span-24'>
this page processed all the data in real time in {$timer} Seconds!!!
</div>
{include file='html/html-footer.tpl'}