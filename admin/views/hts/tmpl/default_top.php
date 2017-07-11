<!-- search + pagination bar -->
<?php defined('_JEXEC') or die;?>
<div id="filter-bar" class="btn-toolbar">
	<div class="filter-search btn-group pull-left">
		<label for="filter_search" class="element-invisible"><?php echo JText::_('COM_VKMACHINE_HTS_SEARCH_IN_TITLE');?></label>
		<input type="text" name="filter_search" id="filter_search" placeholder="<?php echo JText::_('COM_VKMACHINE_HTS_SEARCH_IN_TITLE'); ?>" value="<?php echo $this->escape($this->state->get('filter.search')); ?>" title="<?php echo JText::_('COM_VKMACHINE_HTS_SEARCH_IN_TITLE'); ?>" />
	</div>
	<div class="btn-group pull-left">
		<button class="btn hasTooltip" type="submit" title="<?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?>"><i class="icon-search"></i></button>
		<button class="btn hasTooltip" type="button" title="<?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?>" onclick="jQuery('#filter_search').attr('value','');this.form.submit();"><i class="icon-remove"></i></button>
	</div>
	<div class="btn-group pull-right hidden-phone">
		<label for="limit" class="element-invisible"><?php echo JText::_('JFIELD_PLG_SEARCH_SEARCHLIMIT_DESC');?></label>
		<?php echo $this->pagination->getLimitBox(); ?>
	</div>
</div>

<div class="clearfix"></div>