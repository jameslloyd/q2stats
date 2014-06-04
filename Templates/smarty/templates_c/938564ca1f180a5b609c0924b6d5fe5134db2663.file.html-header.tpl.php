<?php /* Smarty version Smarty-3.0-RC2, created on 2010-09-25 23:19:32
         compiled from "Templates/html/html-header.tpl" */ ?>
<?php /*%%SmartyHeaderCode:16822696074c9e75745f1292-98794603%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '938564ca1f180a5b609c0924b6d5fe5134db2663' => 
    array (
      0 => 'Templates/html/html-header.tpl',
      1 => 1285263833,
    ),
  ),
  'nocache_hash' => '16822696074c9e75745f1292-98794603',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
	<?php $_template = new Smarty_Internal_Template('html/html-head.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?> 
<body>
<div class="container">
<div class="span-24">
<?php $_template = new Smarty_Internal_Template('html/linkbar.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?> 
<h1 class='displaynone'><?php echo $_smarty_tpl->getVariable('html')->value['header'];?>
</h1>	
</div>