<?php
include(dirname(__FILE__).'/../../config/config.inc.php');
include(dirname(__FILE__).'/../../init.php');
ob_start(); 
$status = 'success';
$message = '';

include_once(dirname(__FILE__).'/blocknewshelp.class.php');
$obj_blocknewshelp = new blocknewshelp();

$action = $_REQUEST['action'];

switch ($action){
	case 'pagenav':
		$page = (int) $_POST['page'];
		$_html_page_nav = '';
		$_html = '';
		
		$name_module = 'blocknews';
		
		$step = Configuration::get($name_module.'perpage_posts');
		$_data = $obj_blocknewshelp->getItems(array('start'=>$page,'step'=>$step));
		
		// strip tags for content
		foreach($_data['items'] as $_k => $_item){
			$_data['items'][$_k]['content'] = strip_tags($_item['content']);
		}
		
		$paging = $obj_blocknewshelp->PageNav($page,$_data['count_all'],$step);
		
		$_html_page_nav = $paging;
		
		$smarty->assign(array('posts' => $_data['items'], 
							  'count_all' => $_data['count_all'],
							  'paging' => $paging
							  )
						);
					
		ob_start();
		if(defined('_MYSQL_ENGINE_')){
			include_once(dirname(__FILE__).'/blocknews.php');
			$obj_blocknews = new blocknews();
			echo $obj_blocknews->renderTplListCat();
		} else {
			echo Module::display(dirname(__FILE__).'/blocknews.php', 'list.tpl');
		}
		$_html = ob_get_clean();
		
	break;
	case 'deleteimg':
		$item_id = $_POST['item_id'];
		$obj_blocknewshelp->deleteImg(array('id'=>$item_id));
	break;
	default:
		$status = 'error';
		$message = 'Unknown parameters!';
	break;
}


$response = new stdClass();
$content = ob_get_clean();
$response->status = $status;
$response->message = $message;	
if($action == "pagenav")
	$response->params = array('content' => $_html, 'page_nav' => $_html_page_nav );
else
	$response->params = array('content' => $content);
echo json_encode($response);

?>