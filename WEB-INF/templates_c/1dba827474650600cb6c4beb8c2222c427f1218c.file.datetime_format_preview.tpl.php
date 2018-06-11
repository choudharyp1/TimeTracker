<?php /* Smarty version Smarty-3.0.7, created on 2018-06-11 13:32:38
         compiled from "/var/www/html/anuko/WEB-INF/templates/datetime_format_preview.tpl" */ ?>
<?php /*%%SmartyHeaderCode:9912879785b1eb236829a33-07852230%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1dba827474650600cb6c4beb8c2222c427f1218c' => 
    array (
      0 => '/var/www/html/anuko/WEB-INF/templates/datetime_format_preview.tpl',
      1 => 1528730512,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '9912879785b1eb236829a33-07852230',
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
