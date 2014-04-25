<?php
//error_reporting(E_ALL|E_STRICT);

require_once(dirname(__FILE__).'/../../config/config.inc.php');
require_once(dirname(__FILE__).'/../../init.php');

$post_id = isset($_REQUEST['item_id'])?(int)$_REQUEST['item_id']:0;

include_once(dirname(__FILE__).'/blocknewshelp.class.php');
$obj_blocknewshelp = new blocknewshelp();


$_info_cat = $obj_blocknewshelp->getItem(array('id' => $post_id,'site'=>1));

$title = isset($_info_cat['item'][0]['title'])?$_info_cat['item'][0]['title']:'';
$seo_description = isset($_info_cat['item'][0]['title'])?$_info_cat['item'][0]['title']:'';
$seo_keywords = isset($_info_cat['item'][0]['title'])?$_info_cat['item'][0]['title']:''; 

$smarty->assign('meta_title' , $title);
$smarty->assign('meta_description' , $seo_description);
$smarty->assign('meta_keywords' , $seo_keywords);

include_once(dirname(__FILE__).'/../../header.php');


$name_module = 'blocknews';
$step = Configuration::get($name_module.'perpage_posts');

				
$smarty->assign(array('posts' => $_info_cat['item']));

include_once(dirname(__FILE__).'/blocknews.php');
$obj_blocknews = new blocknews();

if(defined('_MYSQL_ENGINE_')){
	echo $obj_blocknews->renderTplItem();
} else {
	echo Module::display(dirname(__FILE__).'/blocknews.php', 'item.tpl');
}
include_once(dirname(__FILE__).'/../../footer.php');

?>