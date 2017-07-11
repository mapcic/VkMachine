<?php

defined('_JEXEC') or die;

class VkmachineControllerHome extends JControllerAdmin {
	public function getModel($name = 'Added', $prefix = 'VkmachineModel', $config = array('ignore_request' => true)){
		return parent::getModel($name, $prefix, $config);
	}
}
