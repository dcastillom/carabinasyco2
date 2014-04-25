<?php /* Smarty version Smarty-3.1.14, created on 2014-04-01 03:23:24
         compiled from "/home/carabina/public_html/modules/homeslider/views/templates/hook/header.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1438316229533a150c597d42-18518747%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '37d1e164b4f349c2837752912b7d2379cb81e018' => 
    array (
      0 => '/home/carabina/public_html/modules/homeslider/views/templates/hook/header.tpl',
      1 => 1396314769,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1438316229533a150c597d42-18518747',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'homeslider' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_533a150c5d43c3_56223663',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_533a150c5d43c3_56223663')) {function content_533a150c5d43c3_56223663($_smarty_tpl) {?><?php if (isset($_smarty_tpl->tpl_vars['homeslider']->value)){?>
<script type="text/javascript">
     var homeslider_loop=<?php echo $_smarty_tpl->tpl_vars['homeslider']->value['loop'];?>
;
     var homeslider_width=<?php echo $_smarty_tpl->tpl_vars['homeslider']->value['width'];?>
;
     var homeslider_speed=<?php echo $_smarty_tpl->tpl_vars['homeslider']->value['speed'];?>
;
     var homeslider_pause=<?php echo $_smarty_tpl->tpl_vars['homeslider']->value['pause'];?>
;
</script>
<?php }?><?php }} ?>