<?php /* Smarty version Smarty-3.0.7, created on 2018-08-29 23:49:15
         compiled from "/Applications/XAMPP/xamppfiles/htdocs/timetracker/WEB-INF/templates/locking.tpl" */ ?>
<?php /*%%SmartyHeaderCode:20003834595b8714db14d232-89711505%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ca328704e8cab30049ebb4c8df81439fbe13c3f5' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/timetracker/WEB-INF/templates/locking.tpl',
      1 => 1529899618,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '20003834595b8714db14d232-89711505',
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

