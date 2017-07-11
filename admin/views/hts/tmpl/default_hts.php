<!-- table of hts -->
<?php defined('_JEXEC') or die; ?>	
<table class="table table-striped table-bordered table-hover" id="htList">
	<thead>
		<tr>
			<th width="1%" class="hidden-phone">
				<input type="checkbox" name="checkall-toggle" value="" title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>" onclick="Joomla.checkAll(this)" />
			</th>		
			<th><?php echo JHTML::_( 'grid.sort', JText::_('COM_VKMACHINE_HTS_HASHTAG'), 'id', $this->sortDirection, $this->sortColumn); ?></th>					
			<th><?php echo JText::_('COM_VKMACHINE_HTS_MENU'); ?></th>					
			<th><?php echo JText::_('COM_VKMACHINE_HTS_MENU_TYPE'); ?></th>
			<th><?php echo JText::_('COM_VKMACHINE_HTS_MENU_PARENT'); ?></th>
			<th class="hidden-phone"><?php echo JText::_('COM_VKMACHINE_HTS_USER_NAME'); ?></th>
			<th><?php echo JHTML::_( 'grid.sort', JText::_('COM_VKMACHINE_HTS_STATUS'), 'state', $this->sortDirection, $this->sortColumn); ?></th>
		</tr>
	</thead>	
	<tbody>
		<?php foreach ($this->items as $i => $item) : ?>
			<tr>
				<td><?php echo JHtml::_('grid.id', $i, $item->id); ?></td>
				<td><a href="<?php echo JRoute::_('index.php?option=com_vkmachine&task=ht.edit&id='.(int) $item->id); ?>">#<?php echo $item->hashtag; ?></a></td>
				<td><?php echo $item->menutype; ?></td>
				<td><?php echo (( empty($item->menuTitle) )? JText::_('COM_VKMACHINE_HTS_MENU_TYPE_ROOT') : $item->menuTitle ); ?></td>
				<td><?php echo (( $item->parent_id != 1 )? $item->b_title : JText::_('COM_VKMACHINE_HTS_ITEM_ROOT')); ?></td>
				<td class="hidden-phone"><?php echo $item->user_name; ?></td>
				<td><?php echo JHtml::_('jgrid.published', $item->state, $i, 'hts.', true, 'cb'); ?></td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>
<div class="clearfix"> </div>