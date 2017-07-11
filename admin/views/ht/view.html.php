<?php
defined('_JEXEC') or die;
 
class VkmachineViewHt extends JViewLegacy {
	protected $state;
	protected $item;
	protected $form;

	public function display($tpl = null) {
		$this->state 	= $this->get('State');
		$this->item		= $this->get('Item');
		$this->form		= $this->get('Form');

		$this->addToolbar();
		
		parent::display($tpl);
	}

	protected function addToolbar() {
		JFactory::getApplication()->input->set('hidemainmenu', true);

		$isNew		= ($this->item->id == 0);
		$help_url 	= 'http://shliambur.ru/';

		( $isNew )? JToolbarHelper::title(JText::_('COM_VKMACHINE_HT_NEW')) : JToolbarHelper::title(JText::_('COM_VKMACHINE_HT_CHANGE'));
		JToolbarHelper::apply('ht.apply');
		JToolbarHelper::save('ht.save');
		( $isNew )? JToolbarHelper::cancel('ht.cancel') : JToolbarHelper::cancel('ht.cancel', 'JTOOLBAR_CLOSE');
		JToolbarHelper::divider();
		JToolbarHelper::help('COM_PRICELEAF_VIEW_TYPE1', false, $help_url );
	}
}