<?php /* Smarty version Smarty-3.0.7, created on 2018-08-29 23:48:49
         compiled from "/Applications/XAMPP/xamppfiles/htdocs/timetracker/WEB-INF/templates/users.tpl" */ ?>
<?php /*%%SmartyHeaderCode:17677374595b8714c1942ff3-36718303%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f7f1a6d43fdd7a82d9b10b261ebd1f2fa16197bc' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/timetracker/WEB-INF/templates/users.tpl',
      1 => 1529900698,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '17677374595b8714c1942ff3-36718303',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_function_cycle')) include '/Applications/XAMPP/xamppfiles/htdocs/timetracker/WEB-INF/lib/smarty/plugins/function.cycle.php';
if (!is_callable('smarty_modifier_escape')) include '/Applications/XAMPP/xamppfiles/htdocs/timetracker/WEB-INF/lib/smarty/plugins/modifier.escape.php';
?><script>
  function chLocation(newLocation) { document.location = newLocation; }
</script>

<table cellspacing="0" cellpadding="7" border="0" width="720">
  <tr class="table borderless">
    <td valign="top">
<?php if ($_smarty_tpl->getVariable('user')->value->can('manage_users')){?>
      <table cellspacing="1" cellpadding="3" border="0" width="100%">
  <?php if ($_smarty_tpl->getVariable('inactive_users')->value){?>
        <tr><td class="sectionHeaderNoBorder"><?php echo $_smarty_tpl->getVariable('i18n')->value['form']['users']['active_users'];?>
</td></tr>
  <?php }?>
        <tr>
          <td width="30%" class="tableHeader"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['person_name'];?>
</td>
          <td width="30%" class="tableHeader"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['login'];?>
</td>
          <td width="20%" class="tableHeader"><?php echo $_smarty_tpl->getVariable('i18n')->value['form']['users']['role'];?>
</td>
          <td width="10%" class="tableHeader"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['edit'];?>
</td>
          <td width="10%" class="tableHeader"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['delete'];?>
</td>
        </tr>
  <?php if ($_smarty_tpl->getVariable('active_users')->value){?>
    <?php  $_smarty_tpl->tpl_vars['u'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('active_users')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['u']->key => $_smarty_tpl->tpl_vars['u']->value){
?>
        <tr bgcolor="<?php echo smarty_function_cycle(array('values'=>"#f5f5f5,#ffffff"),$_smarty_tpl);?>
">
          <td>
          <?php if ($_smarty_tpl->getVariable('user')->value->uncompleted_indicators){?>
            <span class="uncompleted-entry<?php if ($_smarty_tpl->tpl_vars['u']->value['has_uncompleted_entry']){?> active<?php }?>"<?php if ($_smarty_tpl->tpl_vars['u']->value['has_uncompleted_entry']){?> title="<?php echo $_smarty_tpl->getVariable('i18n')->value['form']['users']['uncompleted_entry'];?>
"<?php }?>></span>
          <?php }?>
            <?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['u']->value['name']);?>

          </td>
          <td><?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['u']->value['login']);?>
</td>
          <td><?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['u']->value['role_name']);?>
</td>
      <?php if ($_smarty_tpl->tpl_vars['u']->value['rank']<$_smarty_tpl->getVariable('user')->value->rank||($_smarty_tpl->tpl_vars['u']->value['rank']==$_smarty_tpl->getVariable('user')->value->rank&&$_smarty_tpl->tpl_vars['u']->value['id']==$_smarty_tpl->getVariable('user')->value->id)){?>
          <td><a href="user_edit.php?id=<?php echo $_smarty_tpl->tpl_vars['u']->value['id'];?>
"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['edit'];?>
</a></td>
         <?php if ($_smarty_tpl->tpl_vars['u']->value['id']!=$_smarty_tpl->getVariable('user')->value->id){?><td><a href="user_delete.php?id=<?php echo $_smarty_tpl->tpl_vars['u']->value['id'];?>
"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['delete'];?>
</a></td><?php }else{ ?><td></td><?php }?>
      <?php }else{ ?>
          <td></td>
          <td></td>
      <?php }?>
        </tr>
    <?php }} ?>
  <?php }?>
      </table>

      <table width="100%">
        <tr>
          <td align="center"><br>
            <form><input type="button" onclick="chLocation('user_add.php');" value="<?php echo $_smarty_tpl->getVariable('i18n')->value['button']['add'];?>
"></form>
          </td>
        </tr>
      </table>

  <?php if ($_smarty_tpl->getVariable('inactive_users')->value){?>
      <table cellspacing="1" cellpadding="3" border="0" width="100%">
        <tr><td class="sectionHeaderNoBorder"><?php echo $_smarty_tpl->getVariable('i18n')->value['form']['users']['inactive_users'];?>
</td></tr>
        <tr>
          <td width="30%" class="tableHeader"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['person_name'];?>
</td>
          <td width="30%" class="tableHeader"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['login'];?>
</td>
          <td width="20%" class="tableHeader"><?php echo $_smarty_tpl->getVariable('i18n')->value['form']['users']['role'];?>
</td>
          <td width="10%" class="tableHeader"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['edit'];?>
</td>
          <td width="10%" class="tableHeader"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['delete'];?>
</td>
        </tr>
    <?php  $_smarty_tpl->tpl_vars['u'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('inactive_users')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['u']->key => $_smarty_tpl->tpl_vars['u']->value){
?>
        <tr bgcolor="<?php echo smarty_function_cycle(array('values'=>"#f5f5f5,#ffffff"),$_smarty_tpl);?>
">
          <td><?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['u']->value['name']);?>
</td>
          <td><?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['u']->value['login']);?>
</td>
          <td><?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['u']->value['role_name']);?>
</td>
      <?php if ($_smarty_tpl->tpl_vars['u']->value['rank']<$_smarty_tpl->getVariable('user')->value->rank){?>
          <td><a href="user_edit.php?id=<?php echo $_smarty_tpl->tpl_vars['u']->value['id'];?>
"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['edit'];?>
</a></td>
          <td><a href="user_delete.php?id=<?php echo $_smarty_tpl->tpl_vars['u']->value['id'];?>
"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['delete'];?>
</a></td>
      <?php }else{ ?>
          <td></td>
          <td></td>
      <?php }?>
        </tr>
    <?php }} ?>

      </table>

      <table width="100%">
        <tr>
          <td align="center" height="50">
            <form><input type="button" onclick="chLocation('user_add.php');" value="<?php echo $_smarty_tpl->getVariable('i18n')->value['button']['add'];?>
"></form>
          </td>
        </tr>
      </table>
  <?php }?>
<?php }else{ ?>
      <table cellspacing="1" cellpadding="3" border="0" width="100%">
        <tr>
          <td width="35%" class="tableHeader"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['person_name'];?>
</td>
          <td width="35%" class="tableHeader"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['login'];?>
</td>
          <td class="tableHeader"><?php echo $_smarty_tpl->getVariable('i18n')->value['form']['users']['role'];?>
</td>
        </tr>
  <?php  $_smarty_tpl->tpl_vars['u'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('active_users')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['u']->key => $_smarty_tpl->tpl_vars['u']->value){
?>
        <tr bgcolor="<?php echo smarty_function_cycle(array('values'=>"#f5f5f5,#ffffff"),$_smarty_tpl);?>
">
          <td><?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['u']->value['name']);?>
</td>
          <td><?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['u']->value['login']);?>
</td>
          <td><?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['u']->value['role_name']);?>
</td>
        </tr>
  <?php }} ?>
      </table>
<?php }?>
    </td>
  </tr>
</table>
