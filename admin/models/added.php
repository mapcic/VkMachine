<?php
defined('_JEXEC') or die;
 
class VkmachineModelAdded extends VkmachineModelsDefault {
	protected $text_prefix = 'COM_VKMACHINE';	 
	 
	public function getTable($type = 'Added', $prefix = 'VkmachineTable', $config = array()) {
		return JTable::getInstance($type, $prefix, $config);
	}
}