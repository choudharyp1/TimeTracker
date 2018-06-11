<?php /* Smarty version Smarty-3.0.7, created on 2018-05-23 21:33:36
         compiled from "C:\xampp\htdocs\timetracker/WEB-INF/templates\user_edit.tpl" */ ?>
<?php /*%%SmartyHeaderCode:96585b05c21098ad74-44434892%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e5c5d88ca00c99767a4c973c5a4894ba4bd896e1' => 
    array (
      0 => 'C:\\xampp\\htdocs\\timetracker/WEB-INF/templates\\user_edit.tpl',
      1 => 1523500100,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '96585b05c21098ad74-44434892',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<script>
// Prepare an array of available roles. We need it for "is_client" property.
// It is used to selectively display client selector for client roles.
roles = new Array();
var idx = 0;
<?php  $_smarty_tpl->tpl_vars['active_role'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('active_roles')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['active_role']->key => $_smarty_tpl->tpl_vars['active_role']->value){
?>
roles[idx] = new Array(<?php echo $_smarty_tpl->tpl_vars['active_role']->value['id'];?>
, '<?php echo $_smarty_tpl->tpl_vars['active_role']->value['is_client'];?>
');
idx++;
<?php }} ?>

// Prepare an array of rates.
// Format: project_rates[0] = Array(100, '25.00'), project_rates[1] = Array(120, '30.00'), etc...
// First element = project_id, second element = rate for project. Quotes needed for string representation of rates.
project_rates = new Array();
var idx = 0;
<?php  $_smarty_tpl->tpl_vars['rate'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('rates')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['rate']->key => $_smarty_tpl->tpl_vars['rate']->value){
?>
project_rates[idx] = new Array(<?php echo $_smarty_tpl->tpl_vars['rate']->value['id'];?>
, '<?php echo $_smarty_tpl->tpl_vars['rate']->value['rate'];?>
');
idx++;
<?php }} ?>

// getRate - returns a rate for the project. If rate was set for user previously we'll get this old rate
// if project time entries for user exists. Otherwise return user default rate.
function getRate(project_id) {
  var length = project_rates.length;
  for(var i = 0; i < length; i++) {
    if(project_rates[i][0] == project_id) {
      return project_rates[i][1];
    }
  }
  var default_rate = document.userForm.rate.value;
  return default_rate;
}

// The setRate function sets / unsets user rate for a project when a corresponding checkbox is ticked.
function setRate(element) {
  var default_rate = document.userForm.rate.value;
  if (default_rate == '') {
    // No default rate, nothing to do!
    return;
  }
  // Iterate through elements of the form to find and set the project rate. 
  for (var i = 0; i < userForm.elements.length; i++) {
    if ((userForm.elements[i].type == 'text') && (userForm.elements[i].name == ('rate_'+element.value))) {
      if (element.checked) {
        userForm.elements[i].value = getRate(element.value);
      } else {
        userForm.elements[i].value = '';
      }
      break; // Element is found and set, nothing more to do, break out of the loop.
    }
  }
}

// handleClientControl - controls visibility of the client dropdown depending on the selected user role.
// We need to show it only when the "Client" user role is selected.
function handleClientControl() {
  var selectedRoleId = document.getElementById("role").value;
  var clientControl = document.getElementById("client");
  var len = roles.length;
  for (var i = 0; i < len; i++) {
    if (selectedRoleId == roles[i][0]) {
      var isClient = roles[i][1];
      if (isClient == 1)
        clientControl.style.visibility = "visible";
      else
        clientControl.style.visibility = "hidden";
      break;
    }
  }
}
</script>

<?php echo $_smarty_tpl->getVariable('forms')->value['userForm']['open'];?>

<table cellspacing="4" cellpadding="7" border="0">
  <table cellspacing="1" cellpadding="2" border="0">
    <tr>
      <td align="right"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['person_name'];?>
 (*):</td>
      <td><?php echo $_smarty_tpl->getVariable('forms')->value['userForm']['name']['control'];?>
</td>
    </tr>
    <tr>
      <td align="right"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['login'];?>
 (*):</td>
      <td><?php echo $_smarty_tpl->getVariable('forms')->value['userForm']['login']['control'];?>
</td>
    </tr>
<?php if (!$_smarty_tpl->getVariable('auth_external')->value){?>
    <tr>
      <td align="right"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['password'];?>
 (*):</td>
      <td><?php echo $_smarty_tpl->getVariable('forms')->value['userForm']['pas1']['control'];?>
</td>
    </tr>
    <tr>
      <td align="right"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['confirm_password'];?>
 (*):</td>
      <td><?php echo $_smarty_tpl->getVariable('forms')->value['userForm']['pas2']['control'];?>
</td>
    </tr>
<?php }?>
    <tr>
      <td align="right" nowrap><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['email'];?>
:</td>
      <td><?php echo $_smarty_tpl->getVariable('forms')->value['userForm']['email']['control'];?>
</td>
    </tr>
<?php if ($_smarty_tpl->getVariable('user')->value->id!=$_smarty_tpl->getVariable('user_id')->value){?>
    <tr>
      <td align="right"><?php echo $_smarty_tpl->getVariable('i18n')->value['form']['users']['role'];?>
:</td>
      <td><?php echo $_smarty_tpl->getVariable('forms')->value['userForm']['role']['control'];?>
 <?php echo $_smarty_tpl->getVariable('forms')->value['userForm']['client']['control'];?>
</td>
    </tr>
    <tr>
      <td align="right"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['status'];?>
:</td>
      <td><?php echo $_smarty_tpl->getVariable('forms')->value['userForm']['status']['control'];?>
</td>
    </tr>
<?php }?>
<?php if ($_smarty_tpl->getVariable('user')->value->id==$_smarty_tpl->getVariable('user_id')->value){?>
      <tr>
      <td align="right"><?php echo $_smarty_tpl->getVariable('i18n')->value['form']['users']['role'];?>
:</td>
      <td><?php echo $_smarty_tpl->getVariable('user')->value->role_name;?>
 <?php if ($_smarty_tpl->getVariable('can_swap')->value){?><a href="swap_roles.php"><?php echo $_smarty_tpl->getVariable('i18n')->value['form']['user_edit']['swap_roles'];?>
</a><?php }?></td>
    </tr>
<?php }?>
    <tr>
      <td align="right"><?php echo $_smarty_tpl->getVariable('i18n')->value['form']['users']['default_rate'];?>
&nbsp;(0<?php echo $_smarty_tpl->getVariable('user')->value->decimal_mark;?>
00):</td>
      <td><?php echo $_smarty_tpl->getVariable('forms')->value['userForm']['rate']['control'];?>
</td>
    </tr>
<?php if ((@MODE_PROJECTS==$_smarty_tpl->getVariable('user')->value->tracking_mode||@MODE_PROJECTS_AND_TASKS==$_smarty_tpl->getVariable('user')->value->tracking_mode)){?>
    <tr valign="top">
      <td align="right"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['projects'];?>
:</td>
      <td><?php echo $_smarty_tpl->getVariable('forms')->value['userForm']['projects']['control'];?>
</td>
    </tr>
<?php }?>
    <tr>
      <td colspan="2" align="center"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['required_fields'];?>
</td>
    </tr>
    <tr>
      <td colspan="2" align="center" height="50"><?php echo $_smarty_tpl->getVariable('forms')->value['userForm']['btn_submit']['control'];?>
</td>
    </tr>
  </table>
</table>
<?php echo $_smarty_tpl->getVariable('forms')->value['userForm']['close'];?>
