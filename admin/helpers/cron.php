<?php
defined('_JEXEC') or die;

class VkmachineHelpersCron {
	public static $extension = 'com_vkmachine';

	public static function check() {
		$db = JFactory::getDbo();
        $cronTasks = shell_exec('crontab -l');

		$query = $db->getQuery( true )
			->select( $db->quoteName('pageId') )
			->from( $db->quoteName('#__vkmachine_settings') )
			->order( $db->quoteName('id').' DESC' );
		$idPage = $db->setQuery( $query )->loadResult();
		
		$query = $db->getQuery( true )
			->select( '*' )
			->from( $db->quoteName('#__vkmachine_crons') )
			->where( $db->quoteName('state').' = 1' );
		$resp = $db->setQuery( $query )->loadObjectList();
		
		$resp = ( empty( $resp ) )? array() : $resp;

		foreach ( $resp as $key => $value ) {
	        $cronTask = $value->time.' '.$value->php.' '.$value->path.' '.$value->args.PHP_EOL;
	        if( !empty( $idPage ) ) {
		        $cronTasks = ( !preg_match('/'.preg_quote($cronTask, '/').'/', $cronTasks) )? $cronTasks.$cronTask : $cronTasks;
	        }else{
	        	$cronTasks = preg_replace( '/'.preg_quote($cronTask, '/').'/' , '', $cronTasks);
	        	$value->state = 0;
	        	JFactory::getDbo()->updateObject('#__vkmachine_crons', $value, 'id');
	        }
		}

        file_put_contents( JPATH_COMPONENT_ADMINISTRATOR.'/crontab.txt', $cronTasks);
        exec('crontab '.JPATH_COMPONENT_ADMINISTRATOR.'/crontab.txt');
        file_put_contents( JPATH_COMPONENT_ADMINISTRATOR.'/crontab.txt', '');
	}

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