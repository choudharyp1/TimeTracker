<?php /* Smarty version Smarty-3.0.7, created on 2018-07-16 15:16:27
         compiled from "C:\xampp\htdocs\timetracker/WEB-INF/templates\user_delete.tpl" */ ?>
<?php /*%%SmartyHeaderCode:28615b4c9aab4d8673-97664961%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e4365751d6039d3034a05b9fabf407404372f91a' => 
    array (
      0 => 'C:\\xampp\\htdocs\\timetracker/WEB-INF/templates\\user_delete.tpl',
      1 => 1529940282,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '28615b4c9aab4d8673-97664961',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_escape')) include 'C:\xampp\htdocs\timetracker\WEB-INF\lib\smarty\plugins\modifier.escape.php';
?><?php echo $_smarty_tpl->getVariable('forms')->value['userDeleteForm']['open'];?>

<table cellspacing="4" cellpadding="7" border="0">
  <tr class="table borderless">
    <td>
      <table cellspacing="0" cellpadding="0" border="0">
        <tr>
          <td colspan="2" align="center"><b><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('user_to_delete')->value);?>
</b></td>
        </tr>
        <tr>
          <td colspan="2" align="center">&nbsp;</td>
        </tr>
        <tr>
          <td align="right"><?php echo $_smarty_tpl->getVariable('forms')->value['userDeleteForm']['btn_delete']['control'];?>
&nbsp;</td>
          <td align="left">&nbsp;<?php echo $_smarty_tpl->getVariable('forms')->value['userDeleteForm']['btn_cancel']['control'];?>
</td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<?php echo $_smarty_tpl->getVariable('forms')->value['userDeleteForm']['close'];?>

