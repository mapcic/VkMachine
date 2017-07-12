<!-- general info -->
<?php defined('_JEXEC') or die; ?>	
<div id="vmHomeGeneralInfo" class="span6">
	<h4><?php echo( JText::_('COM_VKMACHINE_HOME_INFO_GENERAL').':' ); ?></h4>
	<div class="thumbnail row-fluid alert-success">
		<div class="clearfix"> </div>

		<div class="span12"><?php
			echo( JText::_('COM_VKMACHINE_HOME_INFO_VERSION').': '.$this->info['version'] );
		?></div>

		<div class="span12"><?php 
			if (empty( $this->info['pageId'] )) {
				$text = '<a href="'.JRoute::_('index.php?option=com_vkmachine&task=setting.edit').'">'.JText::_('COM_VKMACHINE_HOME_INFO_PAGE_ID_EMPTY').'</a>';
			} else {
				$text = $this->info['pageId'].'('.$this->info['pageName'].')';
			}

			echo(JText::_('COM_VKMACHINE_HOME_INFO_PAGE_ID').': '.$text);
		?></div>

		<div class="span12"><?php 
			if (empty( $this->info['skey'] )) {
				$text = '<a href="'.JRoute::_('index.php?option=com_vkmachine&task=setting.edit').'">'.JText::_('COM_VKMACHINE_HOME_SKEY_EMPTY').'</a>';
			} else {
				$text = $this->info['skey'];
			}

			echo(JText::_('COM_VKMACHINE_HOME_SKEY').': '.$text);
		?></div>

		<div class="span12"><?php
			if ($this->info['numHts'] == 0) {
				$text = '<a href="'.JRoute::_('index.php?option=com_vkmachine&task=ht.add').'">'.JText::_('COM_VKMACHINE_HOME_HT_0').'</a>';
			} else {
				$text = $this->info['numHts'];
			}

			echo( JText::_('COM_VKMACHINE_HOME_INFO_NUM_HTS').': '.$text);
		?></div>

		<div class="span12"><?php 
			echo( JText::_('COM_VKMACHINE_HOME_INFO_AUTOLAUNCH').': '.JText::_('COM_VKMACHINE_HOME_INFO_AUTOLAUNCH_INTRODUC') );
		?></div>

	</div>
</div>

<div id="vmHomeAdditionalInfo" class="span6">
	<h4><?php echo( JText::_('COM_VKMACHINE_HOME_INFO_ADDITIONAL').':' ); ?></h4>
	<div class="thumbnail row-fluid alert-info">
		<div class="clearfix"> </div>

		<div class="span12"><?php
			$text = (string)JFactory::getDate('now');
			echo( JText::_('COM_VKMACHINE_HOME_INFO_CURRENT_TIME').': '.$text );
		?></div>

		<div class="span12"><?php
			if ($this->info['lastLaunch'] == 0 ) {
				$text = JText::_('COM_VKMACHINE_HOME_INFO_LAST_LAUNCH_NO');
			} else {
				$text = $this->info['lastLaunch'];
			}

			echo( JText::_('COM_VKMACHINE_HOME_INFO_LAST_LAUNCH').': '.$text);
		?></div>

		<div class="span12"><?php
			if ($this->info['lastAdd'] == 0 ) {
				$text = JText::_('COM_VKMACHINE_HOME_INFO_LAST_ADD_NO');
			} else {
				$text = $this->info['lastAdd'];
			}

			echo( JText::_('COM_VKMACHINE_HOME_INFO_LAST_ADD').': '.$text);
		?></div>

		<div class="span12"><?php
			$text = $this->info['numAdded'];
			echo( JText::_('COM_VKMACHINE_HOME_INFO_NUM_ADDED').': '.$text);
		?></div>

	</div>
</div>
<div class="clearfix"> </div>