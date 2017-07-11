<?php
defined('_JEXEC') or die;

class VkmachineControllerCrons extends JControllerAdmin {
	public function getModel( $name = 'Cron', $prefix = 'VkmachineModel', $config = array('ignore_request' => true )) {
		return parent::getModel($name, $prefix, $config);
	}

	public function delete( ) {

		JFactory::getApplication()->input->set( 'cid', array($this->_getCronId()) );

		$this->off();

		parent::delete();
	}

	public function on( ) {
		$this->off();
		
		$data = $this->_loadCronNode();
			$data->path = JPATH_COMPONENT_ADMINISTRATOR.'/vkmachine.php';
			$data->php = preg_replace( '/\s+/', '', shell_exec('which php') );
			$data->time = '* * * * *';
			$data->state = 1;
		$time = array('*', '*', '*', '*', '*');
			$time[0] = ( $data->minute > 59 )? 0 : $data->minute;
			$time[1] = ( $data->hour > 23 )? 1 : $data->hour;
			$time[$data->partOf -1] = ( $data->partOf == 5 )? (( $data->interval >= 7 )? 0 : $data->interval) : '*/'.$data->interval;
		$data->time = implode(' ', $time);
	
		if ( JFactory::getDbo()->updateObject('#__vkmachine_crons', $data, 'id') ){
            $cronTasks = shell_exec('crontab -l'); 
	        $cronTask = $data->time.' '.$data->php.' '.$data->path.' '.$data->args.PHP_EOL;
	        
	        $cronTasks = $cronTasks.$cronTask;

	        file_put_contents( JPATH_COMPONENT_ADMINISTRATOR.'/crontab.txt', $cronTasks);
	        exec('crontab '.JPATH_COMPONENT_ADMINISTRATOR.'/crontab.txt');
	        file_put_contents( JPATH_COMPONENT_ADMINISTRATOR.'/crontab.txt', '');
		}
		
		$previosView = JFactory::getApplication()->input->get('previos_view', '');
		$this->setRedirect(JRoute::_('index.php?option=' . $this->option . '&view=' .( ( !empty($previosView) )? $previosView : $this->view_list), false));
	}

	public function off( ) {
		
		$data = $this->_loadCronNode();	
			$data->state = ( $data->state == 0 )? 1 : 0;

		if ( $data->state == 0 && JFactory::getDbo()->updateObject('#__vkmachine_crons', $data, 'id') ){
            $cronTasks = shell_exec('crontab -l'); 
	        $cronTask = $data->time.' '.$data->php.' '.$data->path.' '.$data->args.PHP_EOL;
	        
	        $cronTasks = str_replace($cronTask, '', $cronTasks);

	        file_put_contents( JPATH_COMPONENT_ADMINISTRATOR.'/crontab.txt', $cronTasks);
	        exec('crontab '.JPATH_COMPONENT_ADMINISTRATOR.'/crontab.txt');
	        file_put_contents( JPATH_COMPONENT_ADMINISTRATOR.'/crontab.txt', '');
		}
		
		$previosView = JFactory::getApplication()->input->get('previos_view', '');	
		$this->setRedirect(JRoute::_('index.php?option=' . $this->option . '&view=' .( ( !empty($previosView) )? $previosView : $this->view_list), false));
	}

	protected function _getCronId( ) {
		$db = JFactory::getDbo();
		$query = $db->getQuery(true)
			->select( $db->quoteName('id') )
			->from( $db->quoteName('#__vkmachine_crons') );
		
		$db->setQuery($query);

		return (int)$db->loadResult();	
	}

	protected function _loadCronNode( ) {
		$db = JFactory::getDbo();
		$query = $db->getQuery(true)
			->select( '*' )
			->from( $db->quoteName('#__vkmachine_crons') )
			->where( $db->quoteName('id').' = '.$this->_getCronId() );		
		$db->setQuery($query);

		return $db->loadObject();	
	}
}