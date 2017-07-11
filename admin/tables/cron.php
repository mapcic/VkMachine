<?php
defined( '_JEXEC' ) or die;
 
class VkmachineTableCron extends JTable {
	public function __construct( &$db ) {
		parent::__construct( '#__vkmachine_crons', 'id', $db );
	}	
}