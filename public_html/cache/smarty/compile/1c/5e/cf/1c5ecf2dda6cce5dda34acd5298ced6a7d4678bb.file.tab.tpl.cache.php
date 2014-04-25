<?php /* Smarty version Smarty-3.1.14, created on 2014-03-31 13:16:38
         compiled from "/home/carabina/public_html/themes/default-bootstrap/modules/blockbestsellers/tab.tpl" */ ?>
<?php /*%%SmartyHeaderCode:185750134153394e96eaa234-54316107%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1c5ecf2dda6cce5dda34acd5298ced6a7d4678bb' => 
    array (
      0 => '/home/carabina/public_html/themes/default-bootstrap/modules/blockbestsellers/tab.tpl',
      1 => 1395073066,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '185750134153394e96eaa234-54316107',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'active_li' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_53394e96ec2f19_76682066',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_53394e96ec2f19_76682066')) {function content_53394e96ec2f19_76682066($_smarty_tpl) {?><?php if (!is_callable('smarty_function_counter')) include '/home/carabina/public_html/tools/smarty/plugins/function.counter.php';
?>
<?php echo smarty_function_counter(array('name'=>'active_li','assign'=>'active_li'),$_smarty_tpl);?>

<li<?php if ($_smarty_tpl->tpl_vars['active_li']->value==1){?> class="active"<?php }?>><a data-toggle="tab" href="#blockbestsellers" class="blockbestsellers"><?php echo smartyTranslate(array('s'=>'Best Sellers','mod'=>'blockbestsellers'),$_smarty_tpl);?>
</a></li><?php }} ?>