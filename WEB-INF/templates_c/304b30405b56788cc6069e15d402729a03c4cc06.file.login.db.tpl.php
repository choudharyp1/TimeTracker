<?php /* Smarty version Smarty-3.0.7, created on 2018-05-24 16:28:34
         compiled from "C:\xampp\htdocs\timetracker/WEB-INF/templates\login.db.tpl" */ ?>
<?php /*%%SmartyHeaderCode:57855b06cc12055079-52063427%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '304b30405b56788cc6069e15d402729a03c4cc06' => 
    array (
      0 => 'C:\\xampp\\htdocs\\timetracker/WEB-INF/templates\\login.db.tpl',
      1 => 1527172112,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '57855b06cc12055079-52063427',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<table border="0">
  <tr>
    <td<?php if (!$_smarty_tpl->getVariable('i18n')->value['language']['rtl']){?> align="right"<?php }?>><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['login'];?>
:</td>
    <td><?php echo $_smarty_tpl->getVariable('forms')->value['loginForm']['login']['control'];?>
</td>
  </tr>
  <tr>
    <td<?php if (!$_smarty_tpl->getVariable('i18n')->value['language']['rtl']){?> align="right"<?php }?>><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['password'];?>
:</td>
    <td><?php echo $_smarty_tpl->getVariable('forms')->value['loginForm']['password']['control'];?>
</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><a href ="password_reset.php"><?php echo $_smarty_tpl->getVariable('i18n')->value['form']['login']['forgot_password'];?>
</a></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="center" height="50" ><?php echo $_smarty_tpl->getVariable('forms')->value['loginForm']['btn_login']['control'];?>
</td>
  </tr>
</table>
