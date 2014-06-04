{include file='html/html-header.tpl'} 
<div class='span-24'>
<h2><a href="http://{$html.group}.{$html.domainname}">{$html.group}</a></h2>
<h3>{$server.live.s.name}</h3>
</div> 
<div class='span-24'>
{if $server.live.b.status eq '1'}
<img src="{$html.wwwroot}images/icon_online.gif"> Active
{else}
<img src="{$html.wwwroot}images/icon_no_response.gif"> Down
{/if}

{literal}
<script type="text/javascript" charset="utf-8"> 
		$(document).ready(function() {
			$('.stats').dataTable(
				{
					"bFilter": true,
					"aaSorting":[[1,'desc']],
				}
				);
		} );
	</script>
{/literal}
<table class="stats">
<thead>
	<tr>
		<th>Player Name</th>
		<th>Kills</th>
		<th>Deaths</th>
		<th>Suicides</th>
		<th>K:D Ratio</th>
	</tr>
</thead>
<tbody>
{foreach from=$server key=key item=item}
	<tr>
		<td><a href="http://{$html.domainname}/player/{$key}">{$key}</a></td>
		<td>{$item.kills}</td>
		<td>{$item.deaths}</td>
		<td>{$item.suicides}</td>
		<td>{$item.k2d}</td>
	</tr>
{/foreach}
</tbody>
<tfoot>
<tr>
	<th>Player Name</th>
	<th>Kills</th>
	<th>Deaths</th>
	<th>Suicides</th>
	<th>K:D Ratio</th>
</tr>
</tfoot>
</table>
</div>

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

{literal}
<script id="source" language="javascript" type="text/javascript"> 
$(function () {
{/literal}
var a = [{foreach from=$graph.kills item=data}[{$data.time}, {$data.count}],{/foreach}];
var b = [{foreach from=$graph.suicides item=data}[{$data.time}, {$data.count}],{/foreach} ];
{literal} 
    $.plot($("#placeholder"), 
	 [{ data: a, label: 'Kills'},
	  { data: b ,label: 'Suicides'}],

	 { 
	   width: 900,
	   series: {
	         lines: { show: true },
	         points: { show: true }
	     },
	   grid: { backgroundColor: { colors: ["#eee", "#ccc"] }}
	 });
});

</script>
{/literal}
{include file='html/html-footer.tpl'} 
