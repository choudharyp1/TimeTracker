<?php /* Smarty version Smarty-3.0.7, created on 2018-05-23 21:33:02
         compiled from "C:\xampp\htdocs\timetracker/WEB-INF/templates\admin_options.tpl" */ ?>
<?php /*%%SmartyHeaderCode:181495b05c1ee3c89f1-76968142%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4027bcb79ed95c5acb5a247d0d9b9fc31efac804' => 
    array (
      0 => 'C:\\xampp\\htdocs\\timetracker/WEB-INF/templates\\admin_options.tpl',
      1 => 1516250162,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '181495b05c1ee3c89f1-76968142',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php echo $_smarty_tpl->getVariable('forms')->value['optionsForm']['open'];?>

<table cellspacing="4" cellpadding="7" border="0">
  <tr>
    <td>
      <table cellspacing="1" cellpadding="2" border="0">
        <tr>
          <td align="right" nowrap><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['person_name'];?>
 (*):</td>
          <td><?php echo $_smarty_tpl->getVariable('forms')->value['optionsForm']['name']['control'];?>
</td>
        </tr>
        <tr>
          <td align="right" nowrap><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['login'];?>
 (*):</td>
          <td><?php echo $_smarty_tpl->getVariable('forms')->value['optionsForm']['login']['control'];?>
</td>
        </tr>
<?php if (!$_smarty_tpl->getVariable('auth_external')->value){?>
        <tr>
          <td align="right"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['password'];?>
:</td>
          <td><?php echo $_smarty_tpl->getVariable('forms')->value['optionsForm']['password1']['control'];?>
</td>
        </tr>
        <tr>
          <td align="right"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['confirm_password'];?>
:</td>
          <td><?php echo $_smarty_tpl->getVariable('forms')->value['optionsForm']['password2']['control'];?>
</td>
        </tr>
<?php }?>
        <tr>
          <td align="right" nowrap><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['email'];?>
:</td>
          <td><?php echo $_smarty_tpl->getVariable('forms')->value['optionsForm']['email']['control'];?>
</td>
        </tr>
        <tr>
          <td></td>
          <td><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['required_fields'];?>
</td>
        </tr>
        <tr>
          <td colspan="2" align="center" height="50"><?php echo $_smarty_tpl->getVariable('forms')->value['optionsForm']['btn_submit']['control'];?>
</td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<?php echo $_smarty_tpl->getVariable('forms')->value['optionsForm']['close'];?>

