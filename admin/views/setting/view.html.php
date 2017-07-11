<?php
defined('_JEXEC') or die;
 
class VkmachineViewSetting extends JViewLegacy {
	protected $_state;
	protected $_item;
	protected $_form;
	protected $_formatFieldset;

	public function display($tpl = null) {
		$this->_state 			= $this->get('State');
		$this->_item			= $this->get('Item');
		$this->_form			= $this->get('Form');
		$this->_formatFieldset	= $this->getFormatFieldset();

		$this->addToolbar();
		
		parent::display($tpl);
	}

	protected function addToolbar() {
		JFactory::getApplication()->input->set('hidemainmenu', true);
		$help_url 	= 'http://shliambur.ru/';

		JToolbarHelper::title(JText::_('COM_VKMACHINE_SETTING'));
		JToolbarHelper::apply('setting.apply');
		JToolbarHelper::save('setting.save');
		JToolbarHelper::cancel('setting.cancel', 'JTOOLBAR_CLOSE');
		
		JToolbarHelper::divider();
		
		JToolbarHelper::help( 'COM_PRICELEAF_VIEW_TYPE1', false, $help_url );
	}

	protected function getFormatFieldset() {
		$groupRegexp = array(
			'general' => array( 'page' ),
			'common' => array( 'type', 'beginCode', 'endCode', 'lang' ),
			'hidden' => array( 'id' , 'pageId', 'pageName' )  
		);

		$formatFieldset = array(
			'general' => array(),
			'common' => array(),
			'hidden' => array()
		);
		// format elems of groupRegexp like "/[A-Za-z]*\[<exp>\]/"
		foreach ($groupRegexp as $keys => $vals) {
			foreach ($vals as $key => $val) {
				$groupRegexp[$keys][$key] = '/[A-Za-z]*\['.$val.'\]/';
			}
		}
		// Fill the $formatFieldset array
		foreach ( $this->_form->getFieldset() as $val ) {
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