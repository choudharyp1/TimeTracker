<?php /* Smarty version Smarty-3.0.7, created on 2018-07-10 16:48:33
         compiled from "C:\xampp\htdocs\timetracker/WEB-INF/templates\notifications.tpl" */ ?>
<?php /*%%SmartyHeaderCode:16095b06d0ca255877-39936164%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8f2bd8f46108d7c996d1600c2194829d9def5823' => 
    array (
      0 => 'C:\\xampp\\htdocs\\timetracker/WEB-INF/templates\\notifications.tpl',
      1 => 1529938411,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '16095b06d0ca255877-39936164',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_function_cycle')) include 'C:\xampp\htdocs\timetracker\WEB-INF\lib\smarty\plugins\function.cycle.php';
if (!is_callable('smarty_modifier_escape')) include 'C:\xampp\htdocs\timetracker\WEB-INF\lib\smarty\plugins\modifier.escape.php';
?><?php echo $_smarty_tpl->getVariable('forms')->value['notificationsForm']['open'];?>

<table cellspacing="0" cellpadding="7" border="0" width="720">
  <tr>
    <td valign="top">
<?php if ($_smarty_tpl->getVariable('user')->value->can('manage_advanced_settings')){?>
      <table class="table borderless" cellspacing="1" cellpadding="3" border="0" width="100%">
        <tr>
          <td class="tableHeader"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['thing_name'];?>
</td>
          <td class="tableHeader"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['schedule'];?>
</td>
          <td class="tableHeader"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['email'];?>
</td>
          <td class="tableHeader"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['condition'];?>
</td>
          <td class="tableHeader"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['edit'];?>
</td>
          <td class="tableHeader"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['delete'];?>
</td>
        </tr>
  <?php if ($_smarty_tpl->getVariable('notifications')->value){?>
    <?php  $_smarty_tpl->tpl_vars['notification'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('notifications')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['notification']->key => $_smarty_tpl->tpl_vars['notification']->value){
?>
        <tr bgcolor="<?php echo smarty_function_cycle(array('values'=>"#f5f5f5,#ffffff"),$_smarty_tpl);?>
">
          <td><?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['notification']->value['name']);?>
</td>
          <td><?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['notification']->value['cron_spec']);?>
</td>
          <td><?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['notification']->value['email']);?>
</td>
          <td><?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['notification']->value['report_condition']);?>
</td>
          <td><a href="notification_edit.php?id=<?php echo $_smarty_tpl->tpl_vars['notification']->value['id'];?>
"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['edit'];?>
</a></td>
          <td><a href="notification_delete.php?id=<?php echo $_smarty_tpl->tpl_vars['notification']->value['id'];?>
"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['delete'];?>
</a></td>
        </tr>
    <?php }} ?>
  <?php }?>
      </table>

      <table width="100%">
        <tr><td align="center"><br><?php echo $_smarty_tpl->getVariable('forms')->value['notificationsForm']['btn_add']['control'];?>
</td></tr>
      </table>
<?php }?>
    </td>
  </tr>
</table>
<?php echo $_smarty_tpl->getVariable('forms')->value['notificationsForm']['close'];?>

