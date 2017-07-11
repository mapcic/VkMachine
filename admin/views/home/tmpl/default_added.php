<!-- table of last added articles -->
<?php defined('_JEXEC') or die; ?>

<div id="filter-bar" class="btn-toolbar">
	<div class="filter-search btn-group pull-left">
		<label for="filter_search" class="element-invisible"><?php echo JText::_('COM_VKMACHINE_HOME_SEARCH_IN_TITLE');?></label>
		<input type="text" name="filter_search" id="filter_search" placeholder="<?php echo JText::_('COM_VKMACHINE_HOME_SEARCH_IN_TITLE'); ?>" value="<?php echo $this->escape($this->state->get('filter.search')); ?>" title="<?php echo JText::_('COM_VKMACHINE_HOME_SEARCH_IN_TITLE'); ?>" />
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

<table class="table table-striped table-bordered table-hover" id="htList">
	<thead>
		<tr>
			<th><?php echo JHTML::_( 'grid.sort', JText::_('COM_VKMACHINE_HOME_ADDED_TITLE'), 'id', $this->sortDirection, $this->sortColumn); ?></th>
			<th class="hidden-phone"><?php echo JHTML::_( 'grid.sort', JText::_('COM_VKMACHINE_HOME_ADDED_HASHTAG'), 'hashtag', $this->sortDirection, $this->sortColumn); ?></th>					
			<th class="hidden-phone"><?php echo JText::_('COM_VKMACHINE_HOME_ADDED_MENUTYPE'); ?></th>					
			<th class="hidden-phone"><?php echo JHTML::_( 'grid.sort', JText::_('COM_VKMACHINE_HOME_ADDED_CREATED'), 'created', $this->sortDirection, $this->sortColumn); ?></th>					
			<th><?php echo JText::_('COM_VKMACHINE_HOME_ADDED_CHANGE'); ?></th>
			<th><?php echo JText::_('COM_VKMACHINE_HOME_ADDED_LOOK'); ?></th>					
		</tr>
	</thead>	
	<tbody>
		<?php foreach ($this->items as $i => $item) : ?>
			<tr>
				<td><?php echo ( !empty( $item->title )? $item->title : $item->titleArtical.' '.JText::_('COM_VKMACHINE_HOME_ADDED_TITLE_BUSY') ); ?></td>
				<td class="hidden-phone"><?php echo ('#'.$item->hashtag); ?></td>
				<td class="hidden-phone"><?php echo ( empty($item->menuType)? JText::_('COM_VKMACHINE_HOME_ADDED_MENUTYPE_EMPTY') : $item->menuType ); ?></td>
				<td class="hidden-phone"><?php echo JFactory::getDate( $item->created ); ?></td>
				<td><a href="<?php echo JRoute::_('index.php?option=com_content&task=article.edit&id='.(int) $item->id_article); ?>"><i class="icon-edit"></i></a></td>
				<td><a href="<?php echo JRoute::_('/'.$item->path); ?>"><i class="icon-eye-open"></i></a></td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<?php echo JHtml::_('form.token'); ?>
<?php echo $this->pagination->getListFooter(); ?>

<div class="clearfix"> </div>