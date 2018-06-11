<?php /* Smarty version Smarty-3.0.7, created on 2018-05-29 19:14:29
         compiled from "C:\xampp\htdocs\timetracker/WEB-INF/templates\cf_custom_field_add.tpl" */ ?>
<?php /*%%SmartyHeaderCode:106215b0d8a751c3f95-09705660%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '34563ff5d48c5b5db9ec2a3ec28e486cca4ab5df' => 
    array (
      0 => 'C:\\xampp\\htdocs\\timetracker/WEB-INF/templates\\cf_custom_field_add.tpl',
      1 => 1521057810,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '106215b0d8a751c3f95-09705660',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php echo $_smarty_tpl->getVariable('forms')->value['fieldForm']['open'];?>

<table cellspacing="4" cellpadding="7" border="0">
  <tr>
    <td>
<?php if ($_smarty_tpl->getVariable('user')->value->can('manage_custom_fields')){?>
      <table cellspacing="1" cellpadding="2" border="0">
        <tr>
          <td align="right"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['thing_name'];?>
 (*):</td>
          <td><?php echo $_smarty_tpl->getVariable('forms')->value['fieldForm']['name']['control'];?>
</td>
        </tr>
        <tr>
          <td align="right"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['type'];?>
:</td>
          <td><?php echo $_smarty_tpl->getVariable('forms')->value['fieldForm']['type']['control'];?>
</td>
        </tr>
        <tr>
          <td align="right"><label for="required"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['required'];?>
:</label></td>
          <td><?php echo $_smarty_tpl->getVariable('forms')->value['fieldForm']['required']['control'];?>
</td>
        </tr>
        <tr>
          <td></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2" align="center" height="50"><?php echo $_smarty_tpl->getVariable('forms')->value['fieldForm']['btn_add']['control'];?>
</td>
        </tr>
      </table>
<?php }?>
    </td>
  </tr>
</table>
<?php echo $_smarty_tpl->getVariable('forms')->value['fieldForm']['close'];?>

