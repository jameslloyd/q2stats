{include file='html/html-header.tpl'} 
<div class='span-24'>
<h2>Report week starting {$start}</h2>
<h2><div id="countdown"></div> </h2>
 
<h3>Players Summary</h3>
<table>
<thead>
	<tr>
		<th>Rank</th>
		<th>Player</th>
		<th>Skill</th>
	</tr>
</thead>
<tbody>
{foreach from=$skill key=key item=item}
<tr><td>{counter}</td><td class='playername'>{$key}</td><td>{$item}</td></tr>
{/foreach}
</tbody>
</table>

<table>
<thead>
	<tr>
		<th>Player</th>
		<th>Kills</th>
		<th>Deaths</th>
		<th>Suicides</th>
		<th>Max Killstreak</th>
		<th>Max Deathstreak</th>
		<th>Rounds Played</th>
		<th>Rounds Won</th>
	</tr>
</thead>
<tbody>
{foreach from=$data key=key item=item}
<tr>
	<td class='playername'>{$item.who}</td>
	<td>{$item.kills}</td>
	<td>{$item.deaths}</td>
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


<div class='span-24'>
this page processed all the data in real time in {$timer} Seconds!!!
</div>
{include file='html/html-footer.tpl'}