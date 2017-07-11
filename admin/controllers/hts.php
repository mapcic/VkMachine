<?php
defined('_JEXEC') or die;

class VkmachineControllerHts extends JControllerAdmin {
	public function getModel( $name = 'Ht', $prefix = 'VkmachineModel', $config = array('ignore_request' => true )) {
		return parent::getModel($name, $prefix, $config);
	}
}