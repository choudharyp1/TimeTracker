<?php /* Smarty version Smarty-3.0.7, created on 2018-06-12 15:13:24
         compiled from "/var/www/html/anuko/WEB-INF/templates/roles.tpl" */ ?>
<?php /*%%SmartyHeaderCode:11465522125b201b54a08b28-61240812%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f3b49fa49408efe6f4a6b35ab380b7e0ab2de8df' => 
    array (
      0 => '/var/www/html/anuko/WEB-INF/templates/roles.tpl',
      1 => 1528730512,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '11465522125b201b54a08b28-61240812',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_function_cycle')) include '/var/www/html/anuko/WEB-INF/lib/smarty/plugins/function.cycle.php';
if (!is_callable('smarty_modifier_escape')) include '/var/www/html/anuko/WEB-INF/lib/smarty/plugins/modifier.escape.php';
?><script>
  function chLocation(newLocation) { document.location = newLocation; }
</script>

<table cellspacing="0" cellpadding="7" border="0" width="720">
  <tr>
    <td valign="top">
      <table cellspacing="1" cellpadding="3" border="0" width="100%">
  <?php if ($_smarty_tpl->getVariable('inactive_roles')->value){?>
        <tr><td class="sectionHeaderNoBorder"><?php echo $_smarty_tpl->getVariable('i18n')->value['form']['roles']['active_roles'];?>
</td></tr>
  <?php }?>
        <tr>
          <td width="25%" class="tableHeader"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['thing_name'];?>
</td>
          <td class="tableHeader"><?php echo $_smarty_tpl->getVariable('i18n')->value['form']['roles']['rank'];?>
</td>
          <td width="35%" class="tableHeader"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['description'];?>
</td>
          <td class="tableHeader"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['edit'];?>
</td>
          <td class="tableHeader"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['delete'];?>
</td>
        </tr>
  <?php if ($_smarty_tpl->getVariable('active_roles')->value){?>
    <?php  $_smarty_tpl->tpl_vars['role'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('active_roles')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['role']->key => $_smarty_tpl->tpl_vars['role']->value){
?>
        <tr bgcolor="<?php echo smarty_function_cycle(array('values'=>"#f5f5f5,#ffffff"),$_smarty_tpl);?>
">
          <td><?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['role']->value['name']);?>
</td>
          <td><?php echo $_smarty_tpl->tpl_vars['role']->value['rank'];?>
</td>
          <td><?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['role']->value['description']);?>
</td>
          <td><a href="role_edit.php?id=<?php echo $_smarty_tpl->tpl_vars['role']->value['id'];?>
"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['edit'];?>
</a></td>
          <td><a href="role_delete.php?id=<?php echo $_smarty_tpl->tpl_vars['role']->value['id'];?>
"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['delete'];?>
</a></td>
        </tr>
    <?php }} ?>
  <?php }?>
      </table>

      <table width="100%">
        <tr>
          <td align="center"><br>
            <form><input type="button" onclick="chLocation('role_add.php');" value="<?php echo $_smarty_tpl->getVariable('i18n')->value['button']['add'];?>
"></form>
          </td>
        </tr>
      </table>

  <?php if ($_smarty_tpl->getVariable('inactive_roles')->value){?>
      <table cellspacing="1" cellpadding="3" border="0" width="100%">
        <tr><td class="sectionHeaderNoBorder"><?php echo $_smarty_tpl->getVariable('i18n')->value['form']['roles']['inactive_roles'];?>
</td></tr>
        <tr>
          <td width="25%" class="tableHeader"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['thing_name'];?>
</td>
          <td class="tableHeader"><?php echo $_smarty_tpl->getVariable('i18n')->value['form']['roles']['rank'];?>
</td>
          <td width="35%" class="tableHeader"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['description'];?>
</td>
          <td class="tableHeader"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['edit'];?>
</td>
          <td class="tableHeader"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['delete'];?>
</td>
        </tr>
    <?php  $_smarty_tpl->tpl_vars['role'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('inactive_roles')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['role']->key => $_smarty_tpl->tpl_vars['role']->value){
?>
        <tr bgcolor="<?php echo smarty_function_cycle(array('values'=>"#f5f5f5,#ffffff"),$_smarty_tpl);?>
">
          <td><?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['role']->value['name']);?>
</td>
          <td><?php echo $_smarty_tpl->tpl_vars['role']->value['rank'];?>
</td>
          <td><?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['role']->value['description']);?>
</td>
          <td><a href="role_edit.php?id=<?php echo $_smarty_tpl->tpl_vars['role']->value['id'];?>
"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['edit'];?>
</a></td>
          <td><a href="role_delete.php?id=<?php echo $_smarty_tpl->tpl_vars['role']->value['id'];?>
"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['delete'];?>
</a></td>
        </tr>
    <?php }} ?>
      </table>

      <table width="100%">
        <tr>
          <td align="center"><br>
            <form><input type="button" onclick="chLocation('role_add.php');" value="<?php echo $_smarty_tpl->getVariable('i18n')->value['button']['add'];?>
"></form>
          </td>
        </tr>
      </table>
  <?php }?>
    </td>
  </tr>
</table>
