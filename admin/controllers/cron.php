<?php
defined('_JEXEC') or die;
 
class VkmachineControllerCron extends JControllerForm {
	public function add( ){
		$cronId = $this->_getCronId();
		if ( empty($cronId) ){
			return parent::add();
		} 
		$this->setRedirect(JRoute::_('index.php?option=' . $this->option . '&view=' . $this->view_list, false));
	}

	public function edit( $key = NULL, $urlVar = NULL ) {
		JFactory::getApplication()->input->post->set( 'cid', array($this->_getCronId()) );

		parent::edit( );
	}

	public function save( $key = null, $urlVar = null ) {
		$active = JFactory::getApplication()->input->get->get('id', '');
		$active = !empty( $active );

		if( $active ){
			$state = $this->_loadCronNode()->state;
			$this->_off();
		}
		
		parent::save();

		( $active && $state )? $this->_on() : '';
	}

	protected function _off( ) {
		$data = $this->_loadCronNode();
			$data->state = ( $data->state == 0 )? 1 : 0;

		if ( $data->state == 0 && JFactory::getDbo()->updateObject('#__vkmachine_crons', $data, 'id') ){
            $cronTasks = shell_exec('crontab -l'); 
	        $cronTask = $data->time.' '.$data->php.' '.$data->path.' '.$data->args.PHP_EOL;
	        
	        $cronTasks = str_replace($cronTask, '', $cronTasks);

	        file_put_contents( JPATH_COMPONENT_ADMINISTRATOR.'/crontab.txt', $cronTasks);
	        exec('crontab '.JPATH_COMPONENT_ADMINISTRATOR.'/crontab.txt');
	        file_put_contents( JPATH_COMPONENT_ADMINISTRATOR.'/crontab.txt', '');

	        return 1;
		}

		return 0;		
	}

	protected function _on( ) {
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