<?php
defined( '_JEXEC' ) or die;
 
class VkmachineTableAdded extends JTable {
	public function __construct( &$db ) {
		parent::__construct( '#__vkmachine_added', 'id', $db );
	}	
}