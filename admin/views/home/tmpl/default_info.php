<!-- general info -->
<?php defined('_JEXEC') or die; ?>	
<div id="vmHomeGeneralInfo" class="span6">
	<h4><?php echo( JText::_('COM_VKMACHINE_HOME_INFO_GENERAL').':' ); ?></h4>
	<div class="thumbnail row-fluid alert-success">
		<div class="clearfix"> </div>
		<div class="span12"><?php echo( JText::_('COM_VKMACHINE_HOME_INFO_VERSION').': '.$this->info['version'] ); ?></div>
		<div class="span12"><?php echo( JText::_('COM_VKMACHINE_HOME_INFO_LICENSE').': '.(( $this->info['license'] == 0 )? JText::_('COM_VKMACHINE_HOME_INFO_LICENSE_NO') : JFactory::getDate( $this->info['license'] )) ); ?></div>
		<div class="span12"><?php echo( JText::_('COM_VKMACHINE_HOME_INFO_STATUS').': '.$this->info['status'] ); ?></div>
		<div class="span12"><?php echo( JText::_('COM_VKMACHINE_HOME_INFO_CRON_EXISTS').': '.(( $this->info['cronExists'] )? JText::_('COM_VKMACHINE_HOME_INFO_CRON_EXISTS_YES') : '<a href="'.JRoute::_('index.php?option=com_vkmachine&task=cron.add').'">'.JText::_('COM_VKMACHINE_HOME_INFO_CRON_EXISTS_ADD').'</a>') ); ?></div>
		<div class="span12"><?php echo( JText::_('COM_VKMACHINE_HOME_INFO_CRON_ACTIVE').': '.(( $this->info['cronExists'] && $this->info['cronActive'])? JText::_('COM_VKMACHINE_HOME_INFO_CRON_ACTIVE_YES') : JText::_('COM_VKMACHINE_HOME_INFO_CRON_ACTIVE_NO') ) ); ?></div>
		<div class="span12"><?php echo( JText::_('COM_VKMACHINE_HOME_INFO_PAGE_ID').': '.(( empty( $this->info['pageId'] ) )? JText::_('COM_VKMACHINE_HOME_INFO_PAGE_ID_EMPTY') : $this->info['pageId'].'('.$this->info['pageName'].')') ); ?></div>
		<div class="span12"><?php echo( JText::_('COM_VKMACHINE_HOME_INFO_CURRENT_TIME').': '.(string)JFactory::getDate('now') ); ?></div>
	</div>
</div>

<div id="vmHomeAdditionalInfo" class="span6">
	<h4><?php echo( JText::_('COM_VKMACHINE_HOME_INFO_ADDITIONAL').':' ); ?></h4>
	<div class="thumbnail row-fluid alert-info">
		<div class="clearfix"> </div>
		<div class="span12"><?php echo( JText::_('COM_VKMACHINE_HOME_INFO_CRON_BEHAVIOR').': '.( empty($this->info['cronBehavior'])? JText::_('COM_VKMACHINE_HOME_INFO_CRON_BEHAVIOR_NO') : $this->info['cronBehavior']) ); ?></div>
		<div class="span12"><?php echo( JText::_('COM_VKMACHINE_HOME_INFO_LAST_LAUNCH').': '.(( $this->info['lastManualLaunch'] == 0 )? JText::_('COM_VKMACHINE_HOME_INFO_LAST_LAUNCH_NO') : $this->info['lastManualLaunch'] ) ); ?></div>
		<div class="span12"><?php echo( JText::_('COM_VKMACHINE_HOME_INFO_CRON_LAST_LAUNCH').': '.(( $this->info['lastLaunch'] == 0 )? JText::_('COM_VKMACHINE_HOME_INFO_LAST_LAUNCH_NO') : $this->info['lastLaunch'] ) ); ?></div>
		<div class="span12"><?php echo( JText::_('COM_VKMACHINE_HOME_INFO_CRON_NEXT_LAUNCH').': '.(( $this->info['lastLaunch'] == 0 || !$this->info['cronActive'] ) ? JText::_('COM_VKMACHINE_HOME_INFO_NEXT_LAUNCH_NO') : $this->info['nextLaunch'] ) ); ?></div>
		<div class="span12"><?php echo( JText::_('COM_VKMACHINE_HOME_INFO_LAST_ADD').': '.(( $this->info['lastAdd'] == 0 )? JText::_('COM_VKMACHINE_HOME_INFO_LAST_ADD_NO') : $this->info['lastAdd'] ) ); ?></div>
		<div class="span12"><?php echo( JText::_('COM_VKMACHINE_HOME_INFO_NUM_ADDED').': '.$this->info['numAdded']); ?></div>
		<div class="span12"><?php echo( JText::_('COM_VKMACHINE_HOME_INFO_NUM_HTS').': '.$this->info['numHts']); ?></div>
	</div>
</div>
<div class="clearfix"> </div>