<?php
defined('_JEXEC') or die;

class VkmachineController extends JControllerLegacy {
	public function display($cachable = false, $urlparams = false) {
		$view   = $this->input->get('view', 'home');
		$layout = $this->input->get('layout', 'default');
		$id     = $this->input->getInt('id');
		
		$this->input->set('view', $view);

		VkmachineHelpersMenu::addSubmenu($view);

		parent::display();
		
		return $this;
	}
}