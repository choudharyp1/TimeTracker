<?php /* Smarty version Smarty-3.0.7, created on 2018-08-30 00:06:33
         compiled from "/Applications/XAMPP/xamppfiles/htdocs/timetracker/WEB-INF/templates/week_view.tpl" */ ?>
<?php /*%%SmartyHeaderCode:6015096865b8718e9b0f194-00621939%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '940b5c2655091d326051d8857b8776b8ee1c619f' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/timetracker/WEB-INF/templates/week_view.tpl',
      1 => 1529636714,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '6015096865b8718e9b0f194-00621939',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php echo $_smarty_tpl->getVariable('forms')->value['weekViewForm']['open'];?>

<table cellspacing="1" cellpadding="2" border="0">
  <tr>
    <td align="right" nowrap><?php echo $_smarty_tpl->getVariable('forms')->value['weekViewForm']['week_note']['control'];?>
</td>
    <td><label for="week_note"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['week_note'];?>
</label> <a href="https://www.anuko.com/lp/tt_11.htm" target="_blank"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['what_is_it'];?>
</a></td>
  </tr>
  <tr>
    <td align="right" nowrap><?php echo $_smarty_tpl->getVariable('forms')->value['weekViewForm']['week_list']['control'];?>
</td>
    <td><label for="week_list"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['week_list'];?>
</label> <a href="https://www.anuko.com/lp/tt_12.htm" target="_blank"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['what_is_it'];?>
</a></td>
  </tr>
  <tr>
    <td align="right" nowrap><?php echo $_smarty_tpl->getVariable('forms')->value['weekViewForm']['notes']['control'];?>
</td>
    <td><label for="notes"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['notes'];?>
</label> <a href="https://www.anuko.com/lp/tt_13.htm" target="_blank"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['what_is_it'];?>
</a></td>
  </tr>

  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" height="50" align="center"><?php echo $_smarty_tpl->getVariable('forms')->value['weekViewForm']['btn_save']['control'];?>
</td>
  </tr>
</table>
<?php echo $_smarty_tpl->getVariable('forms')->value['weekViewForm']['close'];?>

