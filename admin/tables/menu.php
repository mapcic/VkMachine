<?php
defined( '_JEXEC' ) or die;
 
class TableMenu extends JTableMenu {
    public function __construct( &$db ) {
      parent::__construct( $db );
    }

	public function store( $updateNulls = false ){
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);

		$query->select( $db->quoteName('alias') )
			->from( $db->quoteName('#__menu') )
			->where( $db->quoteName('alias').' = '.$db->quote( $this->alias ) );

		$resp = $db->setQuery( $query )->loadResult();

		if ( !empty( $resp ) ){
			return false;
		}

		return parent::store( $updateNulls );
	}
}