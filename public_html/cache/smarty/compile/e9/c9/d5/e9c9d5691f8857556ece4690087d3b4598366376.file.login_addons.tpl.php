<?php /* Smarty version Smarty-3.1.14, created on 2014-04-01 01:42:09
         compiled from "/home/carabina/public_html/admin123/themes/default/template/controllers/modules/login_addons.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1949555265339fd51c7b7c6-70601799%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e9c9d5691f8857556ece4690087d3b4598366376' => 
    array (
      0 => '/home/carabina/public_html/admin123/themes/default/template/controllers/modules/login_addons.tpl',
      1 => 1395073064,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1949555265339fd51c7b7c6-70601799',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'add_permission' => 0,
    'logged_on_addons' => 0,
    'username_addons' => 0,
    'check_url_fopen' => 0,
    'check_openssl' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_5339fd51cfbe47_55145584',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5339fd51cfbe47_55145584')) {function content_5339fd51cfbe47_55145584($_smarty_tpl) {?>

<?php if ($_smarty_tpl->tpl_vars['add_permission']->value=='1'){?>
	<div class="panel">
	<?php if (isset($_smarty_tpl->tpl_vars['logged_on_addons']->value)){?>
			<!--start addons login-->
			<div class="panel-heading">
				<i class="icon-user"></i>
				<?php echo smartyTranslate(array('s'=>'You are logged into %s','sprintf'=>'<a target="_blank" href="http://addons.prestashop.com/?utm_source=backoffice_modules">PrestaShop Addons</a>'),$_smarty_tpl);?>

			</div>
			<div id="addons_login_div">	
				<p><?php echo smartyTranslate(array('s'=>'Welcome'),$_smarty_tpl);?>
 <?php echo $_smarty_tpl->tpl_vars['username_addons']->value;?>
</p>
				<a class="btn btn-default" href="#" id="addons_logout_button">
					<i class="icon-signout"></i> <?php echo smartyTranslate(array('s'=>'Log out from PrestaShop Addons.'),$_smarty_tpl);?>

				</a>
			</div>
			<!--end addons login-->
	<?php }else{ ?>
		<?php if ($_smarty_tpl->tpl_vars['check_url_fopen']->value=='ko'||$_smarty_tpl->tpl_vars['check_openssl']->value=='ko'){?>
			<div class="alert alert-warning">
				<?php echo smartyTranslate(array('s'=>'If you want to be able to fully use the AdminModules panel and have free modules available, you should enable the following configuration on your server:'),$_smarty_tpl);?>

				<br />
				<?php if ($_smarty_tpl->tpl_vars['check_url_fopen']->value=='ko'){?>- <?php echo smartyTranslate(array('s'=>'Enable allow_url_fopen'),$_smarty_tpl);?>
<br /><?php }?>
				<?php if ($_smarty_tpl->tpl_vars['check_openssl']->value=='ko'){?>- <?php echo smartyTranslate(array('s'=>'Enable php openSSL extension'),$_smarty_tpl);?>
<br /><?php }?>
			</div>
		<?php }else{ ?>
			<!--start addons login-->
			<div class="panel-heading">
				<i class="icon-puzzle-piece"></i>
				<a target="_blank" href="http://addons.prestashop.com/?utm_source=backoffice_modules">PrestaShop Addons</a>
			</div>
			<form id="addons_login_form" method="post" >
				<div class="form-group">
					<label for="username_addons"><?php echo smartyTranslate(array('s'=>'Addons Login'),$_smarty_tpl);?>
 :</label> 
					<div class="input-group">
						<span class="input-group-addon"><i class="icon-user"></i></span>
						<input id="username_addons" class="form-control" name="username_addons" type="text" value=""  autocomplete="off" class="form-control ac_input">
					</div>
				</div>
				<div class="form-group">
					<label for="password_addons"><?php echo smartyTranslate(array('s'=>'Password Addons'),$_smarty_tpl);?>
 :</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="icon-key"></i></span>
						<input id="password_addons" class="form-control" name="password_addons" type="password" value=""  autocomplete="off" class="form-control ac_input">
					</div>
				</div>
				<div class="row">
					<button id="addons_login_button" class="btn btn-default btn-block btn-lg" type="submit">
						<i class="icon-unlock"></i> <?php echo smartyTranslate(array('s'=>'Log in'),$_smarty_tpl);?>

					</button>
				</div>
				<div id="addons_loading" class="help-block"></div>
			</form>
			<!--end addons login-->
		<?php }?>
	<?php }?>
	</div>
<?php }?><?php }} ?>