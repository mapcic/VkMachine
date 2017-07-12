<?php
defined('_JEXEC') or die;
class VkmachineModelHome extends VkmachineModelsDefaults {    
    protected $_convertCronTime  = array(
        2 => array(
            'factor' => 3600,
            'interval' => 'COM_VKMACHINE_HOME_HOUR_INTERVAL_HOUR'
            ),
        3 => array(
            'factor' => 86400,
            'interval' => 'COM_VKMACHINE_HOME_HOUR_INTERVAL_DAY'
            ),
        5 => array(
            'factor' => 604800,
            'interval' => array(
                1 => 'COM_VKMACHINE_HOME_INTERVAL_MONDAY',
                2 => 'COM_VKMACHINE_HOME_INTERVAL_TUESDAY',
                3 => 'COM_VKMACHINE_HOME_INTERVAL_WEDNESDAY',
                4 => 'COM_VKMACHINE_HOME_INTERVAL_THURSDAY',
                5 => 'COM_VKMACHINE_HOME_INTERVAL_FRIDAY',
                6 => 'COM_VKMACHINE_HOME_INTERVAL_SATURDAY',
                7 => 'COM_VKMACHINE_HOME_INTERVAL_SUNDAY'
                )
            )
        );

	public function __construct($config = array()) {   
		$config['filter_fields'] = array(
			'id',
			'id_article',
            'created',
			'hashtag'
		);

		parent::__construct($config);
	}
    
    protected function getStoreId($id = '') {
        $id .= ':' . $this->getState('filter.search');
        $id .= ':' . $this->getState('filter.state');
        return parent::getStoreId($id);
    }  

    protected function populateState($ordering = null, $direction = null) {
        $app = JFactory::getApplication('administrator');
        
        $search = $this->getUserStateFromRequest($this->context.'.filter.search', 'filter_search');
        $this->setState('filter.search', $search);
        
        $published = $this->getUserStateFromRequest($this->context.'.filter.state', 'filter_state', '', 'string');
        $this->setState('filter.state', $published);

        $limit = $this->getUserStateFromRequest($this->context.'.list.limit', 'limit', $app->getCfg('list_limit'), 'uint');
        $this->setState('list.limit');

        $params = JComponentHelper::getParams('com_vkmachine');
        $this->setState('params', $params);

        $ordering = $this->getUserStateFromRequest ( $this->context.'.list.ordering', 'filter_order', 'a.id', 'cmd' );
        $this->setState ( 'list.ordering', $ordering );

        $direction = $this->getUserStateFromRequest ( $this->context.'.list.direction', 'filter_order_Dir', 'asc', 'word' );
            $direction = ( $direction == 'asc')? 'asc' : 'desc';
        $this->setState ( 'list.direction', $direction );

        parent::populateState('a.id', 'desc');
    }
    
    protected function getListQuery() {
        $db = JFactory::getDBO(); 
        $query = $db->getQuery(true);
        $selectList = array(
            $db->quoteName('a').'.*',
            $db->quoteName('b.path', 'path'),
            $db->quoteName('b.title','title'),
            $db->quoteName('c.title','menuType'),
            $db->quoteName('d.title', 'titleArtical')
        );

        $query->select($selectList)
    		->from($db->quoteName('#__vkmachine_added', 'a'))
            ->leftJoin(
                $db->quoteName('#__menu', 'b')
                .' ON '.
                $db->quoteName('b.link').' LIKE CONCAT('.$db->quote('%option=com\_content%id=', false).','.$db->quoteName('a.id_article').')'
            )
            ->leftJoin(
                $db->quoteName('#__menu_types', 'c')
                .' ON '.
                $db->quoteName('c.menutype').' = '.$db->quoteName('b.menutype')
            )
            ->leftJoin(
                $db->quoteName('#__content', 'd')
                .' ON '.
                $db->quoteName('a.id_article').' = '.$db->quoteName('d.id')
            )
            ->order( $db->quoteName( $this->getState('list.ordering', 'a.id') ).' '.$db->escape($this->getState('list.direction', 'DESC')) );
        
        $search = $this->getState('filter.search');
        if (!empty($search)) {
            if (stripos($search, 'id:') === 0) {
                $query->where('a.id = '.(int) substr($search, 3));
            } else {
                $search = $db->Quote('%'.$db->escape($search, true).'%');
                $query->where('('.$db->quoteName('b.title').' LIKE '.$search.')');
            }
        }   
        return $query;
    }

    public function getInfo() {
        $comParams = JComponentHelper::getParams('com_vkmachine');
        
        $db = JFactory::getDbo();     
        $query = $db->getQuery(true)
            ->select('COUNT('.$db->quoteName('id').')')
            ->from($db->quoteName('#__vkmachine_added'));
        $db->setQuery($query);   
        $this->info['numAdded'] = $db->loadResult();

        $this->info['lastAdd'] = 0;
        if ( $this->info['numAdded'] != 0 ) {
            $query = $db->getQuery(true)
                ->select($db->quoteName('created'))
                ->from($db->quoteName('#__vkmachine_added'))
                ->order($db->quoteName('created').' DESC');
            $db->setQuery($query);        
            
            $this->info['lastAdd'] = $db->loadResult();
        }
        
        $query = $db->getQuery(true)
            ->select('COUNT('.$db->quoteName('id').')')
            ->from($db->quoteName('#__vkmachine_hts'));
        $db->setQuery($query);   
        $this->info['numHts'] = $db->loadResult();
        
    	return parent::getInfo();
    }
}