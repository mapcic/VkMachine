<?php
defined('_JEXEC') or die;

class VkmachineHelpersCron {
	public static $extension = 'com_vkmachine';

	public static function cron() {
		if (!defined('_JEXEC_CRON')) {
			return 0;
		}

	    JLoader::register('VkmachineModelAdd', JPATH_COMPONENT_ADMINISTRATOR.'/models/add.php');
		JFactory::getApplication('administrator')->initialise();
	    
	    $model = new VkmachineModelAdd();
	    $model->vkNews();
	    
	    exit;
	}
}