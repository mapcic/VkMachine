<?php
defined('_JEXEC') or die;
 
class VkmachineModelCron extends VkmachineModelsDefault {
	protected $text_prefix = 'COM_VKMACHINE';	 
	 
	public function getTable( $type = 'Cron', $prefix = 'VkmachineTable', $config = array() ) {
		return JTable::getInstance($type, $prefix, $config);
	}

	public function getForm($data = array(), $loadData = true) {
		$form = $this->loadForm('com_vkmachine.cron', 'cron', array('control' => 'jform', 'load_data' => $loadData));
		$form = (empty( $form ))? false : $form;

		return $form;
	}
	
	protected function loadFormData() {
		$data = JFactory::getApplication()->getUserState('com_vkmachine.edit.cron.data', array());
		$data = (empty( $data ))? $this->getItem() : $data;

		return $data;
	}
}