<?php /* Smarty version Smarty-3.0.7, created on 2018-08-27 02:02:56
         compiled from "/Applications/XAMPP/xamppfiles/htdocs/timetracker/WEB-INF/templates/login.tpl" */ ?>
<?php /*%%SmartyHeaderCode:15403426565b833fb0a9c719-32611368%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ddccb9c70d8065eaa5b5952155d558aa730ab156' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/timetracker/WEB-INF/templates/login.tpl',
      1 => 1529636718,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '15403426565b833fb0a9c719-32611368',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<script>
<!--
function get_date() {
  var date = new Date();
  return date.strftime("%Y-%m-%d");
}
//-->
</script>
<table cellspacing="4" cellpadding="7" border="0">
  <tr>
    <td>
      <?php echo $_smarty_tpl->getVariable('forms')->value['loginForm']['open'];?>

      <?php $_template = new Smarty_Internal_Template("login.".(@AUTH_MODULE).".tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
      <?php echo $_smarty_tpl->getVariable('forms')->value['loginForm']['close'];?>

    </td>
  </tr>
</table>
