<?php
defined('_JEXEC') or die;

class VkmachineHelpersLicense {
	public static $extension = 'com_vkmachine';

	public static function check() {
		$db = JFactory::getDbo();    
		$date = (int) date('U');
	    $pattern = array(
	        '/^(?:https*:\/*|www\.)*/',
	        '/\/.*/'
	    );
	    $domain = preg_replace($pattern, '', JURI::base());

		$query = $db->getQuery(true)
		    ->select('*')
		    ->from($db->quoteName('#__update_sites'))
		    ->where($db->quoteName('name').' = '.$db->quote('VkMachine'));
		$db->setQuery($query);
		$response = $db->loadObject();

		if (!preg_match('/\?domain='.$domain.'$/', $response->location)) {
			$response->location .= $domain;
			$db->updateObject('#__update_sites', $response, 'update_site_id');	
		}
	}
}