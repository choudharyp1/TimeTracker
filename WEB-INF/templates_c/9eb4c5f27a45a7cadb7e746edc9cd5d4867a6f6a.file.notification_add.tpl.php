<?php /* Smarty version Smarty-3.0.7, created on 2018-05-24 16:48:45
         compiled from "C:\xampp\htdocs\timetracker/WEB-INF/templates\notification_add.tpl" */ ?>
<?php /*%%SmartyHeaderCode:69905b06d0cd0c4bf1-60305143%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9eb4c5f27a45a7cadb7e746edc9cd5d4867a6f6a' => 
    array (
      0 => 'C:\\xampp\\htdocs\\timetracker/WEB-INF/templates\\notification_add.tpl',
      1 => 1520563152,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '69905b06d0cd0c4bf1-60305143',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php echo $_smarty_tpl->getVariable('forms')->value['notificationForm']['open'];?>

<table cellspacing="4" cellpadding="7" border="0">
  <tr>
    <td>
      <table cellspacing="1" cellpadding="2" border="0">
        <tr>
          <td align="right"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['fav_report'];?>
 (*):</td>
          <td><?php echo $_smarty_tpl->getVariable('forms')->value['notificationForm']['fav_report']['control'];?>
</td>
        </tr>
        <tr>
          <td align="right"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['schedule'];?>
 (*):</td>
          <td><?php echo $_smarty_tpl->getVariable('forms')->value['notificationForm']['cron_spec']['control'];?>
 <a href="https://www.anuko.com/lp/tt_6.htm" target="_blank"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['what_is_it'];?>
</a></td>
        </tr>
        <tr>
          <td align="right"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['email'];?>
 (*):</td>
          <td><?php echo $_smarty_tpl->getVariable('forms')->value['notificationForm']['email']['control'];?>
</td>
        </tr>
        <tr>
          <td align="right"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['cc'];?>
:</td>
          <td><?php echo $_smarty_tpl->getVariable('forms')->value['notificationForm']['cc']['control'];?>
</td>
        </tr>
        <tr>
          <td align="right"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['subject'];?>
:</td>
          <td><?php echo $_smarty_tpl->getVariable('forms')->value['notificationForm']['subject']['control'];?>
</td>
        </tr>
        <tr>
          <td align="right"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['condition'];?>
:</td>
          <td><?php echo $_smarty_tpl->getVariable('forms')->value['notificationForm']['report_condition']['control'];?>
 <a href="https://www.anuko.com/lp/tt_9.htm" target="_blank"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['what_is_it'];?>
</a></td>
        </tr>
        <tr>
          <td height="40"></td>
          <td><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['required_fields'];?>
</td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
          <td colspan="2" align="center" height="50"><?php echo $_smarty_tpl->getVariable('forms')->value['notificationForm']['btn_add']['control'];?>
</td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<?php echo $_smarty_tpl->getVariable('forms')->value['notificationForm']['close'];?>

