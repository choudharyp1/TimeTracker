<?php /* Smarty version Smarty-3.0.7, created on 2018-05-24 16:45:12
         compiled from "C:\xampp\htdocs\timetracker/WEB-INF/templates\mail.tpl" */ ?>
<?php /*%%SmartyHeaderCode:238075b06cff877c473-69761401%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ad0a03ed54449f10494a168cb526957d50d36ab4' => 
    array (
      0 => 'C:\\xampp\\htdocs\\timetracker/WEB-INF/templates\\mail.tpl',
      1 => 1516250162,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '238075b06cff877c473-69761401',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php echo $_smarty_tpl->getVariable('forms')->value['mailForm']['open'];?>

<table cellspacing="4" cellpadding="7" border="0">
<tr>
  <td>
    <table cellspacing="4" cellpadding="7" border="0">
    <tr>
      <td valign="top" colspan="2">
        <table>
        <tr>
          <td align="right"><?php echo $_smarty_tpl->getVariable('i18n')->value['form']['mail']['from'];?>
 (*):</td>
          <td><?php echo $_smarty_tpl->getVariable('sender')->value;?>
</td>
        </tr>
        <tr>
          <td align="right"><?php echo $_smarty_tpl->getVariable('i18n')->value['form']['mail']['to'];?>
 (*):</td>
          <td><?php echo $_smarty_tpl->getVariable('forms')->value['mailForm']['receiver']['control'];?>
</td>
        </tr>
        <tr>
          <td align="right"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['cc'];?>
:</td>
          <td><?php echo $_smarty_tpl->getVariable('forms')->value['mailForm']['cc']['control'];?>
</td>
        </tr>
        <tr>
          <td align="right"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['subject'];?>
 (*):</td>
          <td><?php echo $_smarty_tpl->getVariable('forms')->value['mailForm']['subject']['control'];?>
</td>
        </tr>
        <tr>
          <td align="right"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['comment'];?>
:</td>
          <td><?php echo $_smarty_tpl->getVariable('forms')->value['mailForm']['comment']['control'];?>
</td>
        </tr>
        <tr>
          <td></td>
          <td><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['required_fields'];?>
</td>
        </tr>
        <tr>
          <td colspan="2" align="center" height="70"><?php echo $_smarty_tpl->getVariable('forms')->value['mailForm']['btn_send']['control'];?>
</td>
        </tr>
        </table>
      </td>
    </tr>
    </table>
  </td>
</tr>
</table>
<?php echo $_smarty_tpl->getVariable('forms')->value['mailForm']['close'];?>

