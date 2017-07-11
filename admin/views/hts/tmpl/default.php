<?php defined('_JEXEC') or die; ?>

<form action="<?php echo JRoute::_('index.php?option=com_vkmachine&view=hts'); ?>" method="post" name="adminForm" id="adminForm">
	
	<div id="j-sidebar-container" class="span2">
	<?php 
		echo $this->loadTemplate('sidebar');
	?>
	</div>

	<div class="clearfix"></div>
	
	<div id="j-main-container" class="span10">	
	<?php 
		echo $this->loadTemplate( $this->tmpl );
		echo $this->loadTemplate('top');
		echo $this->loadTemplate('hts');
		echo $this->loadTemplate('hidden');
		echo $this->loadTemplate('bottom');
	?>
	</div>

	<div class="clearfix"></div>

</form>