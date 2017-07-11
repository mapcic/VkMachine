<?php
defined('_JEXEC') or die;
 
class VkmachineViewCrons extends JViewLegacy {
	protected $items;
	protected $pagination;
	protected $state;

	public function display($tpl = null) {
		$this->state	= $this->get('State');
		$this->items	= $this->get('Items');
		$this->info		= $this->get('Info');
		$this->tmpl		= $this->get('Tmpl');

		$this->addToolbar();
		$this->sidebar = JHtmlSidebar::render();
		
		parent::display($tpl);
	}

	protected function addToolbar() {
		$help_url 	= 'http://shliambur.ru/';

		JToolbarHelper::title(JText::_('COM_VKMACHINE_CRONS'), 'vkmachine.png');

		if ( $this->info['cronExists'] ) {
			JToolbarHelper::custom('cron.edit', 'edit', '', 'COM_VKMACHINE_CRONS_EDIT', false);
			JToolbarHelper::custom('crons.delete', 'delete', '', 'COM_VKMACHINE_CRONS_DELETE', false);
			if ( !empty($this->info['pageId']) ) {
				( $this->info['cronActive'] )? JToolbarHelper::custom( 'crons.off', 'pause', '', 'COM_VKMACHINE_CRONS_OFF', false ) : JToolbarHelper::custom( 'crons.on', 'play', '', 'COM_VKMACHINE_CRONS_ON', false );
			}
		}else{
			JToolbarHelper::addNew('cron.add', 'COM_VKMACHINE_CRONS_CRON_ADD');
		}

		JToolbarHelper::help('COM_PRICELEAF_VIEW_TYPE1', false, $help_url);
	}
}