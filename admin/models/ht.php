<?php
defined('_JEXEC') or die;
 
class VkmachineModelHt extends VkmachineModelsDefault {
	protected $text_prefix = 'COM_VKMACHINE';	 
	 
	public function getTable( $type = 'ht', $prefix = 'VkmachineTable', $config = array() ) {
		return JTable::getInstance($type, $prefix, $config);
	}

	public function getForm( $data = array(), $loadData = true ) {
		$form = $this->loadForm('com_vkmachine.ht', 'ht', array('control' => 'jform', 'load_data' => $loadData));
		$form = (empty( $form ))? false : $form;

		return $form;
	}
	
	protected function loadFormData( ) {
		$data = JFactory::getApplication()->getUserState('com_vkmachine.edit.ht.data', array());
		$data = (empty( $data ))? $this->getItem() : $data;

		return $data;
	}
}