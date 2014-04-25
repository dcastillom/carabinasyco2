<?php /* Smarty version Smarty-3.1.14, created on 2014-03-31 13:06:20
         compiled from "/home/carabina/public_html/admin123/themes/default/template/helpers/list/list_action_edit.tpl" */ ?>
<?php /*%%SmartyHeaderCode:143857234953394c2cbe1971-96566991%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '41a3beb47b50e18c99d2fa11b97dadfd70d4d5f8' => 
    array (
      0 => '/home/carabina/public_html/admin123/themes/default/template/helpers/list/list_action_edit.tpl',
      1 => 1395073064,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '143857234953394c2cbe1971-96566991',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'href' => 0,
    'action' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_53394c2cbf3f46_83439755',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_53394c2cbf3f46_83439755')) {function content_53394c2cbf3f46_83439755($_smarty_tpl) {?>
<a href="<?php echo $_smarty_tpl->tpl_vars['href']->value;?>
" title="<?php echo $_smarty_tpl->tpl_vars['action']->value;?>
" class="edit">
	<i class="icon-pencil"></i> <?php echo $_smarty_tpl->tpl_vars['action']->value;?>

</a><?php }} ?>