<?php /* Smarty version Smarty-3.0.7, created on 2018-05-22 17:34:10
         compiled from "C:\xampp\htdocs\timetracker/WEB-INF/templates\register.tpl" */ ?>
<?php /*%%SmartyHeaderCode:50895b043872aa99b0-50659408%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '74b5bb01d671b3057a86c29b42f2003a814e5dd4' => 
    array (
      0 => 'C:\\xampp\\htdocs\\timetracker/WEB-INF/templates\\register.tpl',
      1 => 1523038854,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '50895b043872aa99b0-50659408',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php echo $_smarty_tpl->getVariable('forms')->value['groupForm']['open'];?>

<table cellspacing="4" cellpadding="7" border="0">
  <tr>
    <td>
      <table cellspacing="1" cellpadding="2" border="0">
        <tr>
          <td align="right" nowrap><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['group_name'];?>
:</td>
          <td><?php echo $_smarty_tpl->getVariable('forms')->value['groupForm']['group_name']['control'];?>
</td>
        </tr>
        <tr>
          <td align="right"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['currency'];?>
:</td>
          <td><?php echo $_smarty_tpl->getVariable('forms')->value['groupForm']['currency']['control'];?>
</td>
        </tr>
        <tr>
           <td align="right" nowrap><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['language'];?>
:</td>
           <td><?php echo $_smarty_tpl->getVariable('forms')->value['groupForm']['lang']['control'];?>
</td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
          <td align="right" nowrap><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['manager_name'];?>
 (*):</td>
          <td><?php echo $_smarty_tpl->getVariable('forms')->value['groupForm']['manager_name']['control'];?>
</td>
        </tr>
        <tr>
          <td align="right" nowrap><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['manager_login'];?>
 (*):</td>
          <td><?php echo $_smarty_tpl->getVariable('forms')->value['groupForm']['manager_login']['control'];?>
</td>
        </tr>
        <tr>
          <td align="right" nowrap><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['password'];?>
 (*):</td>
          <td><?php echo $_smarty_tpl->getVariable('forms')->value['groupForm']['password1']['control'];?>
</td>
        </tr>
        <tr>
          <td align="right" nowrap><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['confirm_password'];?>
 (*):</td>
          <td><?php echo $_smarty_tpl->getVariable('forms')->value['groupForm']['password2']['control'];?>
</td>
        </tr>
        <tr>
          <td align="right" nowrap><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['email'];?>
:</td>
          <td><?php echo $_smarty_tpl->getVariable('forms')->value['groupForm']['manager_email']['control'];?>
</td>
        </tr>
        <tr>
          <td></td>
          <td><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['required_fields'];?>
</td>
        </tr>
        <tr><td colspan="2">&nbsp;</td></tr>
        <tr>
          <td colspan="2" height="50" align="center"><?php echo $_smarty_tpl->getVariable('forms')->value['groupForm']['btn_submit']['control'];?>
</td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<?php echo $_smarty_tpl->getVariable('forms')->value['groupForm']['close'];?>

