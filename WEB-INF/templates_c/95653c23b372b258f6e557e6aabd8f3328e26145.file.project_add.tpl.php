<?php /* Smarty version Smarty-3.0.7, created on 2018-08-29 23:56:05
         compiled from "/Applications/XAMPP/xamppfiles/htdocs/timetracker/WEB-INF/templates/project_add.tpl" */ ?>
<?php /*%%SmartyHeaderCode:17098668705b871675eaebb6-90510830%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '95653c23b372b258f6e557e6aabd8f3328e26145' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/timetracker/WEB-INF/templates/project_add.tpl',
      1 => 1529899748,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '17098668705b871675eaebb6-90510830',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php echo $_smarty_tpl->getVariable('forms')->value['projectForm']['open'];?>

<table cellspacing="4" cellpadding="7" border="0">
  <tr>
    <td>
      <table class="table borderless" cellspacing="1" cellpadding="2" border="0">
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

