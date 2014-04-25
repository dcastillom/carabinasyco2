<?php
require_once(dirname(__FILE__).'/../../config/config.inc.php');
require_once(dirname(__FILE__).'/../../init.php');

include_once(dirname(__FILE__).'/blocknewshelp.class.php');
$obj_blocknewshelp = new blocknewshelp();
$_data = $obj_blocknewshelp->getItems();
$name_module = 'blocknews';
$step = Configuration::get($name_module.'perpage_posts');
//var_dump($step);exit;
$paging = $obj_blocknewshelp->PageNav(0,$_data['count_all'],$step);

// strip tags for content
foreach($_data['items'] as $_k => $_item){
	$_data['items'][$_k]['content'] = strip_tags($_item['content']);
}

$smarty->assign(array('posts' => $_data['items'], 
					  'count_all' => $_data['count_all'],
					  'paging' => $paging
					  )
				);

$seo_text_data = $obj_blocknewshelp->getTranslateText();
$seo_text = $seo_text_data['seo_text'];
$smarty->assign('meta_title' , $seo_text);
$smarty->assign('meta_description' , $seo_text);
$smarty->assign('meta_keywords' , $seo_text);
				
include_once(dirname(__FILE__).'/../../header.php');


include_once(dirname(__FILE__).'/blocknews.php');
$obj_blocknews = new blocknews();

if(defined('_MYSQL_ENGINE_')){
	echo $obj_blocknews->renderTplItems();
} else {
	echo Module::display(dirname(__FILE__).'/blocknews.php', 'items.tpl');
}

include_once(dirname(__FILE__).'/../../footer.php');