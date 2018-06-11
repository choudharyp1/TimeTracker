<?php /* Smarty version Smarty-3.0.7, created on 2018-06-11 11:55:10
         compiled from "/var/www/html/anuko/WEB-INF/templates/login.tpl" */ ?>
<?php /*%%SmartyHeaderCode:20449387845b1e9b5edd2ff8-15761143%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9eb5069ca8775b6fd69452ec13677885046594db' => 
    array (
      0 => '/var/www/html/anuko/WEB-INF/templates/login.tpl',
      1 => 1528730512,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '20449387845b1e9b5edd2ff8-15761143',
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

<?php if (!empty($_smarty_tpl->getVariable('about_text',null,true,false)->value)){?>
  <div id="LoginAboutText"> <?php echo $_smarty_tpl->getVariable('about_text')->value;?>
 </div>
<?php }?>
