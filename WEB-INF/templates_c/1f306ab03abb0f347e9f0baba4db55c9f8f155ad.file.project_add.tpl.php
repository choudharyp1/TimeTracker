<?php /* Smarty version Smarty-3.0.7, created on 2018-05-22 20:34:25
         compiled from "C:\xampp\htdocs\timetracker/WEB-INF/templates\project_add.tpl" */ ?>
<?php /*%%SmartyHeaderCode:216135b0462b1819532-03274073%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1f306ab03abb0f347e9f0baba4db55c9f8f155ad' => 
    array (
      0 => 'C:\\xampp\\htdocs\\timetracker/WEB-INF/templates\\project_add.tpl',
      1 => 1516250162,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '216135b0462b1819532-03274073',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php echo $_smarty_tpl->getVariable('forms')->value['projectForm']['open'];?>

<table cellspacing="4" cellpadding="7" border="0">
  <tr>
    <td>
      <table cellspacing="1" cellpadding="2" border="0">
        <tr>
          <td align="right"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['thing_name'];?>
 (*):</td>
          <td><?php echo $_smarty_tpl->getVariable('forms')->value['projectForm']['project_name']['control'];?>
</td>
        </tr>
        <tr>
          <td align = "right"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['description'];?>
:</td>
          <td><?php echo $_smarty_tpl->getVariable('forms')->value['projectForm']['description']['control'];?>
</td>
        </tr>
        <tr><td>&nbsp;</td></tr>
 
        <tr>
          <td align="right"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['users'];?>
:</td>
          <td><?php echo $_smarty_tpl->getVariable('forms')->value['projectForm']['users']['control'];?>
</td>
        </tr>
<?php if ((@MODE_PROJECTS_AND_TASKS==$_smarty_tpl->getVariable('user')->value->tracking_mode)){?>
        <tr><td>&nbsp;</td></tr>
        <tr>
          <td align="right"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['tasks'];?>
:</td>
          <td><?php echo $_smarty_tpl->getVariable('forms')->value['projectForm']['tasks']['control'];?>
</td>
        </tr>
<?php }?>
        <tr>
          <td></td>
          <td><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['required_fields'];?>
</td>
        </tr>
        <tr>
          <td></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2" align="center" height="50"><?php echo $_smarty_tpl->getVariable('forms')->value['projectForm']['btn_add']['control'];?>
</td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<?php echo $_smarty_tpl->getVariable('forms')->value['projectForm']['close'];?>

