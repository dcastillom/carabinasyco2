<?php
class blocknews extends Module
{
	private $_step = 10;
	
	
	function __construct()
	{
		$this->name = 'blocknews';
		$this->tab = 'News';
		$this->version = '1.1.1';
		$this->author = 'storemodules';
		$this->module_key = '6b8e75daca14a7999eee29b0ba2b2018';

		parent::__construct(); // The parent construct is required for translations

		$this->page = basename(__FILE__, '.php');
		$this->displayName = $this->l('News');
		$this->description = $this->l('Add News');
		
		
	}

	function install()
	{
		
		if (!parent::install())
			return false;

		Configuration::updateValue($this->name.'faq_shbl', 'right');
		Configuration::updateValue($this->name.'faq_blc', 5);
		Configuration::updateValue($this->name.'perpage_posts', 5);
		
		if (!$this->registerHook('leftColumn') 
			OR !$this->registerHook('rightColumn')
			OR !$this->registerHook('Header') 
			OR !$this->_installDB()
			OR !$this->_createFolderAndSetPermissions()
			 )
			return false;
		
		
		return true;
	}
	
	function uninstall()
	{
		
		if (!parent::uninstall() OR !$this->uninstallTable())
			return false;
		return true;
	}
	
	private function _installDB(){
		$sql = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'blocknews` (
							  `id` int(11) NOT NULL auto_increment,
							  `img` text, 
							  `status` int(11) NOT NULL default \'1\',
							  `time_add` timestamp NOT NULL default CURRENT_TIMESTAMP,
							  PRIMARY KEY  (`id`)
							) ENGINE='.(defined('_MYSQL_ENGINE_')?_MYSQL_ENGINE_:"MyISAM").' DEFAULT CHARSET=utf8;';
		if (!Db::getInstance()->Execute($sql))
			return false;
			
		$query = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'blocknews_data` (
							  `id_item` int(11) NOT NULL,
							  `id_lang` int(11) NOT NULL,
							  `title` varchar(5000) NOT NULL,
							  `content` text NOT NULL,
							  KEY `id_item` (`id_item`)
							) ENGINE='.(defined('_MYSQL_ENGINE_')?_MYSQL_ENGINE_:"MyISAM").' DEFAULT CHARSET=utf8';
		Db::getInstance()->Execute($query);
			
		return true;
	}
	
	private function _createFolderAndSetPermissions(){
		
		$prev_cwd = getcwd();
		
		$module_dir = dirname(__FILE__).DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."upload".DIRECTORY_SEPARATOR;
		@chdir($module_dir);
		//folder avatars
		$module_dir_img = $module_dir."blocknews".DIRECTORY_SEPARATOR; 
		@mkdir($module_dir_img, 0777);

		@chdir($prev_cwd);
		
		return true;
	} 
	
	public function uninstallTable() {
		//Db::getInstance()->Execute('DROP TABLE '._DB_PREFIX_.'blocknews');
		return true;
	}
	
	
	
	function hookLeftColumn($params)
	{
		global $smarty;
		include_once(dirname(__FILE__).'/blocknewshelp.class.php');
		$obj_blocknewshelp = new blocknewshelp();
    	$_data = $obj_blocknewshelp->getItemsBlock();
		
    	$smarty->assign(array($this->name.'itemsblock' => $_data['items']
							  )
						);
		
		$smarty->assign($this->name.'faq_shbl', Configuration::get($this->name.'faq_shbl'));
		
		return $this->display(__FILE__, 'left.tpl');		
	}
	
	function hookRightColumn($params)
	{
		global $smarty;
		include_once(dirname(__FILE__).'/blocknewshelp.class.php');
		$obj_blocknewshelp = new blocknewshelp();
    	$_data = $obj_blocknewshelp->getItemsBlock();
		
		$smarty->assign(array($this->name.'itemsblock' => $_data['items']
							  )
						);
		$smarty->assign($this->name.'faq_shbl', Configuration::get($this->name.'faq_shbl'));
		
		return $this->display(__FILE__, 'right.tpl');	
	}
	
	function hookHeader($params){
    	global $smarty;
    	
    	return $this->display(__FILE__, 'head.tpl');
    }
    
     public function getContent()
    {
    	global $currentIndex, $cookie;
    	include_once(dirname(__FILE__).'/blocknewshelp.class.php');
		$obj_blocknews = new blocknewshelp();
		
		
		if (Tools::isSubmit('submit_item'))
        {
        	$languages = Language::getLanguages(false);
	    	$data_title_content_lang = array();
	    	foreach ($languages as $language){
	    		$id_lang = $language['id_lang'];
	    		$title = Tools::getValue("title_".$id_lang);
	    		$content = Tools::getValue("content_".$id_lang);
	    		
	    		if(strlen($title)>0 && strlen($content)>0)
	    		{
	    			$data_title_content_lang[$id_lang] = array('title' => $title,
	    									 				    'content' => $content
	    													    );		
	    		}
	    	}
	    	
        	$item_status = Tools::getValue("item_status");
        	
        	$data = array( 'data_title_content_lang'=>$data_title_content_lang,
         				 	'item_status' => $item_status
         				  );
         	if(sizeof($data_title_content_lang)>0)
         		$obj_blocknews->saveItem($data);
        		
			Tools::redirectAdmin($currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminToken('AdminModules'.intval(Tab::getIdFromClassName('AdminModules')).intval($cookie->id_employee)).'');
		}
		
    	if (Tools::isSubmit("delete_item")) {
			if (Validate::isInt(Tools::getValue("id"))) {
				
				$data = array('id' => Tools::getValue("id"));
				$obj_blocknews->deleteItem($data);
				
				$page = Tools::getValue("pageitems");
				Tools::redirectAdmin($currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminToken('AdminModules'.intval(Tab::getIdFromClassName('AdminModules')).intval($cookie->id_employee)).'&pageitems='.$page);
			}
			
		}
		
    	if (Tools::isSubmit('submit_faq'))
        {
        	 Configuration::updateValue($this->name.'faq_shbl', Tools::getValue('faq_shbl'));
        	 Configuration::updateValue($this->name.'faq_blc', Tools::getValue('faq_blc'));
        	 Configuration::updateValue($this->name.'perpage_posts', Tools::getValue('perpage_posts'));
        }
       
    	if (Tools::isSubmit('cancel_item'))
        {
        	$page = Tools::getValue("pageitems");
        	Tools::redirectAdmin($currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminToken('AdminModules'.intval(Tab::getIdFromClassName('AdminModules')).intval($cookie->id_employee)).'&pageitems='.$page);
		}
		
		if (Tools::isSubmit('update_item'))
        {
        	$id = Tools::getValue("id");
     		
        	$languages = Language::getLanguages(false);
	    	$data_title_content_lang = array();
	    	foreach ($languages as $language){
	    		$id_lang = $language['id_lang'];
	    		$title = Tools::getValue("title_".$id_lang);
	    		$content = Tools::getValue("content_".$id_lang);
	    		
	    		if(strlen($title)>0 && strlen($content)>0)
	    		{
	    			$data_title_content_lang[$id_lang] = array('title' => $title,
	    									 				    'content' => $content
	    													    );		
	    		}
	    	}
        	
         	$item_status = Tools::getValue("item_status");
        	$post_images = Tools::getValue("post_images");
        	
         	$data = array('data_title_content_lang'=>$data_title_content_lang,
        				  'id' => $id,
         				  'item_status' => $item_status,
         				  'post_images' => $post_images
         				 );
         	if(sizeof($data_title_content_lang)>0)
         		$obj_blocknews->updateItem($data);
         		
         	$page = Tools::getValue("pageitems");
         	Tools::redirectAdmin($currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminToken('AdminModules'.intval(Tab::getIdFromClassName('AdminModules')).intval($cookie->id_employee)).'&pageitems='.$page);
		
        }
    	
    	$this->_html = '';
        $this->_html .= $this->_jsandcss();	
        $this->_html .= $this->_displayForm();
        return $this->_html;
    	
    }
    
    private function _displayForm()
     {
     	global $currentIndex, $cookie;
     	$i=0;
     	$_html = '';
		$_html .= '<form action="'.$_SERVER['REQUEST_URI'].'" method="post" >';
		
		$_html .= '
		<fieldset>
					<legend><img src="../modules/'.$this->name.'/logo.gif"  />
					'.$this->displayName.'</legend>';
		
		$_html .= '<table style="width:100%">';
    	
		$_html .= '<tr>';
    	$_html .= '<td style="text-align:right;width:40%;padding:0 20px 0 0">';
    	
    	$_html .= '<b>'.$this->l('News per Page:').'</b>';
    	
    	$_html .= '</td>';
    	$_html .= '<td style="text-align:left">';
		$_html .=  '
					<input type="text" name="perpage_posts"  
			               value="'.Tools::getValue('perpage_posts', Configuration::get($this->name.'perpage_posts')).'"
			               >
				';
		$_html .= '</td>';
		$_html .= '</tr>';
		
		$_html .= '<tr>';
    	$_html .= '<td style="text-align:right;width:35%;padding:0 20px 0 0">';
    	
    	$_html .= '<b>'.$this->l('The number of items in the "Block Last News":').'</b>';
    	
    	$_html .= '</td>';
    	$_html .= '<td style="text-align:left">';
		$_html .=  '
					<input type="text" name="faq_blc"  
			               value="'.Tools::getValue('faq_blc', Configuration::get($this->name.'faq_blc')).'"
			               >
				';
		$_html .= '</td>';
		$_html .= '</tr>';
		
		$_html .= '<tr>';
    	$_html .= '<td style="text-align:right;width:40%;padding:0 20px 0 0">';
    	
    	$_html .= '<b>'.$this->l('Position Block Last News:').'</b>';
    	
    	$_html .= '</td>';
    	$_html .= '<td style="text-align:left">';
		$_html .=  '
					<select class="select" name="faq_shbl" 
							id="faq_shbl">
						<option '.(Tools::getValue('faq_shbl', Configuration::get($this->name.'faq_shbl'))  == "left" ? 'selected="selected" ' : '').' value="left">'.$this->l('Left').'</option>
						<option '.(Tools::getValue('faq_shbl', Configuration::get($this->name.'faq_shbl')) == "right" ? 'selected="selected" ' : '').' value="right">'.$this->l('Right').'</option>
						<option '.(Tools::getValue('faq_shbl', Configuration::get($this->name.'faq_shbl')) == "none" ? 'selected="selected" ' : '').' value="none">'.$this->l('None').'</option>
					
					</select>
				';
		$_html .= '</td>';
		$_html .= '</tr>';
		
		
    	$_html .= '</table>';
			
			$_html .= '<p class="center" style="background: none repeat scroll 0pt 0pt rgb(255, 255, 240); padding: 10px; margin-top: 10px;">
					<input type="submit" name="submit_faq" value="'.$this->l('Update settings').'" 
                		   class="button"  />
                	</p>';
					
					
		$_html .= '</fieldset>	';
		$_html .= '</form>';
		
		$_html .= '<br/><br/>';
		//faq operations
		
		$_html .= '<fieldset>
					<legend><img src="../modules/'.$this->name.'/logo.gif" />
					'.$this->l('Moderate News').'</legend>';
		
		
		
		include_once(dirname(__FILE__).'/blocknewshelp.class.php');
		$obj_blocknews = new blocknewshelp();
		
		
		if(Tools::isSubmit("edit_item")){
			
			$divLangName = "ccontent¤title";
			
			$_data = $obj_blocknews->getItem(array('id'=>(int)Tools::getValue("id")));
			
			$id = $_data['item'][0]['id'];
			$img = $_data['item'][0]['img'];
			$status = $_data['item'][0]['status'];
			$data_content = isset($_data['item']['data'])?$_data['item']['data']:'';
			
			$_html .= '<form action="'.$_SERVER['REQUEST_URI'].'" method="post" enctype="multipart/form-data">';
    		
    		$_html .= '<label>'.$this->l('Title:').'</label>
    					<div class="margin-form">';
    		
			$defaultLanguage = (int)(Configuration::get('PS_LANG_DEFAULT'));
	    	$languages = Language::getLanguages(false);
	    	
	    	foreach ($languages as $language){
			$id_lng = (int)$language['id_lang'];
	    	$title = isset($data_content[$id_lng]['title'])?$data_content[$id_lng]['title']:"";
			
			$_html .= '	<div id="title_'.$language['id_lang'].'" 
							 style="display: '.($language['id_lang'] == $defaultLanguage ? 'block' : 'none').';float: left;"
							 >

						<input type="text" style="width:400px"   
								  id="title_'.$language['id_lang'].'" 
								  name="title_'.$language['id_lang'].'" 
								  value="'.htmlentities(stripslashes($title), ENT_COMPAT, 'UTF-8').'"/>
						</div>';
	    	}
			ob_start();
			$this->displayFlags($languages, $defaultLanguage, $divLangName, 'title');
			$displayflags = ob_get_clean();
			$_html .= $displayflags;
    		$_html .= '<div style="clear:both"></div>';
							
			$_html .= '</div>';
    		
    		$_html .= '<label>'.$this->l('Logo Image').'</label>
    			
    				<div class="margin-form">
					<input type="file" name="post_image" id="post_image" class="customFileInput" />
					<p>Allow formats *.jpg; *.jpeg; *.png; *.gif.</p>';

    	
	    	if(strlen($img)>0){
	    	$_html .= '<div id="post_images_list">';
	    		$_html .= '<div style="float:left;margin:10px" id="post_images_id">';
	    		$_html .= '<table width=100%>';
	    		
	    		$_html .= '<tr><td align="left">';
	    		$_html .= '<input type="radio" checked name="post_images"/>';
	    		
	    		$_html .= '</td>';
	    		
	    		$_html .= '<td align="right">';
	    		
	    			$_html .= '<a href="javascript:void(0)" title="'.$this->l('Delete').'"  
	    						onclick = "delete_img('.$id.');"><img src="'._PS_ADMIN_IMG_.'delete.gif" alt="" /></a>
	    					';
	    		
	    		$_html .= '</td>';
	    		
	    		$_html .= '<tr>';
	    		$_html .= '<td colspan=2>';
	    		$_html .= '<img src="../upload/'.$this->name.'/'.$img.'" style="width:50px;height:50px"/>';
	    		$_html .= '</td>';
	    		$_html .= '</tr>';
	    		
	    		$_html .= '</table>';
	    		
	    		$_html .= '</div>';
	    	//}
	    	$_html .= '<div style="clear:both"></div>';
	    	$_html .= '</div>';
	    	}
	    	
	    	$_html .= '</div>';
    		
    		
    		if(defined('_MYSQL_ENGINE_')){
	    		
    		$_html .= '<label>'.$this->l('Content:').'</label>
	    					<div class="margin-form" >';
    		
    		$defaultLanguage = (int)(Configuration::get('PS_LANG_DEFAULT'));
	    	$languages = Language::getLanguages(false);
	    	
	    	foreach ($languages as $language){
	    	$id_lng = (int)$language['id_lang'];
	    	$content = isset($data_content[$id_lng]['content'])?$data_content[$id_lng]['content']:"";
			
			$_html .= '	<div id="ccontent_'.$language['id_lang'].'" 
							 style="display: '.($language['id_lang'] == $defaultLanguage ? 'block' : 'none').';float: left;"
							 >

						<textarea class="rte" cols="25" rows="10" style="width:400px"   
								  id="content_'.$language['id_lang'].'" 
								  name="content_'.$language['id_lang'].'">'.htmlentities(stripslashes($content), ENT_COMPAT, 'UTF-8').'</textarea>

					</div>';
	    	}
	    	
			ob_start();
			$this->displayFlags($languages, $defaultLanguage, $divLangName, 'ccontent');
			$displayflags = ob_get_clean();
			$_html .= $displayflags;
	    	
			$_html .= '<div style="clear:both"></div>';
			
			$_html .= '</div>';
	    	}else{
	    		
	    		$_html .= '<label>'.$this->l('Content:').'</label>
	    					<div class="margin-form">';
	    					
	    		$defaultLanguage = (int)(Configuration::get('PS_LANG_DEFAULT'));
		    	$languages = Language::getLanguages(false);
		    	$divLangName = "ccontent";
		    	
		    	foreach ($languages as $language){
				$id_lng = (int)$language['id_lang'];
	    		$content = isset($data_content[$id_lng]['content'])?$data_content[$id_lng]['content']:"";
			
				$_html .= '	<div id="ccontent_'.$language['id_lang'].'" 
								 style="display: '.($language['id_lang'] == $defaultLanguage ? 'block' : 'none').';float: left;"
								 >
	
							<textarea class="rte" cols="25" rows="10" style="width:400px"   
									  id="content_'.$language['id_lang'].'" 
									  name="content_'.$language['id_lang'].'">'.htmlentities(stripslashes($content), ENT_COMPAT, 'UTF-8').'</textarea>
	
						</div>';
		    	}
				ob_start();
				$this->displayFlags($languages, $defaultLanguage, $divLangName, 'ccontent');
				$displayflags = ob_get_clean();
				$_html .= $displayflags;
		    	
				$_html .= '<div style="clear:both"></div>';
				
				$_html .= '</div>';
	    	}
	    	
	    	$_html .= '<label>'.$this->l('Status').'</label>
				<div class = "margin-form">';
				
			$_html .= '<select name="item_status" style="width:100px">
						<option value=1 '.(($status==1)?"selected=\"true\"":"").'>'.$this->l('Enabled').'</option>
						<option value=0 '.(($status==0)?"selected=\"true\"":"").'>'.$this->l('Disabled').'</option>
					   </select>';
				
				
			$_html .= '</div>';
			
    	
    		$_html .= '<label>&nbsp;</label>
						<div class = "margin-form"  style="margin-top:10px">
						<input type="submit" name="cancel_item" value="'.$this->l('Cancel').'" 
                		   class="button"  />&nbsp;&nbsp;&nbsp;
						<input type="submit" name="update_item" value="'.$this->l('Update').'" 
                		   class="button"  />
                		  </div>';
    		
    		$_html .= '</form>';
    		
		}else{
			
			$divLangName = "ccontent¤title";
			$name = "";
			$content = "";
			
    		$_html .= '<a href="javascript:void(0)" onclick="$(\'#add-question-form\').show(200);$(\'#link-add-question-form\').hide(200)"
    					id="link-add-question-form"	
					  style="border: 1px solid rgb(222, 222, 222); padding: 5px; margin-bottom: 10px; display: block; font-size: 16px; color: maroon; text-align: center; font-weight: bold; text-decoration: underline;"
					  >'.$this->l('Add New Item').'</a>';
    		
    		$_html .= '<div style="border: 1px solid rgb(222, 222, 222);padding-top:10px;display:none" id="add-question-form">';
			$_html .= '<form action="'.$_SERVER['REQUEST_URI'].'" method="post" enctype="multipart/form-data">';
    		
    		$_html .= '<label>'.$this->l('Title:').'</label>
    					<div class="margin-form">';
    		
    		
    		$defaultLanguage = (int)(Configuration::get('PS_LANG_DEFAULT'));
	    	$languages = Language::getLanguages(false);
	    	
	    	foreach ($languages as $language){
			$id_lng = (int)$language['id_lang'];
	    	
			$_html .= '	<div id="title_'.$language['id_lang'].'" 
							 style="display: '.($language['id_lang'] == $defaultLanguage ? 'block' : 'none').';float: left;"
							 >

						<input type="text" style="width:400px"   
								  id="title_'.$language['id_lang'].'" 
								  name="title_'.$language['id_lang'].'" 
								  value="'.htmlentities(stripslashes($name), ENT_COMPAT, 'UTF-8').'"/>
						</div>';
	    	}
			ob_start();
			$this->displayFlags($languages, $defaultLanguage, $divLangName, 'title');
			$displayflags = ob_get_clean();
			$_html .= $displayflags;
			$_html .= '<div style="clear:both"></div>';
    		
			$_html .= '</div>';
    		
    		$_html .= '<label>'.$this->l('Logo Image').'</label>
    			
    				<div class="margin-form">
					<input type="file" name="post_image" id="post_image" class="customFileInput" />
					<p>Allow formats *.jpg; *.jpeg; *.png; *.gif.</p>';
    	
	    	$_html .= '</div>';
    		
    		if(defined('_MYSQL_ENGINE_')){
	    	
    			
    		$_html .= '<label>'.$this->l('Content:').'</label>
	    					<div class="margin-form" >';
    			$defaultLanguage = (int)(Configuration::get('PS_LANG_DEFAULT'));
	    	$languages = Language::getLanguages(false);
	    	
	    	foreach ($languages as $language)

			$_html .= '	<div id="ccontent_'.$language['id_lang'].'" 
							 style="display: '.($language['id_lang'] == $defaultLanguage ? 'block' : 'none').';float: left;"
							 >

						<textarea class="rte" cols="25" rows="10" style="width:400px"   
								  id="content_'.$language['id_lang'].'" 
								  name="content_'.$language['id_lang'].'">'.htmlentities(stripslashes($content), ENT_COMPAT, 'UTF-8').'</textarea>

					</div>';
			ob_start();
			$this->displayFlags($languages, $defaultLanguage, $divLangName, 'ccontent');
			$displayflags = ob_get_clean();
			$_html .= $displayflags;
			$_html .= '<div style="clear:both"></div>';
			$_html .= '</div>';
			
	    	}else{
	    		
	    	$_html .= '<label>'.$this->l('Content:').'</label>
	    					<div class="margin-form" >';
    			$defaultLanguage = (int)(Configuration::get('PS_LANG_DEFAULT'));
	    	$languages = Language::getLanguages(false);
	    	
	    	foreach ($languages as $language)

			$_html .= '	<div id="ccontent_'.$language['id_lang'].'" 
							 style="display: '.($language['id_lang'] == $defaultLanguage ? 'block' : 'none').';float: left;"
							 >

						<textarea class="rte" cols="25" rows="10" style="width:400px"   
								  id="content_'.$language['id_lang'].'" 
								  name="content_'.$language['id_lang'].'">'.htmlentities(stripslashes($content), ENT_COMPAT, 'UTF-8').'</textarea>

					</div>';
			ob_start();
			$this->displayFlags($languages, $defaultLanguage, $divLangName, 'ccontent');
			$displayflags = ob_get_clean();
			$_html .= $displayflags;
			$_html .= '<div style="clear:both"></div>';
			$_html .= '</div>';
	    	}
	    	
	    	
		$_html .= '<label>'.$this->l('Status').'</label>
				<div class = "margin-form" style="padding: 0pt 0pt 10px 130px;">';
				
		$_html .= '<select name="item_status">
					<option value=1 selected="true">'.$this->l('Enabled').'</option>
					<option value=0>'.$this->l('Disabled').'</option>
				   </select>';
			
				
			$_html .= '</div>';
    	
    		$_html .= '<label>&nbsp;</label>
						<div class = "margin-form"  style="margin-top:10px">
						<input type="button" value="'.$this->l('Cancel').'" 
                		   class="button"  
                		   onclick="$(\'#link-add-question-form\').show(200);$(\'#add-question-form\').hide(200);" 
                		   />&nbsp;&nbsp;&nbsp;
						<input type="submit" name="submit_item" value="'.$this->l('Save').'" 
                		   class="button"  />
                		  </div>';
    		
    		$_html .= '</form>';
    		$_html .= '</div>';
		
    		$_html .= '<br/>';
    		
			$_html .= '<table class = "table" width = 100%>
			<tr>
				<th width="5%">'.$this->l('ID').'</th>
				<th width="10%">'.$this->l('Image').'</th>
				<th>'.$this->l('Title').'</th>
				<th width="20%">'.$this->l('Date').'</th>
				<th width="5%">'.$this->l('Status').'</th>
				<th width = "7%">'.$this->l('Action').'</th>
			</tr>';
			
			$start = (int)Tools::getValue("pageitems");
			$_data = $obj_blocknews->getItems(array('admin'=>1,'start' => $start,'step'=>$this->_step));
			$_items = $_data['items'];
			
			$paging = $obj_blocknews->PageNav($start,$_data['count_all'],$this->_step, 
											array('admin' => 1,'currentIndex'=>$currentIndex,
												  'token' => '&configure='.$this->name.'&token='.Tools::getAdminToken('AdminModules'.intval(Tab::getIdFromClassName('AdminModules')).intval($cookie->id_employee)),
												  'item' => 'items'
											));
			
			if(sizeof($_items)>0){
				
				foreach($_items as $_item){
					$i=1;
					$id = $_item['id'];
					$title = $_item['title'];
					$img = $_item['img'];
					$status = $_item['status'];
					$date = $_item['time_add'];
			
					$_html .= 
						'<tr>
						<td style = "color:black;">'.$id.'</td>
						<td style = "color:black;" align="center"><img src="../upload/'.$this->name.'/'.$img.'" style="width:40px;height:40px" /></td>
						<td style = "color:black;">'.$title.'</td>';
					$_html .= '<td style = "color:black;">'.$date.'</td>';
					if($status)
						$_html .= '<td align="center"><img alt="'.$this->l('Enabled').'" title="'.$this->l('Enabled').'" src="../img/admin/enabled.gif"></td>';
					else
						$_html .= '<td align="center"><img alt="'.$this->l('Disabled').'" title="'.$this->l('Disabled').'" src="../img/admin/disabled.gif"></td>';
				
			
					$_html .= '<td>
				
								 <input type = "hidden" name = "id" value = "'.$id.'"/>
								 <a href="'.$currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminToken('AdminModules'.intval(Tab::getIdFromClassName('AdminModules')).intval($cookie->id_employee)).'&edit_item&id='.(int)($id).'&pageitems='.$start.'" title="'.$this->l('Edit').'"><img src="'._PS_ADMIN_IMG_.'edit.gif" alt="" /></a> 
								 <a href="'.$currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminToken('AdminModules'.intval(Tab::getIdFromClassName('AdminModules')).intval($cookie->id_employee)).'&delete_item&id='.(int)($id).'&pageitems='.$start.'" title="'.$this->l('Delete').'"  onclick = "javascript:return confirm(\''.$this->l('Are you sure you want to remove this item?').'\');"><img src="'._PS_ADMIN_IMG_.'delete.gif" alt="" /></a>'; 
								 $_html .= '</form>
							 </td>';
					$_html .= '</tr>';
				}
			} else {
			$_html .= '<tr><td colspan="6" style="text-align:center;font-weight:bold;padding:10px">'.$this->l('Items not found').'</td></tr>';	
			}
			
			$_html .= '</table>';
		}
			
		     if($i!=0){
		    	$_html .= '<div style="margin:5px">';
		    	$_html .= $paging;
		    	$_html .= '</div>';
		    	}
		
		$_html .=	'</fieldset>'; 
		
		
     	return $_html;
     }
    
    
     private function _jsandcss(){
    	$_html = '';
    	
    	// custom-input-file
    	
    	$_html .= '<link rel="stylesheet" href="../modules/'.$this->name.'/css/custom-input-file.css" type="text/css" />';
    	$_html .= '<script type="text/javascript" src="../modules/'.$this->name.'/js/custom-input-file.js"></script>';
    	
    	
     global $cookie;
    	$defaultLanguage = (int)(Configuration::get('PS_LANG_DEFAULT'));
		$iso = Language::getIsoById((int)($cookie->id_lang));
		$isoTinyMCE = (file_exists(_PS_ROOT_DIR_.'/js/tiny_mce/langs/'.$iso.'.js') ? $iso : 'en');
		$ad = dirname($_SERVER["PHP_SELF"]);
		
		if(defined('_MYSQL_ENGINE_') && substr(_PS_VERSION_,0,3) != '1.5'){
		$_html .=  '
			<script type="text/javascript">	
			var iso = \''.$isoTinyMCE.'\' ;
			var pathCSS = \''._THEME_CSS_DIR_.'\' ;
			var ad = \''.$ad.'\' ;
			</script>';
			$_html .= '<script type="text/javascript" src="'.__PS_BASE_URI__.'js/tiny_mce/tiny_mce.js"></script>
			<script type="text/javascript" src="'.__PS_BASE_URI__.'js/tinymce.inc.js"></script>';
		$_html .= '
		<script type="text/javascript">id_language = Number('.$defaultLanguage.');</script>';
		}
		
		if(substr(_PS_VERSION_,0,3) == '1.5' || !defined('_MYSQL_ENGINE_')){
			if(substr(_PS_VERSION_,0,3) == '1.5'){
				$_html .= '<script type="text/javascript" src="'.__PS_BASE_URI__.'js/tiny_mce/tiny_mce.js"></script>';
			} else {
				$_html .= '<script type="text/javascript" src="'.__PS_BASE_URI__.'js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>';
			}
		$_html .= '<script type="text/javascript">
					tinyMCE.init({
						mode : "specific_textareas",
						theme : "advanced",
						editor_selector : "rte",';
		if(substr(_PS_VERSION_,0,3) == '1.5'){
			 $_html .= 'skin:"cirkuit",';
		}
			$_html  .=  'editor_deselector : "noEditor",
						plugins : "safari,pagebreak,style,layer,table,advimage,advlink,inlinepopups,media,searchreplace,contextmenu,paste,directionality,fullscreen",
						// Theme options
						theme_advanced_buttons1 : "newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
						theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,,|,forecolor,backcolor",
						theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,media,|,ltr,rtl,|,fullscreen",
						theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,pagebreak",
						theme_advanced_toolbar_location : "top",
						theme_advanced_toolbar_align : "left",
						theme_advanced_statusbar_location : "bottom",
						theme_advanced_resizing : false,
						content_css : "'.__PS_BASE_URI__.'themes/'._THEME_NAME_.'/css/global.css",
						document_base_url : "'.__PS_BASE_URI__.'",
						width: "650",
						height: "auto",
						font_size_style_values : "8pt, 10pt, 12pt, 14pt, 18pt, 24pt, 36pt",
						// Drop lists for link/image/media/template dialogs
						template_external_list_url : "lists/template_list.js",
						external_link_list_url : "lists/link_list.js",
						external_image_list_url : "lists/image_list.js",
						media_external_list_url : "lists/media_list.js",
						elements : "nourlconvert",
						entity_encoding: "raw",
						convert_urls : false,
						language : "'.(file_exists(_PS_ROOT_DIR_.'/js/tinymce/jscripts/tiny_mce/langs/'.$iso.'.js') ? $iso : 'en').'"
						
					});
		</script>';
		
		}
    	return $_html;
    }	
    
    
	public function renderTplItems(){
		return Module::display(dirname(__FILE__).'/blocknews.php', 'items.tpl');
	}
	
	public function renderTplListCat(){
		return Module::display(dirname(__FILE__).'/blocknews.php', 'list.tpl');
	}
	public function renderTplItem(){
		return Module::display(dirname(__FILE__).'/blocknews.php', 'item.tpl');
	}
	
}