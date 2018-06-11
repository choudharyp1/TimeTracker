<?php /* Smarty version Smarty-3.0.7, created on 2018-06-11 13:32:38
         compiled from "/var/www/html/anuko/WEB-INF/templates/group_edit.tpl" */ ?>
<?php /*%%SmartyHeaderCode:20057124215b1eb2364eaba5-79844486%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '027571047577f019f78eb11f1e3dbd4a1826a711' => 
    array (
      0 => '/var/www/html/anuko/WEB-INF/templates/group_edit.tpl',
      1 => 1528730512,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '20057124215b1eb2364eaba5-79844486',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<script>
function chLocation(newLocation) { document.location = newLocation; }

// handleTaskRequiredCheckbox - controls visibility of the Task Required checkbox.
function handleTaskRequiredCheckbox() {
  var taskRequiredCheckbox = document.getElementById("task_required");
  var taskRequiredLabel = document.getElementById("task_required_label");
  var trackingModeDropdown = document.getElementById("tracking_mode");
  if (trackingModeDropdown.value == 2) {
    taskRequiredCheckbox.style.visibility = "visible";
    taskRequiredLabel.style.visibility = "visible";
  } else {
    taskRequiredCheckbox.style.visibility = "hidden";
    taskRequiredLabel.style.visibility = "hidden";
  }
}


// handleControls - controls visibility of controls.
function handlePluginCheckboxes() {
  var clientsCheckbox = document.getElementById("clients");
  var invoicesCheckbox = document.getElementById("invoices");
  var requiredCheckbox = document.getElementById("client_required");
  var requiredLabel = document.getElementById("client_required_label");
  if (clientsCheckbox.checked) {
    requiredCheckbox.style.visibility = "visible";
    requiredLabel.style.visibility = "visible";
    invoicesCheckbox.disabled = false;
  } else {
    requiredCheckbox.checked = false;
    requiredCheckbox.style.visibility = "hidden";
    requiredLabel.style.visibility = "hidden";
    invoicesCheckbox.checked = false;
    invoicesCheckbox.disabled = true;
  }

  var expensesCheckbox = document.getElementById("expenses");
  var taxCheckbox = document.getElementById("tax_expenses");
  var taxLabel = document.getElementById("tax_label");
  if (expensesCheckbox.checked) {
    taxCheckbox.style.visibility = "visible";
    taxLabel.style.visibility = "visible";
  } else {
    taxCheckbox.checked = false;
    taxCheckbox.style.visibility = "hidden";
    taxLabel.style.visibility = "hidden";
  }
  var configureLabel = document.getElementById("expenses_config");
  if (expensesCheckbox.checked) {
    configureLabel.style.visibility = "visible";
  } else {
    configureLabel.style.visibility = "hidden";
  }

  var customFieldsCheckbox = document.getElementById("custom_fields");
  configureLabel = document.getElementById("cf_config");
  if (customFieldsCheckbox.checked) {
    configureLabel.style.visibility = "visible";
  } else {
    configureLabel.style.visibility = "hidden";
  }

  var notificationsCheckbox = document.getElementById("notifications");
  configureLabel = document.getElementById("notifications_config");
  if (notificationsCheckbox.checked) {
    configureLabel.style.visibility = "visible";
  } else {
    configureLabel.style.visibility = "hidden";
  }

  var lockingCheckbox = document.getElementById("locking");
  configureLabel = document.getElementById("locking_config");
  if (lockingCheckbox.checked) {
    configureLabel.style.visibility = "visible";
  } else {
    configureLabel.style.visibility = "hidden";
  }

  var quotasCheckbox = document.getElementById("quotas");
  configureLabel = document.getElementById("quotas_config");
  if (quotasCheckbox.checked){
    configureLabel.style.visibility = "visible";
  } else {
    configureLabel.style.visibility = "hidden";
  }

  var weekViewCheckbox = document.getElementById("week_view");
  configureLabel = document.getElementById("week_view_config");
  if (weekViewCheckbox.checked){
    configureLabel.style.visibility = "visible";
  } else {
    configureLabel.style.visibility = "hidden";
  }
}
</script>

<?php echo $_smarty_tpl->getVariable('forms')->value['groupForm']['open'];?>


<?php if ($_smarty_tpl->getVariable('user')->value->can('manage_basic_settings')){?>
<?php $_template = new Smarty_Internal_Template("datetime_format_preview.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
<?php }?>

<table cellspacing="4" cellpadding="7" border="0">
    <tr>
      <td>
        <table cellspacing="1" cellpadding="2" border="0">
<?php if ($_smarty_tpl->getVariable('user')->value->can('manage_basic_settings')){?>
          <tr>
            <td align="right" nowrap><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['group_name'];?>
:</td>
            <td><?php echo $_smarty_tpl->getVariable('forms')->value['groupForm']['group_name']['control'];?>
</td>
          </tr>
          <tr>
            <td align="right"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['currency'];?>
:</td>
            <td><?php echo $_smarty_tpl->getVariable('forms')->value['groupForm']['currency']['control'];?>
</td>
          </tr>
  <?php if ($_smarty_tpl->getVariable('user')->value->can('manage_roles')){?>
          <tr>
            <td align="right" nowrap><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['roles'];?>
:</td>
            <td><a href="roles.php"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['configure'];?>
</a></td>
          </tr>
  <?php }?>
          <tr>
           <td align="right" nowrap><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['language'];?>
:</td>
           <td><?php echo $_smarty_tpl->getVariable('forms')->value['groupForm']['lang']['control'];?>
</td>
          </tr>
          <tr>
            <td align="right"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['decimal_mark'];?>
:</td>
            <td><?php echo $_smarty_tpl->getVariable('forms')->value['groupForm']['decimal_mark']['control'];?>
 <font id="decimal_preview" color="#777777">&nbsp;</font></td>
          <tr>
            <td align="right" nowrap><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['date_format'];?>
:</td>
            <td><?php echo $_smarty_tpl->getVariable('forms')->value['groupForm']['date_format']['control'];?>
 <font id="date_format_preview" color="#777777">&nbsp;</font></td>
          </tr>
          <tr>
            <td align="right" nowrap><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['time_format'];?>
:</td>
            <td><?php echo $_smarty_tpl->getVariable('forms')->value['groupForm']['time_format']['control'];?>
 <font id="time_format_preview" color="#777777">&nbsp;</font></td>
          </tr>
          <tr>
            <td align="right" nowrap><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['week_start'];?>
:</td>
            <td><?php echo $_smarty_tpl->getVariable('forms')->value['groupForm']['start_week']['control'];?>
</td>
          </tr>
          <tr>
            <td align="right" nowrap><?php echo $_smarty_tpl->getVariable('i18n')->value['form']['group_edit']['show_holidays'];?>
:</td>
            <td><?php echo $_smarty_tpl->getVariable('forms')->value['groupForm']['show_holidays']['control'];?>
 <a href="https://www.anuko.com/lp/tt_14.htm" target="_blank"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['what_is_it'];?>
</a></td>
          </tr>
          <tr>
            <td align="right" nowrap><?php echo $_smarty_tpl->getVariable('i18n')->value['form']['group_edit']['tracking_mode'];?>
:</td>
            <td><?php echo $_smarty_tpl->getVariable('forms')->value['groupForm']['tracking_mode']['control'];?>
 <?php echo $_smarty_tpl->getVariable('forms')->value['groupForm']['task_required']['control'];?>
 <span id="task_required_label"><label for="task_required"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['required'];?>
</label></span></td>
          </tr>
          <tr>
            <td align="right" nowrap><?php echo $_smarty_tpl->getVariable('i18n')->value['form']['group_edit']['record_type'];?>
:</td>
            <td><?php echo $_smarty_tpl->getVariable('forms')->value['groupForm']['record_type']['control'];?>
</td>
          </tr>
          <tr>
            <td align="right" nowrap><?php echo $_smarty_tpl->getVariable('i18n')->value['form']['group_edit']['punch_mode'];?>
:</td>
            <td><?php echo $_smarty_tpl->getVariable('forms')->value['groupForm']['punch_mode']['control'];?>
 <a href="https://www.anuko.com/lp/tt_18.htm" target="_blank"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['what_is_it'];?>
</a></td>
          </tr>
          <tr>
            <td align="right" nowrap><?php echo $_smarty_tpl->getVariable('i18n')->value['form']['group_edit']['allow_overlap'];?>
:</td>
            <td><?php echo $_smarty_tpl->getVariable('forms')->value['groupForm']['allow_overlap']['control'];?>
 <a href="https://www.anuko.com/lp/tt_16.htm" target="_blank"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['what_is_it'];?>
</a></td>
          </tr>
          <tr>
            <td align="right" nowrap><?php echo $_smarty_tpl->getVariable('i18n')->value['form']['group_edit']['future_entries'];?>
:</td>
            <td><?php echo $_smarty_tpl->getVariable('forms')->value['groupForm']['future_entries']['control'];?>
 <a href="https://www.anuko.com/lp/tt_17.htm" target="_blank"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['what_is_it'];?>
</a></td>
          </tr>
          <tr>
            <td align="right" nowrap><?php echo $_smarty_tpl->getVariable('i18n')->value['form']['group_edit']['uncompleted_indicators'];?>
:</td>
            <td><?php echo $_smarty_tpl->getVariable('forms')->value['groupForm']['uncompleted_indicators']['control'];?>
 <a href="https://www.anuko.com/lp/tt_15.htm" target="_blank"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['what_is_it'];?>
</a></td>
          </tr>
  <?php if ($_smarty_tpl->getVariable('user')->value->can('manage_advanced_settings')){?>
          <tr>
            <td align="right" nowrap><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['bcc'];?>
:</td>
            <td><?php echo $_smarty_tpl->getVariable('forms')->value['groupForm']['bcc_email']['control'];?>
 <a href="https://www.anuko.com/lp/tt_10.htm" target="_blank"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['what_is_it'];?>
</a></td>
          </tr>
          <tr>
            <td align="right" nowrap><?php echo $_smarty_tpl->getVariable('i18n')->value['form']['group_edit']['allow_ip'];?>
:</td>
            <td><?php echo $_smarty_tpl->getVariable('forms')->value['groupForm']['allow_ip']['control'];?>
 <a href="https://www.anuko.com/lp/tt_21.htm" target="_blank"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['what_is_it'];?>
</a></td>
          </tr>
  <?php }?>
          <script>
            MakeFormatPreview("date_format_preview", document.getElementById("date_format"));
            MakeFormatPreview("time_format_preview", document.getElementById("time_format"));

            function adjustDecimalPreview()
            {
              var mark = document.getElementById("decimal_mark").value;
              var example = document.getElementById("decimal_preview");
              example.innerHTML = "<i>3"+mark+"14</i>";
            }
            adjustDecimalPreview();
          </script>

          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>

          <tr>
             <td colspan="2" class="sectionHeader"><?php echo $_smarty_tpl->getVariable('i18n')->value['form']['group_edit']['plugins'];?>
</td>
          </tr>
          <tr><td>&nbsp;</td></tr>
          <tr>
            <td align="right" nowrap><?php echo $_smarty_tpl->getVariable('forms')->value['groupForm']['charts']['control'];?>
</td>
            <td><label for="charts"><?php echo $_smarty_tpl->getVariable('i18n')->value['title']['charts'];?>
</label></td>
          </tr>
          <tr>
            <td align="right" nowrap><?php echo $_smarty_tpl->getVariable('forms')->value['groupForm']['clients']['control'];?>
</td>
            <td><label for="clients"><?php echo $_smarty_tpl->getVariable('i18n')->value['title']['clients'];?>
</label> <?php echo $_smarty_tpl->getVariable('forms')->value['profileForm']['client_required']['control'];?>
 <span id="client_required_label"><label for="client_required"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['required'];?>
</label></span></td>
          </tr>
          <tr>
            <td align="right" nowrap><?php echo $_smarty_tpl->getVariable('forms')->value['groupForm']['invoices']['control'];?>
</td>
            <td><label for="invoices"><?php echo $_smarty_tpl->getVariable('i18n')->value['title']['invoices'];?>
</label></td>
          </tr>
          <tr>
            <td align="right" nowrap><?php echo $_smarty_tpl->getVariable('forms')->value['groupForm']['paid_status']['control'];?>
</td>
            <td><label for="paid_status"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['paid_status'];?>
</label></td>
          </tr>
          <tr>
            <td align="right" nowrap><?php echo $_smarty_tpl->getVariable('forms')->value['groupForm']['custom_fields']['control'];?>
</td>
            <td><label for="custom_fields"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['custom_fields'];?>
</label> <span id="cf_config"><a href="cf_custom_fields.php"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['configure'];?>
</a></span></td>
          </tr>
          <tr>
            <td align="right" nowrap><?php echo $_smarty_tpl->getVariable('forms')->value['groupForm']['expenses']['control'];?>
</td>
            <td><label for="expenses"><?php echo $_smarty_tpl->getVariable('i18n')->value['title']['expenses'];?>
</label> <?php echo $_smarty_tpl->getVariable('forms')->value['profileForm']['tax_expenses']['control'];?>
 <span id="tax_label"><label for="tax_expenses"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['tax'];?>
</label></span> <span id="expenses_config"><a href="predefined_expenses.php"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['configure'];?>
</a></span></td>
          </tr>
          <tr>
            <td align="right" nowrap><?php echo $_smarty_tpl->getVariable('forms')->value['groupForm']['notifications']['control'];?>
</td>
            <td><label for="notifications"><?php echo $_smarty_tpl->getVariable('i18n')->value['title']['notifications'];?>
</label> <span id="notifications_config"><a href="notifications.php"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['configure'];?>
</a></span></td>
          </tr>
          <tr>
            <td align="right" nowrap><?php echo $_smarty_tpl->getVariable('forms')->value['groupForm']['locking']['control'];?>
</td>
            <td><label for="locking"><?php echo $_smarty_tpl->getVariable('i18n')->value['title']['locking'];?>
</label> <span id="locking_config"><a href="locking.php"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['configure'];?>
</a></span></td>
          </tr>
          <tr>
            <td align="right" nowrap><?php echo $_smarty_tpl->getVariable('forms')->value['groupForm']['quotas']['control'];?>
</td>
            <td><label for="quotas"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['monthly_quotas'];?>
</label> <span id="quotas_config"><a href="quotas.php"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['configure'];?>
</a></span></td>
          </tr>
          <tr>
            <td align="right" nowrap><?php echo $_smarty_tpl->getVariable('forms')->value['groupForm']['week_view']['control'];?>
</td>
            <td><label for="week_view"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['week_view'];?>
</label> <span id="week_view_config"><a href="week_view.php"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['configure'];?>
</a></span></td>
          </tr>
<?php }?>

          <tr>
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2" height="50" align="center"><?php echo $_smarty_tpl->getVariable('forms')->value['groupForm']['btn_save']['control'];?>
 <?php echo $_smarty_tpl->getVariable('forms')->value['groupForm']['btn_delete']['control'];?>
</td>
          </tr>
        </table>
      </td>
    </tr>
</table>
<?php echo $_smarty_tpl->getVariable('forms')->value['groupForm']['close'];?>

