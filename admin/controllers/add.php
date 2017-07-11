<?php
defined('_JEXEC') or die;

class VkmachineControllerAdd extends JControllerAdmin {
	public function getModel( $name = 'Add', $prefix = 'VkmachineModel', $config = array('ignore_request' => true )){
		return parent::getModel($name, $prefix, $config);
	}

	public function manual(){
		$this->getModel()->vkNews( true );
		$previosView = JFactory::getApplication()->input->get('previos_view', 'home');
		$this->setRedirect(JRoute::_('index.php?option=' . $this->option . '&view=' .( ( !empty($previosView) )? $previosView : $this->view_list), false));
	}
}