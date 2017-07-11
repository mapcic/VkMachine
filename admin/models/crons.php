<?php
defined('_JEXEC') or die;
class VkmachineModelCrons extends VkmachineModelsDefaults {
	public function __construct($config = array()) {   
		$config['filter_fields'] = array(
			'id',
			'partOf',
			'interval',
			'minute',
			'hour',
			'phpPath',
			'cronTime',
			'filePath'
		);
		parent::__construct($config);
	}
    
    protected function getListQuery() {
        $db = JFactory::getDBO(); 
        $query = $db->getQuery(true);

        $query->select('*')
    		->from($db->quoteName('#__vkmachine_crons'));
        return $query;
    }

    public function getInfo() {
    	$db = JFactory::getDbo();
    	$query = $db->getQuery(true)
    		->select('*')
    		->from($db->quoteName('#__vkmachine_crons'));
    	$resp = $db->setQuery($query)->loadObject(); 

    	$this->info['cronExists'] = ( !empty($resp) )? true : false ;
    	$this->info['cronActive'] = ( !empty($resp) && $resp->state == 1 )? true : false;
    	
        $this->info['units'] = array();
            $this->info['units']['partOf'] = array();
                $this->info['units']['partOf'][2] = 'COM_VKMACHINE_CRONS_PARTOF_HOUR';
                $this->info['units']['partOf'][3] = 'COM_VKMACHINE_CRONS_PARTOF_DAY';
                $this->info['units']['partOf'][5] = 'COM_VKMACHINE_CRONS_PARTOF_WEEK';
            $this->info['units']['interval'] = array(); 
                $this->info['units']['interval'][1] = 'COM_VKMACHINE_CRONS_INTERVAL_MONDAY'; 
                $this->info['units']['interval'][] = 'COM_VKMACHINE_CRONS_INTERVAL_TUESDAY'; 
                $this->info['units']['interval'][] = 'COM_VKMACHINE_CRONS_INTERVAL_WEDNESDAY'; 
                $this->info['units']['interval'][] = 'COM_VKMACHINE_CRONS_INTERVAL_THURSDAY'; 
                $this->info['units']['interval'][] = 'COM_VKMACHINE_CRONS_INTERVAL_FRIDAY'; 
                $this->info['units']['interval'][] = 'COM_VKMACHINE_CRONS_INTERVAL_SATURDAY'; 
                $this->info['units']['interval'][] = 'COM_VKMACHINE_CRONS_INTERVAL_SUNDAY'; 

    	return parent::getInfo();
    }
}