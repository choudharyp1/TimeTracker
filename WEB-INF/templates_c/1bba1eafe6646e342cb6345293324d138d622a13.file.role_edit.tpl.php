<?php /* Smarty version Smarty-3.0.7, created on 2018-05-29 18:01:02
         compiled from "C:\xampp\htdocs\timetracker/WEB-INF/templates\role_edit.tpl" */ ?>
<?php /*%%SmartyHeaderCode:317185b0d793eecb5e0-89466894%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1bba1eafe6646e342cb6345293324d138d622a13' => 
    array (
      0 => 'C:\\xampp\\htdocs\\timetracker/WEB-INF/templates\\role_edit.tpl',
      1 => 1519603802,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '317185b0d793eecb5e0-89466894',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php echo $_smarty_tpl->getVariable('forms')->value['roleForm']['open'];?>

<table cellspacing="4" cellpadding="7" border="0">
  <tr>
    <td>
      <table cellspacing="1" cellpadding="2" border="0">
        <tr>
          <td align="right"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['thing_name'];?>
 (*):</td>
          <td><?php echo $_smarty_tpl->getVariable('forms')->value['roleForm']['name']['control'];?>
</td>
        </tr>
        <tr>
          <td align = "right"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['description'];?>
:</td>
          <td><?php echo $_smarty_tpl->getVariable('forms')->value['roleForm']['description']['control'];?>
</td>
        </tr>
        <tr>
          <td align = "right"><?php echo $_smarty_tpl->getVariable('i18n')->value['form']['roles']['rank'];?>
:</td>
          <td><?php echo $_smarty_tpl->getVariable('forms')->value['roleForm']['rank']['control'];?>
 <a href="https://www.anuko.com/lp/tt_20.htm" target="_blank"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['what_is_it'];?>
</a></td>
        </tr>
        <tr>
          <td align = "right"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['status'];?>
:</td>
          <td><?php echo $_smarty_tpl->getVariable('forms')->value['roleForm']['status']['control'];?>
</td>
        </tr>
        <tr>
          <td></td>
          <td><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['required_fields'];?>
</td>
        </tr>
        <tr>
          <td colspan="2" align="center" height="50"><?php echo $_smarty_tpl->getVariable('forms')->value['roleForm']['btn_save']['control'];?>
</td>
        </tr>
        <tr>
          <td></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td align = "right"><?php echo $_smarty_tpl->getVariable('i18n')->value['form']['roles']['assigned'];?>
:</td>
          <td><?php echo $_smarty_tpl->getVariable('forms')->value['roleForm']['assigned_rights']['control'];?>
</td><td><?php echo $_smarty_tpl->getVariable('forms')->value['roleForm']['btn_delete']['control'];?>
</td>
        </tr>
        <tr>
          <td align = "right"><?php echo $_smarty_tpl->getVariable('i18n')->value['form']['roles']['not_assigned'];?>
:</td>
          <td><?php echo $_smarty_tpl->getVariable('forms')->value['roleForm']['available_rights']['control'];?>
</td><td><?php echo $_smarty_tpl->getVariable('forms')->value['roleForm']['btn_add']['control'];?>
</td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<?php echo $_smarty_tpl->getVariable('forms')->value['roleForm']['close'];?>

