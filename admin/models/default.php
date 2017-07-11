<?php defined('_JEXEC') or die;

abstract class VkmachineModelsDefault extends JModelAdmin
{  
	protected $_vkData = array();

	function __construct(){
		$this->_getVkData();
		parent::__construct();
  	}

	protected function _getVkData(){
	    $db = JFactory::getDbo();
		
		$query = $db->getQuery(true)
			->select($db->quoteName('id'))
	      	->from($db->quoteName('#__vkmachine_added')); 
	    
	    $db->setQuery($query);
	    
		$this->_vkData['resultIds'] = $db->loadColumn();

	    $query = $db->getQuery(true)
	      	->select($db->quoteName('hashtag'))
	      	->from($db->quoteName('#__vkmachine_hts'))
	      	->where($db->quoteName('state').' = 1');    
	    
	    $db->setQuery($query);
	    
		$this->_vkData['resultHashtags'] = $db->loadColumn();
	}

}