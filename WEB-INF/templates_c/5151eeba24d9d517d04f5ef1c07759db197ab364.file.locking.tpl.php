<?php /* Smarty version Smarty-3.0.7, created on 2018-07-10 16:48:24
         compiled from "C:\xampp\htdocs\timetracker/WEB-INF/templates\locking.tpl" */ ?>
<?php /*%%SmartyHeaderCode:240085b059fe2ad86f1-49588685%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5151eeba24d9d517d04f5ef1c07759db197ab364' => 
    array (
      0 => 'C:\\xampp\\htdocs\\timetracker/WEB-INF/templates\\locking.tpl',
      1 => 1529939216,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '240085b059fe2ad86f1-49588685',
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

