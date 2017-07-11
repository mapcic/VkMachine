<?php
defined('_JEXEC') or die;
 
class VkmachineViewHts extends JViewLegacy {
	protected $items;
	protected $pagination;
	protected $state;

	public function display( $tpl = null ) {
		$this->state		= $this->get('State');
		$this->items		= $this->get('Items');
		$this->pagination	= $this->get('Pagination');
		$this->info			= $this->get('Info');
		$this->tmpl			= $this->get('Tmpl');
		$this->sortColumn 	= $this->state->get('list.ordering');
		$this->sortDirection = $this->state->get('list.direction');

		$this->addToolbar();
		$this->sidebar = JHtmlSidebar::render();
		
		parent::display( $tpl );
	}

	protected function addToolbar() {
		$help_url 	= 'http://shliambur.ru/';
		
		JToolbarHelper::title(JText::_('COM_VKMACHINE_HTS'), 'vkmachine.png');
		JToolbarHelper::addNew('ht.add');
		JToolbarHelper::editList('ht.edit');
		JToolbarHelper::publish('hts.publish', 'JTOOLBAR_PUBLISH', true);
		JToolbarHelper::unpublish('hts.unpublish', 'JTOOLBAR_UNPUBLISH', true);
		JToolbarHelper::deleteList('', 'hts.delete');
		JToolbarHelper::help('COM_PRICELEAF_VIEW_TYPE1', false, $help_url);
	}
}