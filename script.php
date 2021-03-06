<?php
defined('_JEXEC') or die;

class Com_VkmachineInstallerScript {
    public function install($parent) {
    }
    
    public function update($parent) {
    }
    
    public function uninstall($parent) {
        $pattern = array(
            '/^(?:https*:\/*|www\.)*/',
            '/\/.*/'
        );
        $domain = preg_replace($pattern, '', JURI::base());
        
        file_get_contents('http://machine.shliambur.ru/vkmachine.get_delete?domain='.$domain);
    }
 
    public function preflight($type, $parent) {
        if ($type == 'update') {
            $db = JFactory::getDbo();

            $query = $db->getQuery(true)
                ->select('*')
                ->from($db->quoteName('#__update_sites'))
                ->where($db->quoteName('name').' = '.$db->quote('VkMachine'));
            $db->setQuery($query);
            
            $response = $db->loadObject();
            
            if (!empty( $response )) {
                $condition = array($db->quoteName('update_site_id').' = '.(int)$response->update_site_id);
                $query = $db->getQuery(true)
                    ->delete($db->quoteName('#__update_sites'))
                    ->where($condition);
                $db->setQuery($query)
                    ->execute();
            }
        }
    }

    public function postflight($type, $parent) {
        $pattern = array(
            '/^(?:https*:\/*|www\.)*/',
            '/\/.*/'
        );
        $domain = preg_replace($pattern, '', JURI::base());

        $redirect = 'index.php?option=com_vkmachine';

        file_get_contents('http://machine.shliambur.ru/vkmachine.get_'.$type.'?domain='.$domain);

        $parent->getParent()->setRedirectURL($redirect);
    }
}