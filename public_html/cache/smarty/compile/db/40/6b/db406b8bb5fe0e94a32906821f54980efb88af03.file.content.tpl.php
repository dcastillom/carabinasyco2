<?php /* Smarty version Smarty-3.1.14, created on 2014-03-31 13:05:58
         compiled from "/home/carabina/public_html/admin123/themes/default/template/content.tpl" */ ?>
<?php /*%%SmartyHeaderCode:63345504153394c16d31d97-59638279%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'db406b8bb5fe0e94a32906821f54980efb88af03' => 
    array (
      0 => '/home/carabina/public_html/admin123/themes/default/template/content.tpl',
      1 => 1395073064,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '63345504153394c16d31d97-59638279',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'content' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_53394c16d45a89_82965972',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_53394c16d45a89_82965972')) {function content_53394c16d45a89_82965972($_smarty_tpl) {?>
<div id="ajax_confirmation" class="alert alert-success hide"></div>

<div id="ajaxBox" style="display:none"></div>

<?php if (isset($_smarty_tpl->tpl_vars['content']->value)){?>
	<?php echo $_smarty_tpl->tpl_vars['content']->value;?>

<?php }?>
<?php }} ?>