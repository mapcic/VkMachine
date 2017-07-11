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

		if(!preg_match('/\?domain='.$domain.'$/', $response->location)) {
			$response->location .= $domain;
			$db->updateObject('#__update_sites',$response, 'update_site_id');	
		}
		
		$query = $db->getQuery(true);
		$query->select('*')
			->from($db->qn('#__vkmachine_license'))
			->order($db->qn('id').' DESC');
		$db->setQuery($query);
		
		$localLicense = $db->loadObject();

		if( empty($localLicense) ) {
			$response = json_decode(file_get_contents('http://machine.shliambur.ru/vkmachine.checkLicense?domain='.$domain));
		    $data = new stdClass();
				$data->license = (int)$response->license;
				$data->tempLicense = $date+(int)$response->tempLicense;
				$data->template = ((int)$response->license > $date)?1:0;
			$db->insertObject('#__vkmachine_license', $data);
		}elseif( $localLicense->tempLicense < $date ) {
			$response = json_decode(file_get_contents('http://machine.shliambur.ru/vkmachine.checkLicense?domain='.$domain));
			
			$localLicense->license = 0;
			$localLicense->tempLicense = 6*60*60;
			$localLicense->template = 0;

			if ( !empty($response) && property_exists($response, 'license') ) {	
				$localLicense->license = (int)$response->license;
				$localLicense->tempLicense = $date+(int)$response->tempLicense;
				$localLicense->template = ((int)$response->license > $date)?1:0;
			}
			
			$db->updateObject('#__vkmachine_license', $localLicense, 'id');
		}
	}
}