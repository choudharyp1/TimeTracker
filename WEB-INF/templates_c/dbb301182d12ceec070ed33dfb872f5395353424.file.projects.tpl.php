<?php /* Smarty version Smarty-3.0.7, created on 2018-06-11 13:33:07
         compiled from "/var/www/html/anuko/WEB-INF/templates/projects.tpl" */ ?>
<?php /*%%SmartyHeaderCode:21239442625b1eb25351bd43-64541088%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'dbb301182d12ceec070ed33dfb872f5395353424' => 
    array (
      0 => '/var/www/html/anuko/WEB-INF/templates/projects.tpl',
      1 => 1528730512,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '21239442625b1eb25351bd43-64541088',
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
<?php if ($_smarty_tpl->getVariable('user')->value->can('manage_projects')){?>
      <table cellspacing="1" cellpadding="3" border="0" width="100%">
  <?php if ($_smarty_tpl->getVariable('inactive_projects')->value){?>
        <tr><td class="sectionHeaderNoBorder"><?php echo $_smarty_tpl->getVariable('i18n')->value['form']['projects']['active_projects'];?>
</td></tr>
  <?php }?>
        <tr>
          <td width="35%" class="tableHeader"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['thing_name'];?>
</td>
          <td width="35%" class="tableHeader"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['description'];?>
</td>
          <td class="tableHeader"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['edit'];?>
</td>
          <td class="tableHeader"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['delete'];?>
</td>
        </tr>
  <?php if ($_smarty_tpl->getVariable('active_projects')->value){?>
    <?php  $_smarty_tpl->tpl_vars['project'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('active_projects')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['project']->key => $_smarty_tpl->tpl_vars['project']->value){
?>
        <tr bgcolor="<?php echo smarty_function_cycle(array('values'=>"#f5f5f5,#ffffff"),$_smarty_tpl);?>
">
          <td><?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['project']->value['name']);?>
</td>
          <td><?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['project']->value['description']);?>
</td>
          <td><a href="project_edit.php?id=<?php echo $_smarty_tpl->tpl_vars['project']->value['id'];?>
"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['edit'];?>
</a></td>
          <td><a href="project_delete.php?id=<?php echo $_smarty_tpl->tpl_vars['project']->value['id'];?>
"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['delete'];?>
</a></td>
        </tr>
    <?php }} ?>
  <?php }?>
      </table>

      <table width="100%">
        <tr>
          <td align="center"><br>
            <form><input type="button" onclick="chLocation('project_add.php');" value="<?php echo $_smarty_tpl->getVariable('i18n')->value['button']['add'];?>
"></form>
          </td>
        </tr>
      </table>

  <?php if ($_smarty_tpl->getVariable('inactive_projects')->value){?>
      <table cellspacing="1" cellpadding="3" border="0" width="100%">
        <tr><td class="sectionHeaderNoBorder"><?php echo $_smarty_tpl->getVariable('i18n')->value['form']['projects']['inactive_projects'];?>
</td></tr>
        <tr>
          <td width="35%" class="tableHeader"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['thing_name'];?>
</td>
          <td width="35%" class="tableHeader"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['description'];?>
</td>
          <td class="tableHeader"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['edit'];?>
</td>
          <td class="tableHeader"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['delete'];?>
</td>
        </tr>
    <?php  $_smarty_tpl->tpl_vars['project'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('inactive_projects')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['project']->key => $_smarty_tpl->tpl_vars['project']->value){
?>
        <tr bgcolor="<?php echo smarty_function_cycle(array('values'=>"#f5f5f5,#ffffff"),$_smarty_tpl);?>
">
          <td><?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['project']->value['name']);?>
</td>
          <td><?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['project']->value['description']);?>
</td>
          <td><a href="project_edit.php?id=<?php echo $_smarty_tpl->tpl_vars['project']->value['id'];?>
"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['edit'];?>
</a></td>
          <td><a href="project_delete.php?id=<?php echo $_smarty_tpl->tpl_vars['project']->value['id'];?>
"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['delete'];?>
</a></td>
        </tr>
    <?php }} ?>
      </table>

      <table width="100%">
        <tr>
          <td align="center"><br>
            <form><input type="button" onclick="chLocation('project_add.php');" value="<?php echo $_smarty_tpl->getVariable('i18n')->value['button']['add'];?>
"></form>
          </td>
        </tr>
      </table>
  <?php }?>
<?php }else{ ?>
      <table cellspacing="1" cellpadding="3" border="0" width="100%">
        <tr>
          <td class="tableHeader"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['thing_name'];?>
</td>
          <td class="tableHeader"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['description'];?>
</td>
        </tr>
  <?php if ($_smarty_tpl->getVariable('active_projects')->value){?>
    <?php  $_smarty_tpl->tpl_vars['project'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('active_projects')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['project']->key => $_smarty_tpl->tpl_vars['project']->value){
?>
        <tr bgcolor="<?php echo smarty_function_cycle(array('values'=>"#f5f5f5,#ffffff"),$_smarty_tpl);?>
">
          <td><?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['project']->value['name']);?>
</td>
          <td><?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['project']->value['description']);?>
</td>
        </tr>
    <?php }} ?>
  <?php }?>
      </table>
<?php }?>
    </td>
  </tr>
</table>
