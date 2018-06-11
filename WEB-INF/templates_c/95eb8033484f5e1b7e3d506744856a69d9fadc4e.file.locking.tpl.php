<?php /* Smarty version Smarty-3.0.7, created on 2018-06-11 13:39:49
         compiled from "/var/www/html/anuko/WEB-INF/templates/locking.tpl" */ ?>
<?php /*%%SmartyHeaderCode:12568174205b1eb3e507c2e8-99049752%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '95eb8033484f5e1b7e3d506744856a69d9fadc4e' => 
    array (
      0 => '/var/www/html/anuko/WEB-INF/templates/locking.tpl',
      1 => 1528730512,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '12568174205b1eb3e507c2e8-99049752',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php echo $_smarty_tpl->getVariable('forms')->value['lockingForm']['open'];?>

<table cellspacing="4" cellpadding="7" border="0">
  <tr>
    <td>
      <table cellspacing="1" cellpadding="2" border="0">
        <tr>
          <td align="right"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['schedule'];?>
:</td>
          <td><?php echo $_smarty_tpl->getVariable('forms')->value['lockingForm']['lock_spec']['control'];?>
 <a href="https://www.anuko.com/lp/tt_6.htm" target="_blank"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['what_is_it'];?>
</a></td>
        </tr>
        <tr>
          <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2" height="50" align="center"><?php echo $_smarty_tpl->getVariable('forms')->value['lockingForm']['btn_save']['control'];?>
</td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<?php echo $_smarty_tpl->getVariable('forms')->value['lockingForm']['close'];?>

