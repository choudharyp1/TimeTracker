<?php /* Smarty version Smarty-3.0.7, created on 2018-06-11 11:55:10
         compiled from "/var/www/html/anuko/WEB-INF/templates/index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:20136572745b1e9b5e8656a4-56342745%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f3bdcf0c58c4546798aff53b82d002a67e27c1d5' => 
    array (
      0 => '/var/www/html/anuko/WEB-INF/templates/index.tpl',
      1 => 1528730512,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '20136572745b1e9b5e8656a4-56342745',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php $_template = new Smarty_Internal_Template("header.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>

<?php if ($_smarty_tpl->getVariable('content_page_name')->value){?><?php $_template = new Smarty_Internal_Template(($_smarty_tpl->getVariable('content_page_name')->value), $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?><?php }?>

<?php $_template = new Smarty_Internal_Template("footer.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
