<?php defined('_JEXEC') or die;

class VkmachineHelpersMenu {
	public static $extension = 'com_vkmachine';

	public static function addSubmenu($view) {
		
		$app = JFactory::getApplication();
		$option = "com_vkmachine.".$view;
		$publish = new stdClass();
			$publish->value = 1;
			$publish->text = JText::_('COM_VKMACHINE_FILER_PUBLISHED');
		$unpublish = new stdClass();
			$unpublish->value = 0;
			$unpublish->text = JText::_('COM_VKMACHINE_FILER_UNPUBLISHED');
		$states = array($publish, $unpublish);

		JHtmlSidebar::addEntry(
			JText::_('COM_VKMACHINE_HOME_SUBMENU'),
			'index.php?option=com_vkmachine',
			$view == 'home'
		);
 
		JHtmlSidebar::addEntry(
			JText::_('COM_VKMACHINE_CRONS_SUBMENU'),
			'index.php?option=com_vkmachine&view=crons',
			$view == 'crons'
		);

		JHtmlSidebar::addEntry(
			JText::_('COM_VKMACHINE_HTS_SUBMENU'),
			'index.php?option=com_vkmachine&view=hts',
			$view == 'hts'
		);
		
		JHtmlSidebar::addFilter(
		    JText::_('JOPTION_SELECT_PUBLISHED'),
		    'filter.state',
		    JHtml::_('select.options', $states, "value", "text", $app->getUserStateFromRequest( $option.'.filter.state', 'filter_state'))
		);
	}
}