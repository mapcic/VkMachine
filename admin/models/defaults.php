<?php
defined('_JEXEC') or die;

class VkmachineModelsDefaults extends JModelList {
	protected $info = array();
	protected $tmpl = 'pirat';

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
	    $this->info['beginCode'] = ( !empty($resp) )? $resp->beginCode : '';
	    $this->info['endCode'] = ( !empty($resp) )? $resp->endCode : '';

	    $query = $db->getQuery(true)
	    	->select($db->quoteName(array('license', 'lastLaunch')))
	        ->from($db->quoteName('#__vkmachine_license'))
	        ->order($db->quoteName('id').' DESC');
	    $resp = $db->setQuery($query)->loadObject();
	    
	    $this->info['license'] = (int)$resp->license;
	    $this->info['status'] = ( date('U') < $this->info['license'] )? JText::_('COM_VKMACHINE_HOME_INFO_STATUS_LICENSE') : JText::_('COM_VKMACHINE_HOME_INFO_STATUS_PIRAT'); 
        $this->info['lastManualLaunch'] = $resp->lastLaunch;

	    return $this->info;
	}
	
	public function getTmpl() {
	    $db = JFactory::getDbo();
	    $query = $db->getQuery(true);

	    $query->select($db->quoteName('template'))
	          ->from($db->quoteName('#__vkmachine_license'))
	          ->order($db->quoteName('id').' DESC');
	    $db->setQuery($query);
	    
		$this->tmpl = ((int)$db->loadResult() == 1)? 'license':'pirat';
		return $this->tmpl;
	}
}