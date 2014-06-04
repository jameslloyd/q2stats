{include file='html/html-header.tpl'} 
<div class='span-24'>
<center>Q2stats is currently providing statistics on {$totalglobalkills.0.count} Frags over {$totalrounds.0.rounds} rounds since 15th August 2010</center>
<h2>Report week starting {$start}</h2>
	
<h3>Players Summary</h3>




<table class='summary'>
	<thead>
		<tr>
			<th>Player Name</th>
			<th>Skill</th>
			<th>Kills</th>
			<th>Deaths</th>
			<th>Suicides</th>
			<th>Kill<br>Streak</th>
			<th>Death<br>Streak</th>
			<th>Rounds<br>Played</th>
			<th>Rounds<br>Won</th>
			<th>K2D</th>
			<th>Eff</th>
		</tr>
	</thead>
	<tbody>
	{foreach from=$report.player key=key item=player}
	{if $player.kills.count gte '5' and $report.roundsplayed.$key gte '5'}
		<tr>
			<td class='playername'><a href="{$html.wwwroot}player/{$key}">{$key}</a></td>
			<td>{$player.skill}</td>
			<td>{$player.kills.count}</td>
			<td>{$player.deaths.count}</td>
			<td>{$player.suicides.count}</td>
			<td>{$player.killstreak.value}</td>
			<td>{$player.deathstreak.value}</td>
			<td>{$report.roundsplayed.$key}</td>
			<td>{$report.roundswon.$key}</td>
			<td>{$player.k2d.value}</td>
			<td>{$player.eff.value}%</td>
		</tr>
	{/if}
	{/foreach}
	</tbody>
	<tfoot>
		<tr>
		<th>Player Name</th>
		<th>Skill</th>
		<th>Kills</th>
		<th>Deaths</th>
		<th>Suicides</th>
		<th>Kill<br>Streak</th>
		<th>Death<br>Streak</th>
		<th>Rounds<br>Played</th>
		<th>Rounds<br>Won</th>
		<th>K2d</th>
		<th>Eff</th>
		</tr>
	</tfoot>
</table>
{literal}
<script type="text/javascript" charset="utf-8"> 
		$(document).ready(function() {
			$('.summary').dataTable(
				{
					"bFilter": false	,
					"aaSorting":[[1,'desc']],
					
				}
				);
		} );
	</script>
{/literal}
</div>
<div class='span-19'>
<h3>Weapons</h3>
<div id="weapons" class="tabs"> 
  <ul> 
	{foreach from=$report.weapons key=key item=item}
		<li><a href='#{$key|replace:' ':'-'}'>{$key}</a></li>
	{/foreach} 
  </ul> 


	{foreach from=$report.weapons key=key item=item}
	{if $report.weapons.$key.1.rank eq '1'}
	<div id="{$key|replace:' ':'-'}">
		<h4><a name="{$key}"></a>Top Ranked Players with {$key}</h4>
		<table class='top'>
		<thead>
			<tr>
				<th>Rank</th>
				<th>Player Name</th>
				<th>Kills</th>

			</tr>
		</thead>
		<tbody>
			{foreach from=$item item=gun}
				<tr>
					<td>{$gun.rank}</td>
					<td class="playername"><a href="{$html.wwwroot}player/{$gun.who}">{$gun.who}</a></td>
					<td>{$gun.kills}</td>
				</tr>
			{/foreach}
		</tbody>
		<tfoot>
		<tr>
			<th>Rank</th>
			<th>Player Name</th>
			<th>Kills</th>
		</tr>
		</tfoot>
		</table>
	</div>
	{/if}

	{/foreach}
</div>
<script type="text/javascript"> 
  $("#weapons ul").idTabs(); 
</script>
{literal}
<script type="text/javascript" charset="utf-8"> 
		$(document).ready(function() {
			$('.top').dataTable(
				{
					"bFilter": false	,
					"aaSorting":[[0,'asc']],
					
				}
				);
		} );
	</script>
{/literal}




</div>
<div class='span-5 last'>

<h2>Archive</h2>
<ul>
{foreach from=$weeks item=item}
	<li><a href="http://{$html.domainname}/Weekly/{$item.url}">{$item.label}</a></li>
{/foreach}
</ul>

</div>
<div class='span-24'>
this page processed all the data in real time in {$report.processtime} Seconds!!!
</div>
{include file='html/html-footer.tpl'}