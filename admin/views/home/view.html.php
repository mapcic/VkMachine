<?php
defined('_JEXEC') or die;
 
class VkmachineViewHome extends JViewLegacy {
	protected $items;
	protected $pagination;
	protected $state;

	public function display($tpl = null) {
		$this->state		= $this->get('State');
		$this->items		= $this->get('Items');
		$this->pagination	= $this->get('Pagination');
		$this->info			= $this->get('Info');
		$this->sortColumn 	= $this->state->get('list.ordering');
		$this->sortDirection = $this->state->get('list.direction');
		
		$this->addToolbar();
		$this->sidebar = JHtmlSidebar::render();

		parent::display($tpl);
	}

	protected function addToolbar() {
		$help_url 	= 'http://shliambur.ru/';

		JToolbarHelper::title(JText::_('COM_VKMACHINE'), 'vknews.png');
		( empty($this->info['page']) )? JToolbarHelper::custom( 'setting.add', 'wrench', '', 'COM_VKMACHINE_HOME_PARAMS', false ) : JToolbarHelper::custom( 'setting.edit', 'wrench', '', 'COM_VKMACHINE_HOME_PARAMS', false );
		
		JToolbarHelper::addNew('ht.add', 'COM_VKMACHINE_HOME_HT_ADD');
		
		( empty($this->info['pageId']) )? '' : JToolbarHelper::custom('add.manual', 'user', '', 'COM_VKMACHINE_HOME_MANUAL_LAUNCH', false );
		
		JToolbarHelper::help('COM_PRICELEAF_VIEW_TYPE1', false, $help_url);
	}
}