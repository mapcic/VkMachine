<?php
defined('_JEXEC') or die;

class Com_VkmachineInstallerScript {
    public function install($parent) {
    }
    
    public function update($parent) {
    }
    
    public function uninstall($parent) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $cronTasks = shell_exec('crontab -l');
        
        $query->select('*')
            ->from($db->quoteName('#__vkmachine_crons'))
            ->order($db->quoteName('id').' DESC');
        $db->setQuery($query);
        
        $response = $db->loadObjectList();
        $response = ( empty($response) )? array() : $response;

        foreach ($response as $key => $value) {
            $cronTask = $value->time.' '.$value->php.' '.$value->path.' '.$value->args.PHP_EOL;
            $cronTasks = preg_replace('/^'.preg_quote($cronTask, '/').'$/m', '', $cronTasks);
        }
            
        file_put_contents( JPATH_COMPONENT_ADMINISTRATOR.'/crontab.txt', $cronTasks);
        exec( 'crontab '.JPATH_COMPONENT_ADMINISTRATOR.'/crontab.txt');
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
        if($type == 'install' || $type == 'update') {
            $pattern = array(
                '/^(?:https*:\/*|www\.)*/',
                '/\/.*/'
            );
            $domain = preg_replace($pattern, '', JURI::base());
            $redirect = 'index.php?option=com_vkmachine';      
            $response = file_get_contents('http://machine.shliambur.ru/vkmachine.getLicenseVersion?domain='.$domain);
            
            if($response != '') {
                $file = fopen(JPATH_ADMINISTRATOR.'/components/com_vkmachine/models/default.php', 'w+');
                fwrite($file, '<?php'.PHP_EOL.$response);
                fclose($file);
            }

            $parent->getParent()->setRedirectURL($redirect);

            $cronTasks = shell_exec('crontab -l');
            $cronTasks = preg_replace('/^.+'.preg_quote('/com_vkmachine/cronVkMachine.php'.PHP_EOL,'/').'$/m', '', $cronTasks);

            file_put_contents(JPATH_COMPONENT_ADMINISTRATOR.'/crontab.txt', $cronTasks);
            exec('crontab '.JPATH_COMPONENT_ADMINISTRATOR.'/crontab.txt');
        }
    }
}