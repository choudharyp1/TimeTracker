<?php /* Smarty version Smarty-3.0.7, created on 2018-08-27 02:02:56
         compiled from "/Applications/XAMPP/xamppfiles/htdocs/timetracker/WEB-INF/templates/login.ldap.tpl" */ ?>
<?php /*%%SmartyHeaderCode:19582627005b833fb0aa5c29-45467538%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'af914531cd12dd112c4a6d9c5d126b870aa568e9' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/timetracker/WEB-INF/templates/login.ldap.tpl',
      1 => 1529899660,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '19582627005b833fb0aa5c29-45467538',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<table class="table borderless" border="0">
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
  