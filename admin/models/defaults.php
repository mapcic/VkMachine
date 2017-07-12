<?php
defined('_JEXEC') or die;

class VkmachineModelsDefaults extends JModelList {
	protected $info = array();

	public function __construct($config = array()) {   
		parent::__construct($config);
	}

	public function getItems() {
		$items = parent::getItems();
		return ( empty($items) )? array() : $items;
	}
	
	public function getInfo() {
	    $db = JFactory::getDbo();
	    $query = $db->getQuery(true);
	    $xml = JFactory::getXML(JPATH_ADMINISTRATOR .'/components/com_vkmachine/vkmachine.xml');

	    $this->info['version'] = (string)$xml->version;
	 	    
	    $query->select('*')
	    	->from($db->quoteName('#__vkmachine_settings'))
	    	->order($db->quoteName('id').' DESC');
	    $resp = $db->setQuery($query)->loadObject();

	    $this->info['page'] = ( !empty($resp) )? $resp->page : '';
	    $this->info['pageId'] = ( !empty($resp) )? $resp->pageId : '';
	    $this->info['pageName'] = ( !empty($resp) )? $resp->pageName : '';
	    $this->info['skey'] = ( !empty($resp) )? $resp->skey : '';
	    $this->info['beginCode'] = ( !empty($resp) )? $resp->beginCode : '';
	    $this->info['endCode'] = ( !empty($resp) )? $resp->endCode : '';

	    $query = $db->getQuery(true)
	    	->select($db->quoteName(array('lastLaunch')))
	        ->from($db->quoteName('#__vkmachine'))
	        ->order($db->quoteName('id').' DESC');
	    $resp = $db->setQuery($query)->loadObject();
	    
        $this->info['lastLaunch'] = $resp->lastLaunch;

	    return $this->info;
	}
}