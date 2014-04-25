<?php /* Smarty version Smarty-3.1.14, created on 2014-04-07 17:42:04
         compiled from "/home/carabina/public_html/modules/socialsharing/views/templates/hook/socialsharing_compare.tpl" */ ?>
<?php /*%%SmartyHeaderCode:12852679355342c74c2b40d9-19096490%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'fbca3ddf4d2627682e7325469255cd8ed3d8c2e7' => 
    array (
      0 => '/home/carabina/public_html/modules/socialsharing/views/templates/hook/socialsharing_compare.tpl',
      1 => 1395107266,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '12852679355342c74c2b40d9-19096490',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'PS_SC_TWITTER' => 0,
    'PS_SC_FACEBOOK' => 0,
    'PS_SC_GOOGLE' => 0,
    'PS_SC_PINTEREST' => 0,
    'product' => 0,
    'link' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_5342c74c384835_13713933',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5342c74c384835_13713933')) {function content_5342c74c384835_13713933($_smarty_tpl) {?>
<?php if ($_smarty_tpl->tpl_vars['PS_SC_TWITTER']->value||$_smarty_tpl->tpl_vars['PS_SC_FACEBOOK']->value||$_smarty_tpl->tpl_vars['PS_SC_GOOGLE']->value||$_smarty_tpl->tpl_vars['PS_SC_PINTEREST']->value){?>
	<div id="social-share-compare">
		<p><?php echo smartyTranslate(array('s'=>"Share this comparison with your friends:",'mod'=>'socialsharing'),$_smarty_tpl);?>
</p>
		<p class="socialsharing_product">
			<?php if ($_smarty_tpl->tpl_vars['PS_SC_TWITTER']->value){?>
				<button type="button" class="btn btn-default btn-block btn-twitter" onclick="socialsharing_twitter_click(<?php if (isset($_smarty_tpl->tpl_vars['product']->value)){?>'<?php echo addslashes($_smarty_tpl->tpl_vars['product']->value->name);?>
 <?php echo addslashes($_smarty_tpl->tpl_vars['link']->value->getProductLink($_smarty_tpl->tpl_vars['product']->value));?>
'<?php }?>);">
					<i class="icon-twitter"></i> Tweet
				</button>
			<?php }?>
			<?php if ($_smarty_tpl->tpl_vars['PS_SC_FACEBOOK']->value){?>
				<button type="button" class="btn btn-default btn-block btn-facebook" onclick="socialsharing_facebook_click();">
					<i class="icon-facebook"></i> Share
				</button>
			<?php }?>
			<?php if ($_smarty_tpl->tpl_vars['PS_SC_GOOGLE']->value){?>
				<button type="button" class="btn btn-default btn-block btn-google-plus" onclick="socialsharing_google_click();">
					<i class="icon-google-plus"></i> Google+
				</button>
			<?php }?>
			<?php if ($_smarty_tpl->tpl_vars['PS_SC_PINTEREST']->value){?>
				<button type="button" class="btn btn-default btn-block btn-pinterest" onclick="socialsharing_pinterest_click();">
					<i class="icon-pinterest"></i> Pinterest
				</button>
			<?php }?>
		</p>
	</div>
<?php }?><?php }} ?>