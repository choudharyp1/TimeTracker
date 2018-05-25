<?php /* Smarty version Smarty-3.0.7, created on 2018-05-22 20:34:32
         compiled from "C:\xampp\htdocs\timetracker/WEB-INF/templates\profile_edit.tpl" */ ?>
<?php /*%%SmartyHeaderCode:226905b0462b8733e36-37708204%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '36084f57296da3754f297edd08723ff4fd067a71' => 
    array (
      0 => 'C:\\xampp\\htdocs\\timetracker/WEB-INF/templates\\profile_edit.tpl',
      1 => 1522205928,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '226905b0462b8733e36-37708204',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php echo $_smarty_tpl->getVariable('forms')->value['profileForm']['open'];?>


<table cellspacing="4" cellpadding="7" border="0">
    <tr>
      <td>
        <table cellspacing="1" cellpadding="2" border="0">
          <tr>
            <td align="right" nowrap><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['person_name'];?>
 (*):</td>
            <td><?php echo $_smarty_tpl->getVariable('forms')->value['profileForm']['name']['control'];?>
</td>
          </tr>
          <tr>
            <td align="right" nowrap><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['login'];?>
 (*):</td>
            <td><?php echo $_smarty_tpl->getVariable('forms')->value['profileForm']['login']['control'];?>
</td>
          </tr>
<?php if (!$_smarty_tpl->getVariable('auth_external')->value){?>
          <tr>
            <td align="right" nowrap><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['password'];?>
 (*):</td>
            <td><?php echo $_smarty_tpl->getVariable('forms')->value['profileForm']['password1']['control'];?>
</td>
          </tr>
          <tr>
            <td align="right" nowrap><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['confirm_password'];?>
 (*):</td>
            <td><?php echo $_smarty_tpl->getVariable('forms')->value['profileForm']['password2']['control'];?>
</td>
          </tr>
<?php }?>
          <tr>
            <td align="right" nowrap><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['email'];?>
:</td>
            <td><?php echo $_smarty_tpl->getVariable('forms')->value['profileForm']['email']['control'];?>
</td>
          </tr>
          <tr>
            <td></td>
            <td><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['required_fields'];?>
</td>
          </tr>
          <tr>
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2" height="50" align="center"><?php echo $_smarty_tpl->getVariable('forms')->value['profileForm']['btn_save']['control'];?>
</td>
          </tr>
        </table>
      </td>
    </tr>
</table>
<?php echo $_smarty_tpl->getVariable('forms')->value['profileForm']['close'];?>

