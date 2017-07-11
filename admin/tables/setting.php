<?php
defined( '_JEXEC' ) or die;
 
class VkmachineTableSetting extends JTable {
	public function __construct( &$db ) {
		parent::__construct( '#__vkmachine_settings', 'id', $db );
	}	
}