<?php /* Smarty version Smarty-3.0.7, created on 2018-05-22 17:53:29
         compiled from "C:\xampp\htdocs\timetracker/WEB-INF/templates\time.tpl" */ ?>
<?php /*%%SmartyHeaderCode:309725b043cf9147768-65367621%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f0ad405aa1bee69b122aeb263e42182443a7988c' => 
    array (
      0 => 'C:\\xampp\\htdocs\\timetracker/WEB-INF/templates\\time.tpl',
      1 => 1517679596,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '309725b043cf9147768-65367621',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_escape')) include 'C:\xampp\htdocs\timetracker\WEB-INF\lib\smarty\plugins\modifier.escape.php';
if (!is_callable('smarty_function_cycle')) include 'C:\xampp\htdocs\timetracker\WEB-INF\lib\smarty\plugins\function.cycle.php';
?><?php $_template = new Smarty_Internal_Template("time_script.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>

<style>
.not_billable td {
  color: #ff6666;
}
</style>

<?php echo $_smarty_tpl->getVariable('forms')->value['timeRecordForm']['open'];?>

<table cellspacing="4" cellpadding="0" border="0">
<?php if ($_smarty_tpl->getVariable('user')->value->isPluginEnabled('wv')){?>
  <tr>
    <td align="center" colspan=2">
      <a href="time.php?date=<?php echo $_smarty_tpl->getVariable('selected_date')->value->toString();?>
"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['day_view'];?>
</a>&nbsp;/&nbsp;<a href="week.php?date=<?php echo $_smarty_tpl->getVariable('selected_date')->value->toString();?>
"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['week_view'];?>
</a>
    </td>
  </tr>
<?php }?>
  <tr>
    <td valign="top">
      <table>
<?php if ($_smarty_tpl->getVariable('on_behalf_control')->value){?>
        <tr>
          <td align="right"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['user'];?>
:</td>
          <td><?php echo $_smarty_tpl->getVariable('forms')->value['timeRecordForm']['onBehalfUser']['control'];?>
</td>
        </tr>
<?php }?>
<?php if ($_smarty_tpl->getVariable('user')->value->isPluginEnabled('cl')){?>
        <tr>
          <td align="right"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['client'];?>
<?php if ($_smarty_tpl->getVariable('user')->value->isPluginEnabled('cm')){?> (*)<?php }?>:</td>
          <td><?php echo $_smarty_tpl->getVariable('forms')->value['timeRecordForm']['client']['control'];?>
</td>
        </tr>
<?php }?>
<?php if ($_smarty_tpl->getVariable('user')->value->isPluginEnabled('iv')){?>
        <tr>
          <td align="right">&nbsp;</td>
          <td><label><?php echo $_smarty_tpl->getVariable('forms')->value['timeRecordForm']['billable']['control'];?>
<?php echo $_smarty_tpl->getVariable('i18n')->value['form']['time']['billable'];?>
</label></td>
        </tr>
<?php }?>
<?php if (($_smarty_tpl->getVariable('custom_fields')->value&&$_smarty_tpl->getVariable('custom_fields')->value->fields[0])){?>
        <tr>
          <td align="right"><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('custom_fields')->value->fields[0]['label']);?>
<?php if ($_smarty_tpl->getVariable('custom_fields')->value->fields[0]['required']){?> (*)<?php }?>:</td><td><?php echo $_smarty_tpl->getVariable('forms')->value['timeRecordForm']['cf_1']['control'];?>
</td>
        </tr>
<?php }?>
<?php if ((@MODE_PROJECTS==$_smarty_tpl->getVariable('user')->value->tracking_mode||@MODE_PROJECTS_AND_TASKS==$_smarty_tpl->getVariable('user')->value->tracking_mode)){?>
        <tr>
          <td align="right"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['project'];?>
 (*):</td>
          <td><?php echo $_smarty_tpl->getVariable('forms')->value['timeRecordForm']['project']['control'];?>
</td>
        </tr>
<?php }?>
<?php if ((@MODE_PROJECTS_AND_TASKS==$_smarty_tpl->getVariable('user')->value->tracking_mode)){?>
        <tr>
          <td align="right"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['task'];?>
<?php if ($_smarty_tpl->getVariable('user')->value->task_required){?> (*)<?php }?>:</td>
          <td><?php echo $_smarty_tpl->getVariable('forms')->value['timeRecordForm']['task']['control'];?>
</td>
        </tr>
<?php }?>
<?php if (((@TYPE_START_FINISH==$_smarty_tpl->getVariable('user')->value->record_type)||(@TYPE_ALL==$_smarty_tpl->getVariable('user')->value->record_type))){?>
        <tr>
          <td align="right"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['start'];?>
:</td>
          <td><?php echo $_smarty_tpl->getVariable('forms')->value['timeRecordForm']['start']['control'];?>
&nbsp;<input onclick="setNow('start');" type="button" tabindex="-1" value="<?php echo $_smarty_tpl->getVariable('i18n')->value['button']['now'];?>
"></td>
        </tr>
        <tr>
          <td align="right"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['finish'];?>
:</td>
          <td><?php echo $_smarty_tpl->getVariable('forms')->value['timeRecordForm']['finish']['control'];?>
&nbsp;<input onclick="setNow('finish');" type="button" tabindex="-1" value="<?php echo $_smarty_tpl->getVariable('i18n')->value['button']['now'];?>
"></td>
        </tr>
<?php }?>
<?php if (((@TYPE_DURATION==$_smarty_tpl->getVariable('user')->value->record_type)||(@TYPE_ALL==$_smarty_tpl->getVariable('user')->value->record_type))){?>
        <tr>
          <td align="right"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['duration'];?>
:</td>
          <td><?php echo $_smarty_tpl->getVariable('forms')->value['timeRecordForm']['duration']['control'];?>
&nbsp;<?php if ($_smarty_tpl->getVariable('user')->value->decimal_mark==','){?><?php echo str_replace('.',',',$_smarty_tpl->getVariable('i18n')->value['form']['time']['duration_format']);?>
<?php }else{ ?><?php echo $_smarty_tpl->getVariable('i18n')->value['form']['time']['duration_format'];?>
<?php }?></td>
        </tr>
<?php }?>
      </table>
    </td>
    <td valign="top">
      <table>
        <tr><td><?php echo $_smarty_tpl->getVariable('forms')->value['timeRecordForm']['date']['control'];?>
</td></tr>
      </table>
    </td>
  </tr>
</table>

<table>
  <tr>
    <td align="right"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['note'];?>
:</td>
    <td align="left"><?php echo $_smarty_tpl->getVariable('forms')->value['timeRecordForm']['note']['control'];?>
</td>
  </tr>
  <tr>
    <td align="center" colspan="2"><?php echo $_smarty_tpl->getVariable('forms')->value['timeRecordForm']['btn_submit']['control'];?>
</td>
  </tr>
</table>

<table width="720">
<tr>
  <td valign="top">
<?php if ($_smarty_tpl->getVariable('time_records')->value){?>
      <table border="0" cellpadding="3" cellspacing="1" width="100%">
      <tr>
  <?php if ($_smarty_tpl->getVariable('user')->value->isPluginEnabled('cl')){?>
        <td width="20%" class="tableHeader"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['client'];?>
</td>
  <?php }?>
  <?php if ((@MODE_PROJECTS==$_smarty_tpl->getVariable('user')->value->tracking_mode||@MODE_PROJECTS_AND_TASKS==$_smarty_tpl->getVariable('user')->value->tracking_mode)){?>
        <td class="tableHeader"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['project'];?>
</td>
  <?php }?>
  <?php if ((@MODE_PROJECTS_AND_TASKS==$_smarty_tpl->getVariable('user')->value->tracking_mode)){?>
        <td class="tableHeader"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['task'];?>
</td>
  <?php }?>
  <?php if (((@TYPE_START_FINISH==$_smarty_tpl->getVariable('user')->value->record_type)||(@TYPE_ALL==$_smarty_tpl->getVariable('user')->value->record_type))){?>
        <td width="5%" class="tableHeader" align="right"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['start'];?>
</td>
        <td width="5%" class="tableHeader" align="right"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['finish'];?>
</td>
  <?php }?>
        <td width="5%" class="tableHeader"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['duration'];?>
</td>
        <td class="tableHeader"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['note'];?>
</td>
        <td width="5%" class="tableHeader"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['edit'];?>
</td>
      </tr>
  <?php  $_smarty_tpl->tpl_vars['record'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('time_records')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['record']->key => $_smarty_tpl->tpl_vars['record']->value){
?>
      <tr bgcolor="<?php echo smarty_function_cycle(array('values'=>"#f5f5f5,#ffffff"),$_smarty_tpl);?>
" <?php if (!$_smarty_tpl->tpl_vars['record']->value['billable']){?> class="not_billable" <?php }?>>
    <?php if ($_smarty_tpl->getVariable('user')->value->isPluginEnabled('cl')){?>
        <td valign="top"><?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['record']->value['client']);?>
</td>
    <?php }?>
    <?php if ((@MODE_PROJECTS==$_smarty_tpl->getVariable('user')->value->tracking_mode||@MODE_PROJECTS_AND_TASKS==$_smarty_tpl->getVariable('user')->value->tracking_mode)){?>
        <td valign="top"><?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['record']->value['project']);?>
</td>
    <?php }?>
    <?php if ((@MODE_PROJECTS_AND_TASKS==$_smarty_tpl->getVariable('user')->value->tracking_mode)){?>
        <td valign="top"><?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['record']->value['task']);?>
</td>
    <?php }?>
    <?php if (((@TYPE_START_FINISH==$_smarty_tpl->getVariable('user')->value->record_type)||(@TYPE_ALL==$_smarty_tpl->getVariable('user')->value->record_type))){?>
        <td nowrap align="right" valign="top"><?php if ($_smarty_tpl->tpl_vars['record']->value['start']){?><?php echo $_smarty_tpl->tpl_vars['record']->value['start'];?>
<?php }else{ ?>&nbsp;<?php }?></td>
        <td nowrap align="right" valign="top"><?php if ($_smarty_tpl->tpl_vars['record']->value['finish']){?><?php echo $_smarty_tpl->tpl_vars['record']->value['finish'];?>
<?php }else{ ?>&nbsp;<?php }?></td>
    <?php }?>
        <td align="right" valign="top"><?php if (($_smarty_tpl->tpl_vars['record']->value['duration']=='0:00'&&$_smarty_tpl->tpl_vars['record']->value['start']!='')){?><font color="#ff0000"><?php echo $_smarty_tpl->getVariable('i18n')->value['form']['time']['uncompleted'];?>
</font><?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['record']->value['duration'];?>
<?php }?></td>
        <td valign="top"><?php if ($_smarty_tpl->tpl_vars['record']->value['comment']){?><?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['record']->value['comment']);?>
<?php }else{ ?>&nbsp;<?php }?></td>
        <td valign="top" align="center">
    <?php if ($_smarty_tpl->tpl_vars['record']->value['invoice_id']){?>
          &nbsp;
    <?php }else{ ?>
          <a href="time_edit.php?id=<?php echo $_smarty_tpl->tpl_vars['record']->value['id'];?>
"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['edit'];?>
</a>
      <?php if (($_smarty_tpl->tpl_vars['record']->value['duration']=='0:00'&&$_smarty_tpl->tpl_vars['record']->value['start']!='')){?>
          <input type="hidden" name="record_id" value="<?php echo $_smarty_tpl->tpl_vars['record']->value['id'];?>
">
          <input type="hidden" name="browser_date" value="">
          <input type="hidden" name="browser_time" value="">
          <input type="submit" id="btn_stop" name="btn_stop" onclick="browser_date.value=get_date();browser_time.value=get_time()" value="<?php echo $_smarty_tpl->getVariable('i18n')->value['button']['stop'];?>
">
      <?php }?>
    <?php }?>
        </td>
      </tr>
  <?php }} ?>
    </table>
<?php }?>
  </td>
</tr>
</table>
<?php if ($_smarty_tpl->getVariable('time_records')->value){?>
<table cellpadding="3" cellspacing="1" width="720">
  <tr>
    <td align="left"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['week_total'];?>
: <?php echo $_smarty_tpl->getVariable('week_total')->value;?>
</td>
    <td align="right"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['day_total'];?>
: <?php echo $_smarty_tpl->getVariable('day_total')->value;?>
</td>
  </tr>
  <?php if ($_smarty_tpl->getVariable('user')->value->isPluginEnabled('mq')){?>
  <tr>
    <td align="left"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['month_total'];?>
: <?php echo $_smarty_tpl->getVariable('month_total')->value;?>
</td>
    <?php if ($_smarty_tpl->getVariable('over_quota')->value){?>
    <td align="right"><?php echo $_smarty_tpl->getVariable('i18n')->value['form']['time']['over_quota'];?>
: <span style="color: green;"><?php echo $_smarty_tpl->getVariable('quota_remaining')->value;?>
</span></td>
    <?php }else{ ?>
    <td align="right"><?php echo $_smarty_tpl->getVariable('i18n')->value['form']['time']['remaining_quota'];?>
: <span style="color: red;"><?php echo $_smarty_tpl->getVariable('quota_remaining')->value;?>
</span></td>
    <?php }?>
  </tr>
  <?php }?>
</table>
<?php }?>
<?php echo $_smarty_tpl->getVariable('forms')->value['timeRecordForm']['close'];?>

