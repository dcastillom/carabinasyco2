<?php /* Smarty version Smarty-3.1.14, created on 2014-04-01 16:35:28
         compiled from "/home/carabina/public_html/modules/paypal/views/templates/admin/header.tpl" */ ?>
<?php /*%%SmartyHeaderCode:748901915533aceb04ef6e3-16534853%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f38aded04887fe4c42285a06e50a64ea21905274' => 
    array (
      0 => '/home/carabina/public_html/modules/paypal/views/templates/admin/header.tpl',
      1 => 1396362924,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '748901915533aceb04ef6e3-16534853',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'PayPal_WPS' => 0,
    'PayPal_HSS' => 0,
    'PayPal_ECS' => 0,
    'PayPal_module_dir' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_533aceb0553696_28253254',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_533aceb0553696_28253254')) {function content_533aceb0553696_28253254($_smarty_tpl) {?>

<script type="text/javascript">
	var PayPal_WPS = '<?php echo intval($_smarty_tpl->tpl_vars['PayPal_WPS']->value);?>
';
	var PayPal_HSS = '<?php echo intval($_smarty_tpl->tpl_vars['PayPal_HSS']->value);?>
';
	var PayPal_ECS = '<?php echo intval($_smarty_tpl->tpl_vars['PayPal_ECS']->value);?>
';
</script>

<script type="text/javascript" src="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['PayPal_module_dir']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
/js/back_office.js"></script><?php }} ?>