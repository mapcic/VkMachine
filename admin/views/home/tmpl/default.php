<?php defined('_JEXEC') or die; ?>

<form action="<?php echo JRoute::_('index.php?option=com_vkmachine&view=home'); ?>" method="post" name="adminForm" id="adminForm">
	
	<div id="j-sidebar-container" class="span2">
	<?php 
		echo $this->loadTemplate('sidebar');
	?>
	</div>	
	<div id="j-main-container" class="span10">
	<?php
		echo $this->loadTemplate('alert');
		echo $this->loadTemplate('info');
		echo $this->loadTemplate('added');
		echo $this->loadTemplate('hidden');
	?>
	</div>

</form>