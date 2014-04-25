<?php /* Smarty version Smarty-3.1.14, created on 2014-04-08 11:44:05
         compiled from "/home/carabina/public_html/modules/blockcategories/views/blockcategories_admin.tpl" */ ?>
<?php /*%%SmartyHeaderCode:5818012065343c4e579ade3-67315823%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '879a0562f817c5e2475d2f0d936e7e3a5eb44d91' => 
    array (
      0 => '/home/carabina/public_html/modules/blockcategories/views/blockcategories_admin.tpl',
      1 => 1395107266,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '5818012065343c4e579ade3-67315823',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'helper' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_5343c4e57d6240_65405880',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5343c4e57d6240_65405880')) {function content_5343c4e57d6240_65405880($_smarty_tpl) {?><div class="form-group">
	<label class="control-label col-lg-3">
		<span class="label-tooltip" data-toggle="tooltip" data-html="true" title="" data-original-title="<?php echo smartyTranslate(array('s'=>'You can upload a maximum of 3 images.','mod'=>'blockcategories'),$_smarty_tpl);?>
">
			<?php echo smartyTranslate(array('s'=>'Thumbnails','mod'=>'blockcategories'),$_smarty_tpl);?>

		</span>
	</label>
	<div class="col-lg-4">
		<?php echo $_smarty_tpl->tpl_vars['helper']->value;?>

	</div>
</div><?php }} ?>