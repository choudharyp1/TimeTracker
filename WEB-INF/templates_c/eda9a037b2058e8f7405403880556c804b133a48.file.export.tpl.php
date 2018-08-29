<?php /* Smarty version Smarty-3.0.7, created on 2018-05-29 18:01:56
         compiled from "C:\xampp\htdocs\timetracker/WEB-INF/templates\export.tpl" */ ?>
<?php /*%%SmartyHeaderCode:13195b0d79749a52d3-90781152%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'eda9a037b2058e8f7405403880556c804b133a48' => 
    array (
      0 => 'C:\\xampp\\htdocs\\timetracker/WEB-INF/templates\\export.tpl',
      1 => 1522732644,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '13195b0d79749a52d3-90781152',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php echo $_smarty_tpl->getVariable('forms')->value['exportForm']['open'];?>

<table cellspacing="0" cellpadding="7" border="0" width="720">
  <tr>
    <td align="center">
<?php if ($_smarty_tpl->getVariable('user')->value->can('export_data')){?>
      <table border="0" width="60%">
        <colgroup>
          <col width="50%">
          <col width="50%">
        </colgroup>
        <tr><td colspan="2"><?php echo $_smarty_tpl->getVariable('i18n')->value['form']['export']['hint'];?>
<br></td></tr>
        <tr><td colspan="2">&nbsp;</td></tr>
        <tr>
          <td align="right"><?php echo $_smarty_tpl->getVariable('i18n')->value['form']['export']['compression'];?>
:</td>
          <td><?php echo $_smarty_tpl->getVariable('forms')->value['exportForm']['compression']['control'];?>
</td>
        </tr>
        <tr><td height="50" align="center" colspan="2"><?php echo $_smarty_tpl->getVariable('forms')->value['exportForm']['btn_submit']['control'];?>
</td></tr>
      </table>
<?php }?>
    </td>
  </tr>
</table>
<?php echo $_smarty_tpl->getVariable('forms')->value['exportForm']['close'];?>

