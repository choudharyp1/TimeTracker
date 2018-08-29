<?php /* Smarty version Smarty-3.0.7, created on 2018-07-10 15:59:37
         compiled from "C:\xampp\htdocs\timetracker/WEB-INF/templates\admin_groups.tpl" */ ?>
<?php /*%%SmartyHeaderCode:211985b042e6e8f1aa8-11104266%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '625f538fad847b521791bee9dd2c8001f1ccce5a' => 
    array (
      0 => 'C:\\xampp\\htdocs\\timetracker/WEB-INF/templates\\admin_groups.tpl',
      1 => 1529939063,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '211985b042e6e8f1aa8-11104266',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_function_cycle')) include 'C:\xampp\htdocs\timetracker\WEB-INF\lib\smarty\plugins\function.cycle.php';
if (!is_callable('smarty_modifier_escape')) include 'C:\xampp\htdocs\timetracker\WEB-INF\lib\smarty\plugins\modifier.escape.php';
?><script>
  function chLocation(newLocation) { document.location = newLocation; }
</script>

<table cellspacing="0" cellpadding="7" border="0" width="720">
  <tr><td valign="top"><?php echo $_smarty_tpl->getVariable('i18n')->value['form']['groups']['hint'];?>
</td></tr>
</table>

<table  cellspacing="1" cellpadding="3" border="0" width="720">
  <tr class="table borderless">
    <td width="3%" class="tableHeader"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['id'];?>
</td>
    <td width="70%" class="tableHeader"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['thing_name'];?>
</td>
    <td class="tableHeader"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['date'];?>
</td>
    <td class="tableHeader"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['language'];?>
</td>
    <td class="tableHeader"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['edit'];?>
</td>
    <td class="tableHeader"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['delete'];?>
</td>
  </tr>
<?php if ($_smarty_tpl->getVariable('groups')->value){?>
  <?php  $_smarty_tpl->tpl_vars['group'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('groups')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['group']->key => $_smarty_tpl->tpl_vars['group']->value){
?>
  <tr bgcolor="<?php echo smarty_function_cycle(array('values'=>"#f5f5f5,#ffffff"),$_smarty_tpl);?>
">
    <td><?php echo $_smarty_tpl->tpl_vars['group']->value['id'];?>
</td>
    <td><?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['group']->value['name']);?>
</td>
    <td nowrap><?php echo $_smarty_tpl->tpl_vars['group']->value['date'];?>
</td>
    <td align="center"><?php echo $_smarty_tpl->tpl_vars['group']->value['lang'];?>
</td>
    <td><a href="admin_group_edit.php?id=<?php echo $_smarty_tpl->tpl_vars['group']->value['id'];?>
"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['edit'];?>
</a></td>
    <td><a href="admin_group_delete.php?id=<?php echo $_smarty_tpl->tpl_vars['group']->value['id'];?>
"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['delete'];?>
</a></td>
  </tr>
  <?php }} ?>
<?php }?>
</table>

<table width="100%">
  <tr>
    <td align="center">
      <br>
      <form>
        <input type="button" onclick="chLocation('admin_group_add.php');" value="<?php echo $_smarty_tpl->getVariable('i18n')->value['button']['create_group'];?>
">&nbsp;<?php echo $_smarty_tpl->getVariable('i18n')->value['label']['or'];?>
&nbsp;
        <input type="button" onclick="chLocation('import.php');" value="<?php echo $_smarty_tpl->getVariable('i18n')->value['button']['import'];?>
">
      </form>
    </td>
  </tr>
</table>
