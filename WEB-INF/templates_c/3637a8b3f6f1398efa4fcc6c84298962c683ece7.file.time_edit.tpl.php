<?php /* Smarty version Smarty-3.0.7, created on 2018-05-28 18:47:06
         compiled from "C:\xampp\htdocs\timetracker/WEB-INF/templates\time_edit.tpl" */ ?>
<?php /*%%SmartyHeaderCode:72635b0c328a61cfd4-68899870%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3637a8b3f6f1398efa4fcc6c84298962c683ece7' => 
    array (
      0 => 'C:\\xampp\\htdocs\\timetracker/WEB-INF/templates\\time_edit.tpl',
      1 => 1523683194,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '72635b0c328a61cfd4-68899870',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_escape')) include 'C:\xampp\htdocs\timetracker\WEB-INF\lib\smarty\plugins\modifier.escape.php';
?><?php $_template = new Smarty_Internal_Template("time_script.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>

<?php echo $_smarty_tpl->getVariable('forms')->value['timeRecordForm']['open'];?>

<table cellspacing="4" cellpadding="7" border="0">
<tr>
  <td>
  <table width = "100%">
  <tr>
    <td valign="top">
    <table border="0">
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
<?php if (($_smarty_tpl->getVariable('user')->value->can('manage_invoices')&&$_smarty_tpl->getVariable('user')->value->isPluginEnabled('ps'))){?>
    <tr>
      <td align="right">&nbsp;</td>
      <td><label><?php echo $_smarty_tpl->getVariable('forms')->value['timeRecordForm']['paid']['control'];?>
<?php echo $_smarty_tpl->getVariable('i18n')->value['label']['paid'];?>
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
    <tr>
      <td align="right"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['date'];?>
:</td>
      <td><?php echo $_smarty_tpl->getVariable('forms')->value['timeRecordForm']['date']['control'];?>
</td>
    </tr>
    <tr>
      <td align="right"><?php echo $_smarty_tpl->getVariable('i18n')->value['label']['note'];?>
:</td>
      <td><?php echo $_smarty_tpl->getVariable('forms')->value['timeRecordForm']['note']['control'];?>
</td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td></td>
      <td align="left"><?php echo $_smarty_tpl->getVariable('forms')->value['timeRecordForm']['btn_save']['control'];?>
 <?php echo $_smarty_tpl->getVariable('forms')->value['timeRecordForm']['btn_copy']['control'];?>
 <?php echo $_smarty_tpl->getVariable('forms')->value['timeRecordForm']['btn_delete']['control'];?>
</td>
    </tr>
    </table>
    </td>
    </tr>
  </table>
  </td>
  </tr>
</table>
<?php echo $_smarty_tpl->getVariable('forms')->value['timeRecordForm']['close'];?>

