<?php defined('_JEXEC') or die; ?>
<div>
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="previos_view" value="<?php echo $this->getName(); ?>" />
	<input type="hidden" name="filter_order" value="<?php echo $this->sortColumn; ?>" />
	<input type="hidden" name="filter_order_Dir" value="<?php echo $this->sortDirection; ?>" /> 
</div>