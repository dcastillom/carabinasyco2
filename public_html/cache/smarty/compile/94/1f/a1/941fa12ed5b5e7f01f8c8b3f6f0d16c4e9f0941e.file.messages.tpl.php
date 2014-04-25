<?php /* Smarty version Smarty-3.1.14, created on 2014-04-08 13:31:34
         compiled from "/home/carabina/public_html/modules/themeconfigurator/views/templates/admin/messages.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1313093024533a2031472c12-17674714%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '941fa12ed5b5e7f01f8c8b3f6f0d16c4e9f0941e' => 
    array (
      0 => '/home/carabina/public_html/modules/themeconfigurator/views/templates/admin/messages.tpl',
      1 => 1396956641,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1313093024533a2031472c12-17674714',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_533a203154ee80_43689365',
  'variables' => 
  array (
    'id' => 0,
    'text' => 0,
    'class' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_533a203154ee80_43689365')) {function content_533a203154ee80_43689365($_smarty_tpl) {?>

<div id="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
-response" <?php if (!isset($_smarty_tpl->tpl_vars['text']->value)){?>style="display:none;"<?php }?> class="message alert alert-<?php if (isset($_smarty_tpl->tpl_vars['class']->value)&&$_smarty_tpl->tpl_vars['class']->value=='error'){?>danger<?php }else{ ?>success<?php }?>">
	<div><?php if (isset($_smarty_tpl->tpl_vars['text']->value)){?><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['text']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
<?php }?></div>
</div><?php }} ?>