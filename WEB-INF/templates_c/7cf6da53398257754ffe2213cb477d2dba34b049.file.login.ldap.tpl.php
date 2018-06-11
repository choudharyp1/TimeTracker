<?php /* Smarty version Smarty-3.0.7, created on 2018-06-11 11:55:10
         compiled from "/var/www/html/anuko/WEB-INF/templates/login.ldap.tpl" */ ?>
<?php /*%%SmartyHeaderCode:4464685b1e9b5ee1d158-59323606%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7cf6da53398257754ffe2213cb477d2dba34b049' => 
    array (
      0 => '/var/www/html/anuko/WEB-INF/templates/login.ldap.tpl',
      1 => 1528730512,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '4464685b1e9b5ee1d158-59323606',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<table border="0">
  <?php if ($_smarty_tpl->getVariable('show_hint')->value){?>
  <tr>
    <td colspan="2" align="center"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['ldap_hint'];?>
</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <?php }?>
  <tr>
    <td<?php if (!$_smarty_tpl->getVariable('i18n')->value['language']['rtl']){?> align="right"<?php }?>><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['login'];?>
:</td>
    <td><?php echo $_smarty_tpl->getVariable('forms')->value['loginForm']['login']['control'];?>
 <font color="#777777">@<?php echo $_smarty_tpl->getVariable('Auth_ldap_params')->value['default_domain'];?>
</font></td>
  </tr>
  <tr>
    <td<?php if (!$_smarty_tpl->getVariable('i18n')->value['language']['rtl']){?> align="right"<?php }?>><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['password'];?>
:</td>
    <td><?php echo $_smarty_tpl->getVariable('forms')->value['loginForm']['password']['control'];?>
</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="center" height="50"><?php echo $_smarty_tpl->getVariable('forms')->value['loginForm']['btn_login']['control'];?>
</td>
  </tr>
</table>
  