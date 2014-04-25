<?php /* Smarty version Smarty-3.1.14, created on 2014-04-08 20:09:23
         compiled from "/home/carabina/public_html/admin123/themes/default/template/controllers/stats/calendar.tpl" */ ?>
<?php /*%%SmartyHeaderCode:156255619553443b53eb2922-11482356%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '07f14f29aee2ba469a04f38da9d852eec791ae13' => 
    array (
      0 => '/home/carabina/public_html/admin123/themes/default/template/controllers/stats/calendar.tpl',
      1 => 1395073064,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '156255619553443b53eb2922-11482356',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_53443b53eb9738_38851428',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_53443b53eb9738_38851428')) {function content_53443b53eb9738_38851428($_smarty_tpl) {?>

<div id="statsContainer" class="col-lg-9">
	<?php echo $_smarty_tpl->getSubTemplate ("../../form_date_range_picker.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>