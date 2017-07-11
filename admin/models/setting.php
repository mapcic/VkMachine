<?php
defined('_JEXEC') or die;
 
class VkmachineModelSetting extends VkmachineModelsDefault {
	
	protected $text_prefix = 'COM_VKMACHINE';	 
	 
	public function getTable( $type = 'Setting', $prefix = 'VkmachineTable', $config = array() ) {
		return JTable::getInstance($type, $prefix, $config);
	}

	public function getForm($data = array(), $loadData = true) {
		$form = $this->loadForm('com_vkmachine.setting', 'setting', array('control' => 'jform', 'load_data' => $loadData));
		$form = (empty( $form ))? false : $form;

		return $form;
	}

	public function save( $data ) {
		$methods = array();

		$db = JFactory::getDbo();
		$query = $db->getQuery(true)
			->select('*')
			->from($db->quoteName('#__vkmachine_settings'))
			->order($db->quoteName('id').' DESC');
		$oldData = $db->setQuery($query)->loadObject();

		if( !empty($oldData) && $oldData->page == $data['page'] ) {
			return parent::save( $data );
		}

		if ( !preg_match( '/^(?:(?:https?\:\/\/)|(?:www\.)){0,2}(?:vk\.com\/)?([^\/\\\?\=]+)/', $data['page'], $matches ) ) {
			return 0;
		}

		switch ( $data['type'] ) {
		 	case 0:
		 		$methods[] = 'users.get?v=5.29&user_ids='.$matches[1].'&fields=domain,id';
		 		$methods[] = 'groups.getById?v=5.29&group_id='.$matches[1].'&fields=id,screen_name';
		 		break;
		 	case 1:
		 		$methods[] = 'users.get?v=5.29&user_ids='.$matches[1].'&fields=domain,id';
		 		break;
		 	case 2:
		 		$methods[] = 'groups.getById?v=5.29&group_id='.$matches[1].'&fields=id,screen_name';
		 		break;
		 	default:
		 		$methods[] = 'users.get?v=5.29&user_ids='.$matches[1].'&fields=domain,id';
		 		break;
		 }

		$data['pageId'] = '';
		$data['pageName'] = '';

		foreach ($methods as $key => $method) {
			$response = json_decode(file_get_contents('http://api.vk.com/method/'.$method));

			if ( property_exists( $response, 'response') && property_exists( $response->response[0], 'id') ) {
				$data['pageId'] = ( property_exists( $response->response[0], 'domain' ) )? $response->response[0]->id : '-'.$response->response[0]->id;
				$data['pageName'] = ( property_exists( $response->response[0], 'domain' ) )? $response->response[0]->domain : $response->response[0]->screen_name;
				// $data['type'] = ($data['type'] != 0)? $data['type'] : ( ( property_exists( $response, 'domain' ) )? 1 : 2 );
			}
		}

		return parent::save( $data );
	}
	
	protected function loadFormData() {
		$data = JFactory::getApplication()->getUserState('com_vkmachine.edit.setting.data', array());
		$data = (empty( $data ))? $this->getItem() : $data;
		
		return $data;
	}
}