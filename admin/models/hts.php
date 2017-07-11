<?php
defined('_JEXEC') or die;
class VkmachineModelHts extends VkmachineModelsDefaults {
	public function __construct($config = array()) {
		if (empty($config['filter_fields'])) {
			$config['filter_fields'] = array(
				'id', 'a.id',
				'hashtag', 'a.hashtag',
				'state', 'a.state',
				'menutype', 'a.menutype',
				'parent_id', 'a.parent_id',
				'user_id', 'a.user_id'
			);
		}

		parent::__construct($config);
	}

	protected function populateState($ordering = null, $direction = null) {
		$app = JFactory::getApplication('administrator');
		
		$search = $this->getUserStateFromRequest($this->context.'.filter.search', 'filter_search');
		$this->setState('filter.search', $search);
		
		$published = $this->getUserStateFromRequest($this->context.'.filter.state', 'filter_state', '', 'string');
		$this->setState('filter.state', $published);

        $limit = $this->getUserStateFromRequest($this->context.'.list.limit', 'limit', $app->getCfg('list_limit'), 'uint');
        $this->setState('list.limit', $limit);
		
		$params = JComponentHelper::getParams('com_vkmachine');
		$this->setState('params', $params);

        $ordering = $this->getUserStateFromRequest ( $this->context.'.list.ordering', 'filter_order', 'a.id', 'cmd' );
        $this->setState ( 'list.ordering', $ordering );

        $direction = $this->getUserStateFromRequest ( $this->context.'.list.direction', 'filter_order_Dir', 'asc', 'word' );
	        $direction = ( $direction == 'asc')? 'asc' : 'desc';
        $this->setState ( 'list.direction', $direction );

		parent::populateState('a.id', 'asc');
	}
	
	protected function getStoreId($id = '') {
		$id .= ':' . $this->getState('filter.search');
		$id .= ':' . $this->getState('filter.state');
		return parent::getStoreId($id);
	}	
	 
	protected function getListQuery() {
		$db		= $this->getDbo();
		$query	= $db->getQuery(true);
		$user	= JFactory::getUser();
		$listQuery = array(
			$this->getState('list.select', $db->quoteName('a').'.*'),
			$db->quoteName('b.title', 'b_title'),
			$db->quoteName('c.username' ,'user_name'),
			$db->quoteName('d.menutype' ,'menuTitle')
		);

		$query->select( $listQuery )
			->from( $db->quoteName('#__vkmachine_hts', 'a') )
			->leftJoin(
			    $db->quoteName('#__menu', 'b')
			    .' ON '
			    .$db->quoteName('b.id').' = '.$db->quoteName('a.parent_id')
			)
			->leftJoin(
			    $db->quoteName('#__users', 'c')
			    .' ON '.
			    $db->quoteName('a.user_id').' = '.$db->quoteName('c.id')
			)
            ->leftJoin(
                $db->quoteName('#__menu_types', 'd')
                .' ON '.
                $db->quoteName('d.menutype').' = '.$db->quoteName('b.menutype')
            )
            ->order( $db->quoteName( $this->getState('list.ordering', 'a.id') ).' '.$db->escape($this->getState('list.direction', 'ASC')) );
				
		$search = $this->getState('filter.search');
		if (!empty($search)) {
			if (stripos($search, 'id:') === 0) {
				$query->where('a.id = '.(int) substr($search, 3));
			} else {
				$search = $db->Quote('%'.$db->escape($search, true).'%');
				$query->where('(a.hashtag LIKE '.$search.')');
			}
		}		
				
				
		$published = $this->getState('filter.state');
		if (is_numeric($published)) {
			$query->where('a.state = '.(int) $published);
		} elseif ($published === '') {
			$query->where('(a.state IN (0, 1))');
		}
		return $query;
	}
}
