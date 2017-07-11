<?php
defined( '_JEXEC' ) or die;
 
class VkmachineTableHt extends JTable {
	public function __construct( &$db ) {
		parent::__construct( '#__vkmachine_hts', 'id', $db );
	}
	
	public function publish($pks = null, $state = 1, $userId = 0){
		$k = $this->_tbl_key;

		JArrayHelper::toInteger($pks);
		$userId = (int) $userId;
		$state  = (int) $state;

		if (empty($pks))
		{
			if ($this->$k) {
				$pks = array($this->$k);
			}
			else {
				$this->setError(JText::_('JLIB_DATABASE_ERROR_NO_ROWS_SELECTED'));
				return false;
			}
		}

		$where = $k.'='.implode(' OR '.$k.'=', $pks);

		$this->_db->setQuery(
			'UPDATE '.$this->_db->quoteName($this->_tbl) .
			' SET '.$this->_db->quoteName('state').' = '.(int) $state .
			' WHERE ('.$where.')'
		);

		$this->_db->execute();

		if (in_array($this->$k, $pks)) {
			$this->state = $state;
		}

		return true;
	}	
}