<?php /* Smarty version Smarty-3.0.7, created on 2018-06-12 12:06:31
         compiled from "/var/www/html/anuko/WEB-INF/templates/admin_group_edit.tpl" */ ?>
<?php /*%%SmartyHeaderCode:651151655b1fef87829fa9-89573006%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e9ce44b37dfe83fef5fbef0a12123cdbb972d1db' => 
    array (
      0 => '/var/www/html/anuko/WEB-INF/templates/admin_group_edit.tpl',
      1 => 1528730512,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '651151655b1fef87829fa9-89573006',
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
<?php if (!$_smarty_tpl->getVariable('auth_external')->value){?>
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
<?php }?>
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
          <td colspan="2" height="50" align="center"><?php echo $_smarty_tpl->getVariable('forms')->value['groupForm']['btn_save']['control'];?>
&nbsp;<?php echo $_smarty_tpl->getVariable('forms')->value['groupForm']['btn_cancel']['control'];?>
</td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<?php echo $_smarty_tpl->getVariable('forms')->value['groupForm']['close'];?>

