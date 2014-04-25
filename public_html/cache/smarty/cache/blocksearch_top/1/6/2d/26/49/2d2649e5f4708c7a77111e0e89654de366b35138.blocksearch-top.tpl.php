<?php /*%%SmartyHeaderCode:152894825353394e96341b01-03283051%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2d2649e5f4708c7a77111e0e89654de366b35138' => 
    array (
      0 => '/home/carabina/public_html/themes/default-bootstrap/modules/blocksearch/blocksearch-top.tpl',
      1 => 1395073066,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '152894825353394e96341b01-03283051',
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_534bff1cb6f336_78295609',
  'has_nocache_code' => false,
  'cache_lifetime' => 31536000,
),true); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_534bff1cb6f336_78295609')) {function content_534bff1cb6f336_78295609($_smarty_tpl) {?><!-- Block search module TOP -->
<div id="search_block_top" class="col-sm-4 clearfix">
	<form id="searchbox" method="get" action="http://carabinasyco2.com/buscar" >
		<input type="hidden" name="controller" value="search" />
		<input type="hidden" name="orderby" value="position" />
		<input type="hidden" name="orderway" value="desc" />
		<input class="search_query form-control" type="text" id="search_query_top" name="search_query" placeholder="Buscar" value="" />
		<button type="submit" name="submit_search" class="btn btn-default button-search">
			<span>Buscar</span>
		</button>
	</form>
</div>
<!-- /Block search module TOP --><?php }} ?>