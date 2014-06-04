<?php /* Smarty version Smarty-3.0-RC2, created on 2010-10-15 09:56:29
         compiled from "Templates/homepage.tpl" */ ?>
<?php /*%%SmartyHeaderCode:4148069204cb8173d4758c6-24601036%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a47ba91419fe7e7ed1f79c91892dcd5c28416acc' => 
    array (
      0 => 'Templates/homepage.tpl',
      1 => 1287132987,
    ),
  ),
  'nocache_hash' => '4148069204cb8173d4758c6-24601036',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_replace')) include '/Library/WebServer/Documents/q2stats/Thirdparty/Smarty/libs/plugins/modifier.replace.php';
if (!is_callable('smarty_function_gravatar')) include '/Library/WebServer/Documents/q2stats/Thirdparty/Smarty/libs/plugins/function.gravatar.php';
if (!is_callable('smarty_function_counter')) include '/Library/WebServer/Documents/q2stats/Thirdparty/Smarty/libs/plugins/function.counter.php';
?><?php $_template = new Smarty_Internal_Template('html/html-header.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
<div style='height:200px;text-align:right;' class='span-24'>
<h2>Report week starting <?php echo $_smarty_tpl->getVariable('start')->value;?>
</h2>
<h6><?php echo $_smarty_tpl->getVariable('totalkills')->value[0]['kills'];?>
 Kills Tracked</h6>
</div>
<div class="span-12">
<?php if ($_smarty_tpl->getVariable('week')->value['previous']['display']!=''){?>
<a class='weekbutton' href="http://<?php echo $_smarty_tpl->getVariable('html')->value['domainname'];?>
/Homepage/<?php echo smarty_modifier_replace($_smarty_tpl->getVariable('week')->value['previous']['display'],' ','-');?>
"> < Previous Week</a> 
<?php }?>
</div>
<div class="span-12 last">
<?php if ($_smarty_tpl->getVariable('week')->value['next']['display']!=''){?>
<div style="text-align:right;">
<a class='weekbutton' href="http://<?php echo $_smarty_tpl->getVariable('html')->value['domainname'];?>
/Homepage/<?php echo smarty_modifier_replace($_smarty_tpl->getVariable('week')->value['next']['display'],' ','-');?>
">Next Week > </a>
</div>
<?php }else{ ?>
&nbsp;
<?php }?>
</div>
<div class='span-10'>
<table>
<thead>
	<tr>
		<th class="tabletitle" colspan="3">Top Ranked Players</th>
	</tr>
</thead>
<tbody>
	<?php $_smarty_tpl->assign('i','1',null,null);?>
	<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('skill')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
?>
		<?php if ($_smarty_tpl->getVariable('i')->value<='3'){?>
		<?php if (!(1 & $_smarty_tpl->getVariable('i')->value)){?><tr class='even'><?php }else{ ?><tr><?php }?>
		 <td>
		
		<?php if ($_smarty_tpl->tpl_vars['item']->value['avatar']!=''){?>
			<img src="<?php echo $_smarty_tpl->tpl_vars['item']->value['avatar'];?>
" width='48'> 
		<?php }else{ ?>
		 		
			<?php if ($_smarty_tpl->tpl_vars['item']->value['email']!=''){?>
				<img src="<?php echo smarty_function_gravatar(array('email'=>($_smarty_tpl->tpl_vars['item']->value['email']),'size'=>"48"),$_smarty_tpl->smarty,$_smarty_tpl);?>
">
			<?php }else{ ?>
			<img src="/images/Quake-II-48.png" width="48">
			<?php }?>
		<?php }?>
		</td>
		 <td><h<?php echo $_smarty_tpl->getVariable('i')->value;?>
><?php echo $_smarty_tpl->getVariable('i')->value;?>
<sup><?php if ($_smarty_tpl->getVariable('i')->value=='1'){?>st<?php }elseif($_smarty_tpl->getVariable('i')->value=='2'){?>nd<?php }elseif($_smarty_tpl->getVariable('i')->value=='3'){?>rd<?php }?></sup> <?php echo $_smarty_tpl->tpl_vars['item']->value['who'];?>
</h<?php echo $_smarty_tpl->getVariable('i')->value;?>
></td>
		</tr>
		<?php }?>
		<?php $_smarty_tpl->assign('i',$_smarty_tpl->getVariable('i')->value+1,null,null);?>
	<?php }} ?>
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
<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('skill')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['item']->key;
?>
<tr><td><?php echo smarty_function_counter(array(),$_smarty_tpl->smarty,$_smarty_tpl);?>
</td>
<td>

<?php if ($_smarty_tpl->tpl_vars['item']->value['avatar']!=''){?>
	<img src="<?php echo $_smarty_tpl->tpl_vars['item']->value['avatar'];?>
" width='15'> 
<?php }else{ ?>
 		
	<?php if ($_smarty_tpl->tpl_vars['item']->value['email']!=''){?>
		<img src="<?php echo smarty_function_gravatar(array('email'=>($_smarty_tpl->tpl_vars['item']->value['email']),'size'=>"15"),$_smarty_tpl->smarty,$_smarty_tpl);?>
">
	<?php }else{ ?>
	<img src="/images/Quake-II-15.png" width="15">
	<?php }?>
<?php }?>
</td>
<td class='playername'>
<a href='http://<?php echo $_smarty_tpl->getVariable('html')->value['domainname'];?>
/Player/<?php echo $_smarty_tpl->tpl_vars['item']->value['who'];?>
' title='global stats for <?php echo $_smarty_tpl->tpl_vars['item']->value['who'];?>
'><?php echo $_smarty_tpl->tpl_vars['item']->value['who'];?>
</a></td>
<td><?php echo $_smarty_tpl->tpl_vars['item']->value['score'];?>
</td></tr>
<?php }} ?>
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
	<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('servers')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['item']->key;
?>
		<?php if ((1 & $_smarty_tpl->tpl_vars['key']->value)){?><tr class='even'><?php }else{ ?><tr><?php }?>
			<td><?php if ($_smarty_tpl->tpl_vars['item']->value['live']['s']['name']!=''){?><img src="<?php echo $_smarty_tpl->getVariable('html')->value['wwwroot'];?>
images/icon_online.gif"><?php }else{ ?><img src="<?php echo $_smarty_tpl->getVariable('html')->value['wwwroot'];?>
images/icon_no_response.gif"><?php }?></td>
			<td class='playername'><?php if ($_smarty_tpl->tpl_vars['item']->value['live']['s']['name']!=''){?><a href='http://<?php echo $_smarty_tpl->getVariable('html')->value['domainname'];?>
/Server/<?php echo $_smarty_tpl->tpl_vars['item']->value['server'];?>
' class="tTip" title='<b>Players</b>: <?php echo $_smarty_tpl->tpl_vars['item']->value['live']['s']['players'];?>
<br><b>Map</b>: <?php echo $_smarty_tpl->tpl_vars['item']->value['live']['s']['map'];?>
'><?php echo $_smarty_tpl->tpl_vars['item']->value['live']['s']['name'];?>
</a><?php }else{ ?><a href='http://<?php echo $_smarty_tpl->getVariable('html')->value['domainname'];?>
/Server/<?php echo $_smarty_tpl->tpl_vars['item']->value['server'];?>
' title='Stats for server <?php echo $_smarty_tpl->tpl_vars['item']->value['server'];?>
'><?php echo $_smarty_tpl->tpl_vars['item']->value['server'];?>
</a><?php }?></td>
			<td><?php echo $_smarty_tpl->tpl_vars['item']->value['rounds'];?>
</td>
			<td><?php echo $_smarty_tpl->tpl_vars['item']->value['kills'];?>
</td>
		</tr>
	<?php }} ?>
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
	<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('data')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['item']->key;
?>
	<tr>
		<td>
		
		<?php if ($_smarty_tpl->tpl_vars['item']->value['avatar']!=''){?>
			<img src="<?php echo $_smarty_tpl->tpl_vars['item']->value['avatar'];?>
" width='15'> 
		<?php }else{ ?>
		 		
			<?php if ($_smarty_tpl->tpl_vars['item']->value['email']!=''){?>
				<img src="<?php echo smarty_function_gravatar(array('email'=>($_smarty_tpl->tpl_vars['item']->value['email']),'size'=>"15"),$_smarty_tpl->smarty,$_smarty_tpl);?>
">
			<?php }else{ ?>
			<img src="/images/Quake-II-15.png" width="15">
			<?php }?>
		<?php }?>
		</td>
		<td class='playername'>
		<a href='http://<?php echo $_smarty_tpl->getVariable('html')->value['domainname'];?>
/Player/<?php echo $_smarty_tpl->tpl_vars['item']->value['who'];?>
' title='global stats for <?php echo $_smarty_tpl->tpl_vars['item']->value['who'];?>
'><?php echo $_smarty_tpl->tpl_vars['item']->value['who'];?>
</a></td>
		<td><?php echo $_smarty_tpl->tpl_vars['item']->value['kills'];?>
</td>
		<td><?php echo $_smarty_tpl->tpl_vars['item']->value['deaths'];?>
</td>
		<td><?php echo $_smarty_tpl->tpl_vars['item']->value['K2D'];?>
</td>
		<td><?php echo $_smarty_tpl->tpl_vars['item']->value['eff'];?>
</td>
		<td><?php echo $_smarty_tpl->tpl_vars['item']->value['suicides'];?>
</td>
		<td><?php echo $_smarty_tpl->tpl_vars['item']->value['killstreak'];?>
</td>
		<td><?php echo $_smarty_tpl->tpl_vars['item']->value['deathstreak'];?>
</td>
		<td><?php echo $_smarty_tpl->tpl_vars['item']->value['rnds'];?>
</th>
		<td><?php echo $_smarty_tpl->tpl_vars['item']->value['roundwins'];?>
</td>
	</tr>
	<?php }} ?>
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
	<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('data')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['item']->key;
?>
	<tr>
	<td>
	
	<?php if ($_smarty_tpl->tpl_vars['item']->value['avatar']!=''){?>
		<img src="<?php echo $_smarty_tpl->tpl_vars['item']->value['avatar'];?>
" width='15'> 
	<?php }else{ ?>
	 		
		<?php if ($_smarty_tpl->tpl_vars['item']->value['email']!=''){?>
			<img src="<?php echo smarty_function_gravatar(array('email'=>($_smarty_tpl->tpl_vars['item']->value['email']),'size'=>"15"),$_smarty_tpl->smarty,$_smarty_tpl);?>
">
		<?php }else{ ?>
		<img src="/images/Quake-II-15.png" width="15">
		<?php }?>
	<?php }?>
	</td>
		<td class='playername'><a href='http://<?php echo $_smarty_tpl->getVariable('html')->value['domainname'];?>
/Player/<?php echo $_smarty_tpl->tpl_vars['item']->value['who'];?>
' title='global stats for <?php echo $_smarty_tpl->tpl_vars['item']->value['who'];?>
'><?php echo $_smarty_tpl->tpl_vars['item']->value['who'];?>
</a></td>
		<td><?php echo $_smarty_tpl->tpl_vars['item']->value['blaster'];?>
</td>
		<td><?php echo $_smarty_tpl->tpl_vars['item']->value['shotgun'];?>
</td>
		<td><?php echo $_smarty_tpl->tpl_vars['item']->value['supershotgun'];?>
</td>
		<td><?php echo $_smarty_tpl->tpl_vars['item']->value['machinegun'];?>
</td>
		<td><?php echo $_smarty_tpl->tpl_vars['item']->value['chaingun'];?>
</td>
		<td><?php echo $_smarty_tpl->tpl_vars['item']->value['grenadelauncher'];?>
</th>
		<td><?php echo $_smarty_tpl->tpl_vars['item']->value['rocketlauncher'];?>
</td>
		<td><?php echo $_smarty_tpl->tpl_vars['item']->value['railgun'];?>
</td>
		<td><?php echo $_smarty_tpl->tpl_vars['item']->value['hyperblaster'];?>
</td>
		<td><?php echo $_smarty_tpl->tpl_vars['item']->value['bfg10k'];?>
</td>
		<td><?php echo $_smarty_tpl->tpl_vars['item']->value['handgrenade'];?>
</td>
		<td><?php echo $_smarty_tpl->tpl_vars['item']->value['telefrag'];?>
</td>
		<td><?php echo $_smarty_tpl->tpl_vars['item']->value['grapplinghook'];?>
</td>
	</tr>
	<?php }} ?>
	</tbody>
	</table>
</div>
</div>
<div class="span-12">
<?php if ($_smarty_tpl->getVariable('week')->value['previous']['display']!=''){?>
<a href="http://<?php echo $_smarty_tpl->getVariable('html')->value['domainname'];?>
/Homepage/<?php echo smarty_modifier_replace($_smarty_tpl->getVariable('week')->value['previous']['display'],' ','-');?>
">Previous Week</a> 
<?php }?>
</div>
<div class="span-12 last">

<?php if ($_smarty_tpl->getVariable('week')->value['next']['display']!=''){?>
<div style="text-align:right;">
<a href="http://<?php echo $_smarty_tpl->getVariable('html')->value['domainname'];?>
/Homepage/<?php echo smarty_modifier_replace($_smarty_tpl->getVariable('week')->value['next']['display'],' ','-');?>
">Next Week</a>
</div>
<?php }?>
</div>

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

<script type="text/javascript"> 
  $("#tablessummary ul").idTabs(); 
</script>
<div class='span-24'>
this page processed all the data in real time in <?php echo $_smarty_tpl->getVariable('timer')->value;?>
 Seconds!!!
</div>
<?php $_template = new Smarty_Internal_Template('html/html-footer.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>