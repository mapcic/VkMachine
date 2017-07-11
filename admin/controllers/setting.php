<?php
defined('_JEXEC') or die;

class VkmachineControllerSetting extends JControllerForm {
	public function edit( $key = NULL, $urlVar = NULL ){
		JFactory::getApplication()->input->post->set( 'cid', array( $this->_getSettingId() ) );
		parent::edit( $key, $urlVar );
	}

	// Add check id
	public function save( $key = NULL, $urlVar = NULL ){
		parent::save( $key, $urlVar );
		$task = $this->getTask();
		if ( $task == "save" ) { 
			$this->setRedirect(JRoute::_('index.php?option='.$this->option));
		}
	}

	public function cancel( $key = null ){
		parent::cancel( $key );
		$this->setRedirect(JRoute::_('index.php?option='.$this->option));
	}

	protected function _getSettingId(){
		$db = JFactory::getDbo();
		$query = $db->getQuery(true)
			->select($db->quoteName('id'))
			->from($db->quoteName('#__vkmachine_settings'))
			->order($db->quoteName('id').' ASC');
		$resp = $db->setQuery($query)->loadResult();
		return $resp;
	}
}