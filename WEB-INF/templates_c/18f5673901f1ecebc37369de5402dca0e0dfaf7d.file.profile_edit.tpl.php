<?php /* Smarty version Smarty-3.0.7, created on 2018-06-12 12:39:53
         compiled from "/var/www/html/anuko/WEB-INF/templates/profile_edit.tpl" */ ?>
<?php /*%%SmartyHeaderCode:3631797415b1ff759a91a92-65324428%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '18f5673901f1ecebc37369de5402dca0e0dfaf7d' => 
    array (
      0 => '/var/www/html/anuko/WEB-INF/templates/profile_edit.tpl',
      1 => 1528730512,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3631797415b1ff759a91a92-65324428',
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

