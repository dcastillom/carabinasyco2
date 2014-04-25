<?php /* Smarty version Smarty-3.1.14, created on 2014-04-07 13:28:18
         compiled from "/home/carabina/public_html/modules/paypal/views/templates/admin/admin_order/refund.tpl" */ ?>
<?php /*%%SmartyHeaderCode:21163570753428bd25a1819-34791397%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '664d6ff232da732b326e74e86e48f8fbae76edc2' => 
    array (
      0 => '/home/carabina/public_html/modules/paypal/views/templates/admin/admin_order/refund.tpl',
      1 => 1396362924,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '21163570753428bd25a1819-34791397',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'ps_version' => 0,
    'base_url' => 0,
    'module_name' => 0,
    'params' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_53428bd26a5885_69847576',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_53428bd26a5885_69847576')) {function content_53428bd26a5885_69847576($_smarty_tpl) {?>

<br />
<fieldset <?php if (isset($_smarty_tpl->tpl_vars['ps_version']->value)&&($_smarty_tpl->tpl_vars['ps_version']->value<'1.5')){?>style="width: 400px"<?php }?>>
	<legend><img src="<?php echo $_smarty_tpl->tpl_vars['base_url']->value;?>
modules/<?php echo $_smarty_tpl->tpl_vars['module_name']->value;?>
/logo.gif" alt="" /><?php echo smartyTranslate(array('s'=>'PayPal Refund','mod'=>'paypal'),$_smarty_tpl);?>
</legend>
	<p><b><?php echo smartyTranslate(array('s'=>'Information:','mod'=>'paypal'),$_smarty_tpl);?>
</b> <?php echo smartyTranslate(array('s'=>'Payment accepted','mod'=>'paypal'),$_smarty_tpl);?>
</p>
	<p><b><?php echo smartyTranslate(array('s'=>'Information:','mod'=>'paypal'),$_smarty_tpl);?>
</b> <?php echo smartyTranslate(array('s'=>'When you refund a product, a partial refund is made unless you select "Generate a voucher".','mod'=>'paypal'),$_smarty_tpl);?>
</p>
	<form method="post" action="<?php echo mb_convert_encoding(htmlspecialchars($_SERVER['REQUEST_URI'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
">
		<input type="hidden" name="id_order" value="<?php echo intval($_smarty_tpl->tpl_vars['params']->value['id_order']);?>
" />
		<p class="center">
			<input type="submit" class="button" name="submitPayPalRefund" value="<?php echo smartyTranslate(array('s'=>'Refund total transaction','mod'=>'paypal'),$_smarty_tpl);?>
" onclick="if (!confirm('<?php echo smartyTranslate(array('s'=>'Are you sure?','mod'=>'paypal'),$_smarty_tpl);?>
'))return false;" />
		</p>
	</form>
</fieldset>
<?php }} ?>