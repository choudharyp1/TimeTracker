<?php /* Smarty version Smarty-3.0.7, created on 2018-05-23 19:05:09
         compiled from "C:\xampp\htdocs\timetracker/WEB-INF/templates\datetime_format_preview.tpl" */ ?>
<?php /*%%SmartyHeaderCode:159795b059f458a77f8-86578870%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd3eecf0d0b88c09079ab6e3d1e40fea1df0eb189' => 
    array (
      0 => 'C:\\xampp\\htdocs\\timetracker/WEB-INF/templates\\datetime_format_preview.tpl',
      1 => 1516250162,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '159795b059f458a77f8-86578870',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<script>
function MakeFormatPreview(id, selectElement)
{
  var dst = document.getElementById(id);
  if (dst) {
    var date = new Date();
    date.locale = "<?php echo $_smarty_tpl->getVariable('user')->value->lang;?>
";
    var format;
    if (selectElement.value != "") {
      format = selectElement.value;
    } else {
      format = selectElement.options[0].text;
    }
    dst.innerHTML = "<i>" + date.strftime(format) + "</i>";
  }
}
</script>
