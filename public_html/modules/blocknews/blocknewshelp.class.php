<?php
class blocknewshelp extends Module{
	
	
	private $_width = 400;
	private $_height = 400;
	private $_name = 'blocknews';
	
	public function getItems($_data = null){
		$admin = isset($_data['admin'])?$_data['admin']:0;
		$start = isset($_data['start'])?$_data['start']:0;
		$step = isset($_data['step'])?$_data['step']:10;
		if($admin){
			
			$sql = '
			SELECT pc.*
			FROM `'._DB_PREFIX_.'blocknews` pc
			ORDER BY pc.`id` DESC
			LIMIT '.$start.' ,'.$step.'';
			$items = Db::getInstance()->ExecuteS($sql);
			
			
			
			foreach($items as $k => $_item){
				
				$items_data = Db::getInstance()->ExecuteS('
				SELECT pc.*
				FROM `'._DB_PREFIX_.'blocknews_data` pc
				WHERE pc.id_item = '.$_item['id'].'
				');
				
				global $cookie;
				$defaultLanguage =  $cookie->id_lang;
				
				$tmp_title = '';
				$tmp_link = '';
				
				foreach ($items_data as $item_data){
		    		
		    		$title = isset($item_data['title'])?$item_data['title']:'';
		    		if(strlen($tmp_title)==0){
		    			if(strlen($title)>0)
		    					$tmp_title = $title; 
		    		}
		    		
		    		
		    		if($defaultLanguage == $item_data['id_lang']){
		    			$items[$k]['title'] = $item_data['title'];
		    		} 
		    	}
		    	
		    	if(@strlen($items[$k]['title'])==0)
		    		$items[$k]['title'] = $tmp_title;
		    	
			}
			

			$data_count = Db::getInstance()->getRow('
			SELECT COUNT(`id`) AS "count"
			FROM `'._DB_PREFIX_.'blocknews` pc
			');
			
		} else {
			$step = Configuration::get($this->_name.'perpage_posts');
			
			global $cookie;
			$current_language = (int)$cookie->id_lang;
			
			$sql = '
			SELECT pc.*
			FROM `'._DB_PREFIX_.'blocknews` pc 
			LEFT JOIN `'._DB_PREFIX_.'blocknews_data` pc_d
			on(pc.id = pc_d.id_item)
			WHERE pc.status = 1 and pc_d.id_lang = '.$current_language.' 
			ORDER BY pc.`id` DESC
			LIMIT '.$start.' ,'.$step.'';
			$items_tmp = Db::getInstance()->ExecuteS($sql);
			
			$items = array();
			
			foreach($items_tmp as $k => $_item){
				
				$items_data = Db::getInstance()->ExecuteS('
				SELECT pc.*
				FROM `'._DB_PREFIX_.'blocknews_data` pc
				WHERE pc.id_item = '.$_item['id'].'
				');
				
				
				
				foreach ($items_data as $item_data){
		    		
		    		if($current_language == $item_data['id_lang']){
		    			$items[$k]['title'] = $item_data['title'];
		    			$items[$k]['content'] = $item_data['content'];
		    			$items[$k]['id'] = $_item['id'];
		    			$items[$k]['img'] = $_item['img'];
		    			$items[$k]['time_add'] = $_item['time_add'];
		    		} 
		    	}
		    }
			

			$data_count = Db::getInstance()->getRow('
			SELECT COUNT(pc.`id`) AS "count"
			FROM `'._DB_PREFIX_.'blocknews` pc LEFT JOIN `'._DB_PREFIX_.'blocknews_data` pc_d
			on(pc.id = pc_d.id_item)
			WHERE pc.status = 1 and pc_d.id_lang = '.$current_language.' 
			');
			
		}
		return array('items' => $items, 'count_all' => $data_count['count']);
	}
	
	public function saveItem($data){
	
		$item_status = $data['item_status'];
			
		$sql = 'INSERT into `'._DB_PREFIX_.'blocknews` SET
							   `status` = \''.pSQL($item_status).'\'
							   ';
		defined('_MYSQL_ENGINE_')?$result = Db::getInstance()->ExecuteS($sql):$result = Db::getInstance()->Execute($sql);
		
		$post_id = Db::getInstance()->Insert_ID();
		
		foreach($data['data_title_content_lang'] as $language => $item){
		
		$title = $item['title'];
		$content = $item['content'];
		
		$sql = 'INSERT into `'._DB_PREFIX_.'blocknews_data` SET
							   `id_item` = \''.pSQL($post_id).'\',
							   `id_lang` = \''.pSQL($language).'\',
							   `title` = \''.pSQL($title).'\',
							   `content` = "'.mysql_escape_string($content).'"
							   ';
		
		defined('_MYSQL_ENGINE_')?$result = Db::getInstance()->ExecuteS($sql):$result = Db::getInstance()->Execute($sql);
		}
		
		$this->saveImage(array('post_id' => $post_id));
		
	}
	
public function saveImage($data = null){
		
		$error = 0;
		$error_text = '';
		
		$post_id = $data['post_id'];
		$post_images = isset($data['post_images'])?$data['post_images']:'';
		
		$files = $_FILES['post_image'];
		
		############### files ###############################
		if(!empty($files['name']))
			{
		      if(!$files['error'])
		      {
				  $type_one = $files['type'];
				  $ext = explode("/",$type_one);
				  
				  if(strpos('_'.$type_one,'image')<1)
				  {
				  	$error_text = $this->l('Invalid file type, please try again!');
				  	$error = 1;

				  }elseif(!in_array($ext[1],array('png','x-png','gif','jpg','jpeg','pjpeg'))){
				  	$error_text = $this->l('Wrong file format, please try again!');
				  	$error = 1;
				  	
				  } else {
				  	
				  		$info_post = $this->getItem(array('id'=>$post_id));
				  		$post_item = $info_post['item'];
				  		$img_post = $post_item[0]['img'];
				  		
				  		if(strlen($img_post)>0){
				  			// delete old avatars
				  			$name_thumb = current(explode(".",$img_post));
				  			unlink(dirname(__FILE__).DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."upload".DIRECTORY_SEPARATOR."blocknews".DIRECTORY_SEPARATOR.$name_thumb.".jpg");
				  			
				  		} 
							
					  	srand((double)microtime()*1000000);
					 	$uniq_name_image = uniqid(rand());
					 	$type_one = substr($type_one,6,strlen($type_one)-6);
					 	$filename = $uniq_name_image.'.'.$type_one; 
					 	
						move_uploaded_file($files['tmp_name'], dirname(__FILE__).DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."upload".DIRECTORY_SEPARATOR."blocknews".DIRECTORY_SEPARATOR.$filename);
						
						$this->copyImage(array('dir_without_ext'=>dirname(__FILE__).DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."upload".DIRECTORY_SEPARATOR."blocknews".DIRECTORY_SEPARATOR.$uniq_name_image,
												'name'=>dirname(__FILE__).DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."upload".DIRECTORY_SEPARATOR."blocknews".DIRECTORY_SEPARATOR.$filename)
										);
						
						
						$img_return = $uniq_name_image.'.jpg';
			  		
				  		$this->_updateImgToItem(array('post_id' => $post_id,
				  									  'img' =>  $img_return
				  									  )
				  								);

				  }
				}
				else
					{
					### check  for errors ####
			      	switch($files['error'])
						{
							case '1':
								$error_text = $this->l('The size of the uploaded file exceeds the ').ini_get('upload_max_filesize').'b';
								break;
							case '2':
								$error_text = $this->l('The size of  the uploaded file exceeds the specified parameter  MAX_FILE_SIZE in HTML form.');
								break;
							case '3':
								$error_text = $this->l('Loaded only a portion of the file');
								break;
							case '4':
								$error_text = $this->l('The file was not loaded (in the form user pointed the wrong path  to the file). ');
								break;
							case '6':
								$error_text = $this->l('Invalid  temporary directory.');
								break;
							case '7':
								$error_text = $this->l('Error writing file to disk');
								break;
							case '8':
								$error_text = $this->l('File download aborted');
								break;
							case '999':
							default:
								$error_text = $this->l('Unknown error code!');
							break;
						}
						$error = 1;
			      	########
					   
					}
			}  else {
				//var_dump($post_images); exit;
				if($post_images != "on"){
				$this->_updateImgToItem(array('post_id' => $post_id,
				  							  'img' =>  ""
				  							  )
				  						);
				}
			}
			
		return array('error' => $error,
					 'error_text' => $error_text);
	
	
	}
	
	private function _updateImgToItem($data = null){
		
		$post_id = $data['post_id'];
		$img = $data['img'];
			
		// update
		$sql = 'UPDATE `'._DB_PREFIX_.'blocknews` SET
							   `img` = \''.pSQL($img).'\'
							   WHERE id = '.$post_id.'
							   ';
		defined('_MYSQL_ENGINE_')?$result = Db::getInstance()->ExecuteS($sql):$result = Db::getInstance()->Execute($sql);
		
	}
	
	public function deleteItem($data){
		
		
		$id = $data['id'];
		$sql = 'DELETE FROM `'._DB_PREFIX_.'blocknews`
					   WHERE id ='.$id.'';
		defined('_MYSQL_ENGINE_')?$result = Db::getInstance()->ExecuteS($sql):$result = Db::getInstance()->Execute($sql);
		
		$sql = 'DELETE FROM `'._DB_PREFIX_.'blocknews_data`
					   WHERE id_item ='.$id.'';
		defined('_MYSQL_ENGINE_')?$result = Db::getInstance()->ExecuteS($sql):$result = Db::getInstance()->Execute($sql);
		
			
	}
	
	public function deleteImg($data = null){
		$id = $data['id'];
		
		$info_post = $this->getItem(array('id'=>$id));
  		$img = $info_post['item'][0]['img'];
				  		
		$this->_updateImgToItem(array('post_id' => $id,
				  					  'img' =>  ""
				  					 )
				  				);
				  				
		@unlink(dirname(__FILE__).DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."upload".DIRECTORY_SEPARATOR."blocknews".DIRECTORY_SEPARATOR.$img);
		
	}
	
	public function getItem($_data){
		$id = $_data['id'];
		$site = isset($_data['site'])?$_data['site']:0;
		if($site){
			global $cookie;
			$current_language = (int)$cookie->id_lang;
			
			$sql = '
			SELECT pc.*
			FROM `'._DB_PREFIX_.'blocknews` pc 
			LEFT JOIN  `'._DB_PREFIX_.'blocknews_data` pc_d
			ON(pc_d.id_item = pc.id)
			WHERE pc.id = '.$id.' AND pc.status = 1 and pc_d.id_lang = '.$current_language.' ';
			
			$item = Db::getInstance()->ExecuteS($sql);
			
			foreach($item as $k => $_item){
				
				$items_data = Db::getInstance()->ExecuteS('
				SELECT pc.*
				FROM `'._DB_PREFIX_.'blocknews_data` pc
				WHERE pc.id_item = '.$_item['id'].'
				');
				
				foreach ($items_data as $item_data){
						if($current_language == $item_data['id_lang']){
		    			$item[$k]['title'] = $item_data['title'];
		    			$item[$k]['content'] = $item_data['content'];
						}
		    	}
		    	
			}
			
		} else { 	
			
			$sql = '
			SELECT pc.*
			FROM `'._DB_PREFIX_.'blocknews` pc
			WHERE id = '.$id;
			
			$item = Db::getInstance()->ExecuteS($sql);
			
			foreach($item as $k => $_item){
				
				$items_data = Db::getInstance()->ExecuteS('
				SELECT pc.*
				FROM `'._DB_PREFIX_.'blocknews_data` pc
				WHERE pc.id_item = '.$_item['id'].'
				');
				
				foreach ($items_data as $item_data){
		    			$item['data'][$item_data['id_lang']]['title'] = $item_data['title'];
		    			$item['data'][$item_data['id_lang']]['content'] = $item_data['content'];
		    		
		    	}
		    	
			}
		}
			
	   return array('item' => $item);
	}
	
	
	public function updateItem($data){
		
		$id = $data['id'];
		
		$item_status = $data['item_status'];
		$post_images = $data['post_images'];
		
		// update
		$sql = 'UPDATE `'._DB_PREFIX_.'blocknews` SET
							   `status` = \''.pSQL($item_status).'\'
							   WHERE id = '.$id.'
							   ';
		defined('_MYSQL_ENGINE_')?$result = Db::getInstance()->ExecuteS($sql):$result = Db::getInstance()->Execute($sql);
		
		/// delete tabs data
		$sql = 'DELETE FROM `'._DB_PREFIX_.'blocknews_data` WHERE id_item = '.$id.'';
		defined('_MYSQL_ENGINE_')?$result = Db::getInstance()->ExecuteS($sql):$result = Db::getInstance()->Execute($sql);
		
		foreach($data['data_title_content_lang'] as $language => $item){
		
		$title = $item['title'];
		$content = $item['content'];
		
		$sql = 'INSERT into `'._DB_PREFIX_.'blocknews_data` SET
							   `id_item` = \''.pSQL($id).'\',
							   `id_lang` = \''.pSQL($language).'\',
							   `title` = \''.pSQL($title).'\',
							   `content` = "'.mysql_escape_string($content).'"
							   ';
		//echo $sql; exit;
		defined('_MYSQL_ENGINE_')?$result = Db::getInstance()->ExecuteS($sql):$result = Db::getInstance()->Execute($sql);
		}
		
		$this->saveImage(array('post_id' => $id,'post_images' => $post_images ));
	}
	
	public function getItemsBlock(){

			global $cookie;
			$current_language = (int)$cookie->id_lang;
			
			$limit  = Configuration::get('blocknewsfaq_blc');
			$sql = '
			SELECT pc.*
			FROM `'._DB_PREFIX_.'blocknews` pc 
			LEFT JOIN `'._DB_PREFIX_.'blocknews_data` pc_d
			ON(pc.id = pc_d.id_item) 
			WHERE pc.status = 1 and pc_d.id_lang = '.$current_language.' ORDER BY pc.`id` DESC LIMIT '.$limit;
			
			$items = Db::getInstance()->ExecuteS($sql);
			$items_tmp = array();
			foreach($items as $k => $_item){
				$items_data = Db::getInstance()->ExecuteS('
				SELECT pc.*
				FROM `'._DB_PREFIX_.'blocknews_data` pc
				WHERE pc.id_item = '.$_item['id'].'
				');
				
				
				
				foreach ($items_data as $item_data){
		    		if($current_language == $item_data['id_lang']){
		    			$items_tmp[$k]['data'][$item_data['id_lang']]['title'] = $item_data['title'];
		    			$items_tmp[$k]['data'][$item_data['id_lang']]['content'] = $item_data['content'];
		    			$items_tmp[$k]['data'][$item_data['id_lang']]['img'] = $_item['img'];
		    			$items_tmp[$k]['data'][$item_data['id_lang']]['time_add'] = $_item['time_add'];
		    			$items_tmp[$k]['data'][$item_data['id_lang']]['id'] = $_item['id'];
		    		}
		    	}
		    	
			}
		return array('items' => $items_tmp );
	}
	
	public function copyImage($data){
	
		$filename = $data['name'];
		$dir_without_ext = $data['dir_without_ext'];
		$width = $this->_width;
		$height = $this->_height;
		
		if (!$width){ $width = 85; };
		if (!$height){ $height = 85; };
		// Content type
		$size_img = getimagesize($filename);
		// Get new dimensions
		list($width_orig, $height_orig) = getimagesize($filename);
		$ratio_orig = $width_orig/$height_orig;
		
		if($width_orig>$height_orig){
		$height =  $width/$ratio_orig;
		}else{ 
		$width = $height*$ratio_orig;
		}
		if($width_orig<$width){
			$width = $width_orig;
			$height = $height_orig;
		}
	
			$image_p = imagecreatetruecolor($width, $height);
		$bgcolor=ImageColorAllocate($image_p, 255, 255, 255);
		//   
		imageFill($image_p, 5, 5, $bgcolor);
	
		if ($size_img[2]==2){ $image = imagecreatefromjpeg($filename);}                         
		else if ($size_img[2]==1){  $image = imagecreatefromgif($filename);}                         
		else if ($size_img[2]==3) { $image = imagecreatefrompng($filename); }
	
		imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
		// Output
		$users_img = $dir_without_ext.'.jpg';
		if ($size_img[2]==2)  imagejpeg($image_p, $users_img, 100);                         
		else if ($size_img[2]==1)  imagejpeg($image_p, $users_img, 100);                        
		else if ($size_img[2]==3)  imagejpeg($image_p, $users_img, 100);
		imageDestroy($image_p);
		imageDestroy($image);
		unlink($filename);

	}
	
	
public function PageNav($start,$count,$step, $_data =null )
	{
		$_admin = isset($_data['admin'])?$_data['admin']:null;
		$post_id = isset($_data['post_id'])?$_data['post_id']:0;
		
		$res = '';
		$product_count = $count;
		$res .= '<div class="pages">';
		$res .= '<span>'.$this->l('Page').':</span>';
		$res .= '<span class="nums">';
		
		$start1 = $start;
			for ($start1 = ($start - $step*4 >= 0 ? $start - $step*4 : 0); $start1 < ($start + $step*5 < $product_count ? $start + $step*5 : $product_count); $start1 += $step)
				{
					$par = (int)($start1 / $step) + 1;
					if ($start1 == $start)
						{
						
						$res .= '<b>'. $par .'</b>';
						}
					else
						{
							if($_admin){
								$currentIndex = $_data['currentIndex'];
								$token = $_data['token'];
								$item = $_data['item'];
								$res .= '<a href="'.$currentIndex.'&page'.$item.'='.($start1 ? $start1 : 0).$token.'" >'.$par.'</a>';
							} else {
								
								$res .= '<a href="javascript:void(0)" onclick="go_page_news( '.($start1 ? $start1 : 0).' )">'.$par.'</a>';
								
							}
						}
				}
		
		$res .= '</span>';
		$res .= '</div>';
		
		
		return $res;
	}
	
	public function getTranslateText(){
		return array('seo_text'=> $this->l('News'));
	}
	
}