<?php
defined('_JEXEC') or die;
 
class VkmachineViewCron extends JViewLegacy {
	protected $state;
	protected $item;
	protected $form;

	public function display($tpl = null) {
		$this->state 	= $this->get('State');
		$this->item		= $this->get('Item');
		$this->form		= $this->get('Form');
		$this->formatFieldset	= $this->getFormatFieldset();

		$this->addToolbar();
		
		parent::display($tpl);
	}

	protected function addToolbar() {
		JFactory::getApplication()->input->set('hidemainmenu', true);

		$isNew		= ($this->item->id == 0);
		$help_url 	= 'http://shliambur.ru/';

		( $isNew )? JToolbarHelper::title(JText::_('COM_VKMACHINE_CRON_NEW')) : JToolbarHelper::title(JText::_('COM_VKMACHINE_CRON_CHANGE'));
		JToolbarHelper::apply('cron.apply');
		JToolbarHelper::save('cron.save');
		( $isNew )? JToolbarHelper::cancel('cron.cancel') : JToolbarHelper::cancel('cron.cancel', 'JTOOLBAR_CLOSE');
		JToolbarHelper::divider();
		JToolbarHelper::help( 'COM_PRICELEAF_VIEW_TYPE1', false, $help_url );
	}

	protected function getFormatFieldset() {
		$groupRegexp = array();
			$groupRegexp['general'] = array(
				'partOf',
				'interval2', 
				'interval3', 
				'interval5'
			);
			$groupRegexp['common'] = array(
				'minute',
				'hour'
			);
			$groupRegexp['hidden'] = array(
				'id',
				'interval'
			);
		$formatFieldset = array();
			$formatFieldset['general'] = array();
			$formatFieldset['common'] = array();
			$formatFieldset['hidden'] = array();
		
		// format elems of groupRegexp like "/[A-Za-z]*\[<exp>\]/"
		foreach ($groupRegexp as $keys => $vals) {
			foreach ($vals as $key => $val) {
				$groupRegexp[$keys][$key] = '/[A-Za-z]*\['.$val.'\]/';
			}
		}
		// Fill the $formatFieldset array
		foreach ( $this->form->getFieldset() as $val ) {
			foreach ( $groupRegexp as $key => $regexps ) {
				foreach ( $regexps as $regexp ) {
					if ( preg_match( $regexp, $val->name ) ) {
						$formatFieldset[$key][] = $val;
						break;
					} 
				}
			}
		}

		return $formatFieldset;
	}
}