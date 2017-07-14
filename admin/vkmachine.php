<?php
defined('_JEXEC') or ( $_SERVER['REMOTE_ADDR'] == $_SERVER['SERVER_ADDR'] ) or die('Restricted access');

if (!defined('_JEXEC')){
    define('_JEXEC', 1);
    define('_JEXEC_CRON', 1);
    define('DS', DIRECTORY_SEPARATOR);    
    define('JPATH_BASE', preg_replace('/(?:\/[\w\-]+){3}$/', '', dirname(__FILE__)));
    
    require_once (JPATH_BASE .DS.'includes'.DS.'defines.php');
    require_once (JPATH_BASE .DS.'includes'.DS.'framework.php');
	
	define('JPATH_COMPONENT_ADMINISTRATOR', JPATH_ADMINISTRATOR.DS.'components'.DS.'com_vkmachine');
}

JLoader::registerPrefix('Vkmachine', JPATH_COMPONENT_ADMINISTRATOR);

VkmachineHelpersCron::cron();

$controller = JControllerLegacy::getInstance('Vkmachine');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();