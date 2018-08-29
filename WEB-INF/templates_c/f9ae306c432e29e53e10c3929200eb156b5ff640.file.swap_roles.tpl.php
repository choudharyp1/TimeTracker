<?php /* Smarty version Smarty-3.0.7, created on 2018-05-29 18:16:54
         compiled from "C:\xampp\htdocs\timetracker/WEB-INF/templates\swap_roles.tpl" */ ?>
<?php /*%%SmartyHeaderCode:195705b0d7cf67e1006-95662724%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f9ae306c432e29e53e10c3929200eb156b5ff640' => 
    array (
      0 => 'C:\\xampp\\htdocs\\timetracker/WEB-INF/templates\\swap_roles.tpl',
      1 => 1521854998,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '195705b0d7cf67e1006-95662724',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php echo $_smarty_tpl->getVariable('forms')->value['swapForm']['open'];?>

<table cellspacing="4" cellpadding="7" border="0">
  <table cellspacing="1" cellpadding="2" border="0">
    <tr><td colspan="2"><?php echo $_smarty_tpl->getVariable('i18n')->value['form']['swap']['hint'];?>
</td></tr
    <tr><td>&nbsp;</td></tr>
    <tr>
      <td align="right"><?php echo $_smarty_tpl->getVariable('i18n')->value['form']['swap']['swap_with'];?>
:</td>
      <td><?php echo $_smarty_tpl->getVariable('forms')->value['swapForm']['swap_with']['control'];?>
</td>
    </tr>
    <tr>
      <td colspan="2" align="center"><?php echo $_smarty_tpl->getVariable('forms')->value['swapForm']['btn_submit']['control'];?>
 <?php echo $_smarty_tpl->getVariable('forms')->value['swapForm']['btn_cancel']['control'];?>
</td>
    </tr>
  </table>
</table>
<?php echo $_smarty_tpl->getVariable('forms')->value['swapForm']['close'];?>

