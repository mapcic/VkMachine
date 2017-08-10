<?php
defined('_JEXEC') or die;
 
class VkmachineModelAdd extends VkmachineModelsDefault {

	protected $text_prefix = 'COM_VKMACHINE';

  	protected $_params = '';
	
	protected $_dataImages = '{"image_intro":"","float_intro":"","image_intro_alt":"","image_intro_caption":"","image_fulltext":"","float_fulltext":"","image_fulltext_alt":"","image_fulltext_caption":""}';
	
	protected $_dataUrls = '{"urla":false,"urlatext":"","targeta":"","urlb":false,"urlbtext":"","targetb":"","urlc":false,"urlctext":"","targetc":""}';
	
	protected $_dataAttribs = '{"show_title":"","link_titles":"","show_tags":"","show_intro":"","info_block_position":"","show_category":"","link_category":"","show_parent_category":"","link_parent_category":"","show_author":"","link_author":"","show_create_date":"","show_modify_date":"","show_publish_date":"","show_item_navigation":"","show_icons":"","show_print_icon":"","show_email_icon":"","show_vote":"","show_hits":"","show_noauth":"","urls_position":"","alternative_readmore":"","article_layout":"","show_publishing_options":"","show_article_options":"","show_urls_images_backend":"","show_urls_images_frontend":""}';
	
	protected $_dataMetadata = '{"robots":"","author":"","rights":"","xreference":""}';
	
	protected $_paramsMenu = '{"show_title":"","link_titles":"","show_intro":"","info_block_position":"","show_category":"","link_category":"","show_parent_category":"","link_parent_category":"","show_author":"","link_author":"","show_create_date":"","show_modify_date":"","show_publish_date":"","show_item_navigation":"","show_vote":"","show_icons":"","show_print_icon":"","show_email_icon":"","show_hits":"","show_tags":"","show_noauth":"","urls_position":"","menu-anchor_title":"","menu-anchor_css":"","menu_image":"","menu_text":1,"page_title":"","show_page_heading":"0","page_heading":"","pageclass_sfx":"","menu-meta_description":"","menu-meta_keywords":"","robots":"","secure":0}';
  
	public function __construct() {     
		parent::__construct();
		
		$db = JFactory::getDbo();
		$query = $db->getQuery(true)
			->select( $db->quoteName( array(
				'endCode', 
				'beginCode', 
				'pageId',
				'skey',
				'lang'
				) ) )
			->from( $db->quoteName('#__vkmachine_settings') )
			->order( $db->quoteName('id').' DESC' );
		$this->_params = $db->setQuery($query)->loadObject();
		if ( empty($this->_params->lang) ) {
			$this->_lang = JFactory::getLanguage()->getDefault();
		} else {
			$this->_lang = $this->_params->lang;
		}
	}

	public function getForm($data = array(), $loadData = true) {
	}

	public function getTable($type = 'Added', $prefix = 'VkmachineTable', $config = array()) {
		return JTable::getInstance($type, $prefix, $config);
	}

	protected function _makeTitle( &$text ) {
		preg_match( '/^(?:[^\s\.\?\!\:\ ]+\ *)+[\s\.\?\!\:(?:<br>)]*/', $text, $titleDirtArr );
		$title = $titleDirtArr[0];

		if ( preg_match_all( '/(?:[^\s\.\?\!\:\ ])+/', $title, $all) <= 10 ) {
		     $text = preg_replace( '/^'.$title.'\s*/', '', $text );
		} else {
		    preg_match( '/^(?:[^\s\.\?\!\:\ ]+\ *){10}[\s\.\?\!\:(?:<br>)]*/', $text, $titleDirtArr );
		    $title = $titleDirtArr[0];
		}

		while ( preg_match( '/[\.,\ \:\;\-\—\?\!]$/',$title ) != 0 ) {
			$title = substr($title,0,strlen($title)-1);
		}

		return $title;
	}

	protected function _makeAlias($text) {
		$lang  = JLanguage::getInstance('ru-RU');
		$text  = preg_replace('/\s*$/','',$text);
		$translite = preg_replace('/["\'»«]+/','',$lang->transliterate($text));
		$translite = preg_replace('/[, \\:\/—;\?!\-=<>\|\$\%\@\#\~\^\(\)"»«]+/','-',$translite);

		return JFilterOutput::stringURLSafe($translite);
	}

	protected function _makeMeta(&$text) {
		$metaArr  = array();
		$arr      = array();
		$metaArr['desArticle'] = '';
		$metaArr['keyArticle'] = '';

		preg_match('/^key#(.*)$/m', $text, $arr);
		if ( !empty($arr) ) {
			$metaArr['keyArticle'] = preg_replace('/(?:^\s*|\.$)/','',$arr[1]);
			$text = preg_replace('/^key#.*$/m','',$text);
		}

		preg_match('/^des#(.*)$/m', $text, $arr);
		if ( !empty($arr) ) {
			$metaArr['desArticle'] = preg_replace('/^\s*/','',$arr[1]);
			$text = preg_replace('/^des#.*$/m','',$text);
		}

		$text = preg_replace('/\n+$/','',$text);
		$text = preg_replace('/^\n+/','',$text);

		return $metaArr;
	}

	protected function _getSrc( $request ) {
		if ( !property_exists( $request, 'attachments') && !property_exists( $request->attachments, 'attachments') ) {
			return array();
		}

		return $request->attachments[0]->photo->src_big;
	}
  
  	// @dateNow format is Y-m-d H:i:s
	protected function _createArticle($request, $hashtag) {
		$db           = JFactory::getDbo();
		$dateNow      = JFactory::getDate('now');
		$componentID  = 0;
		$alias        = '';
		$addVideo     = '';
		$title        = '';
		$path         = '';
		$metaArr      = array();

	    $query = $db->getQuery(true)
			->select($db->quoteName(array(
			    'menutype',
			    'parent_id',
			    'user_id'
			)))
	        ->from($db->quoteName('#__vkmachine_hts'))
	        ->where($db->quoteName('hashtag').' = '.$db->quote($hashtag));
	    $db->setQuery($query);
    
	    $menu_params = $db->loadAssoc();

	    $query = $db->getQuery(true)
			->select($db->quoteName('extension_id'))
			->from($db->quoteName('#__extensions'))
			->where($db->quoteName('name').' = '.$db->quote('com_content'));
	    $db->setQuery($query);
    
	    $componentID = $db->loadResult();

		$src = $this->_getSrc($request);
		$addImg = ( !empty($src) )? '<div class="divVkNews"><img class="imgVkNews" src="'.$src.'" alt=""/></div>' : '';

		$metaArr = $this->_makeMeta($request->text);
		$title = $this->_makeTitle($request->text);
		$alias = $this->_makeAlias($title);
    
		$request->text = preg_replace('/^Источник:.*(?:http|ssh|https|www|\.(?:ru|ua|com|uk|net|gb)).*$/m','',$request->text);
		$request->text = preg_replace('/\n+/','<br><br>',$request->text);

		$data_array = array();
			$data_array['title'] = $title;
			$data_array['alias'] = $alias;
			$data_array['introtext'] = $this->_params->beginCode.$addImg.'<p>'.$request->text.'</p>'.$this->_params->endCode;
			$data_array['fulltext'] = '';
			$data_array['created'] = ( $request->date > (int)$dateNow->format('U') )? (string)$dateNow : date("Y-m-d H:i:s",$request->date);
			$data_array['created_by'] = (int)$menu_params['user_id'];
			$data_array['publish_up'] = (string)$dateNow;
			$data_array['catid'] = 2;
			$data_array['state'] = 1;
			$data_array['metakey'] = '';
			$data_array['metadesc'] = '';
			$data_array['featured'] = 0;
			$data_array['access'] = 1;
			$data_array['images'] = $this->_dataImages;
			$data_array['urls'] = $this->_dataUrls;
			$data_array['attribs'] = $this->_dataAttribs;
			$data_array['metadata'] = $this->_dataMetadata;
			$data_array['language'] = $this->_lang;

		$article = JTable::getInstance('Content');
			$article->bind($data_array);
			
		if ( !$article->store(true) ) {
			return false;
		}
		    	
    	$this->_paramsMenu = json_decode( $this->_paramsMenu );
    		$this->_paramsMenu->{'menu-meta_description'} = $metaArr['desArticle'];
    		$this->_paramsMenu->{'menu-meta_keywords'} = $metaArr['keyArticle'];
    	$this->_paramsMenu = json_encode( $this->_paramsMenu );

		if ( (int)$menu_params['parent_id'] != 1 ) {
			$query = $db->getQuery(true)
				->select($db->quoteName('path'))
				->from($db->quoteName('#__menu'))
				->where($db->quoteName('id').' = '.$db->quote( (int)$menu_params['parent_id'] ));
			$db->setQuery($query);
			
			$path = $db->loadResult().'/';
		}

		$data_array = array();
			$data_array['menutype'] = $menu_params['menutype'];
			$data_array['title'] = $title;
			$data_array['alias'] = $alias;
			$data_array['path'] = $path.$alias;
			$data_array['link'] = 'index.php?option=com_content&view=article&id='.$article->id;
			$data_array['type'] = 'component';
			$data_array['published'] = 1;
			$data_array['component_id'] = $componentID;
			$data_array['access'] = 1;
			$data_array['params'] = $this->_paramsMenu;
			$data_array['language'] = $this->_lang;

		$table = JTable::getInstance('Menu', 'Table');
			$table->setLocation((int)$menu_params['parent_id'], 'first-child');
			$table->bind($data_array);
			$table->store();

		$objAdded = new stdClass();
			$objAdded->id = $request->id;
			$objAdded->id_article = $article->id;
			$objAdded->hashtag = $hashtag;
			$objAdded->created = (string)$dateNow;
		JFactory::getDbo()->insertObject('#__vkmachine_added', $objAdded);
	}


	public function vkNews( $isManual = false ) {
		$match = array();
		$hashtagPattern = '/#(\w+)\s*$/';
		$table = '#__vkmachine';

		$request = json_decode(file_get_contents('https://api.vk.com/api.php?oauth=1&method=wall.get&owner_id='.$this->_params->pageId.'&count=20&access_token='.$this->_params->skey));		
		
		$request = ( property_exists($request, 'response') && count($request->response)>1 )? $request->response : array();
		
		$db = JFactory::getDbo();
		$query = $db->getQuery(true)->select('*')->from($db->quoteName( $table ))->order($db->quoteName('id').' DESC');
		$obj = $db->setQuery($query)->loadObject();

		if (empty($obj)){
			$obj->id = 1;
			$obj->lastLaunch = (string)JFactory::getDate('now');
			$db->insertObject($table, $obj);
		} else {
			$obj->lastLaunch = (string)JFactory::getDate('now');
			$db->updateObject($table, $obj, 'id');
		}
		
		foreach ($request as $req => $val) {
			if ( property_exists( $val, 'id') && property_exists( $val, 'text') && isset($this->_vkData) && ( !in_array($val->id, $this->_vkData['resultIds']) ) ) {
				if ( preg_match( $hashtagPattern, $val->text, $match ) &&  in_array( $match[1], $this->_vkData['resultHashtags'] ) ) {
					$val->text = preg_replace('/#'.$match[1].'/', '', $val->text);
					$val->text = preg_replace('/\<br\>/', "\n", $val->text);
					$this->_createArticle($val, $match[1]);
				}
			}
		}
		return 1;
	}
}