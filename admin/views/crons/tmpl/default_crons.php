<!-- table of crons -->
<?php defined('_JEXEC') or die; ?>	
<table class="table table-striped table-bordered table-hover" id="cronsList">
	<thead>
		<tr>
			<th>
				<?php echo JText::_('COM_VKMACHINE_CRONS_PARTOF'); ?>
			</th>					
			<th>
				<?php echo JText::_('COM_VKMACHINE_CRONS_INTERVAL'); ?>
			</th>					
			<th>
				<?php echo JText::_('COM_VKMACHINE_CRONS_HOUR'); ?>
			</th>
			<th>
				<?php echo JText::_('COM_VKMACHINE_CRONS_MINUTE'); ?>
			</th>
			<th>
				<i class="icon-play"></i>
			</th>
		</tr>
	</thead>	
	<tbody>
	<?php foreach ($this->items as $i => $item) : ?>
		<tr class="text-center">
			<td><?php echo JText::_( $this->info['units']['partOf'][$item->partOf] ); ?></td>
			<td><?php echo ( (int)$item->partOf == 5 )? JText::_( $this->info['units']['interval'][$item->interval] ) : $item->interval; ?></td>
			<td><?php echo ( (int)$item->partOf == 2 )? '' : $item->hour; ?></td>
			<td><?php echo $item->minute; ?></td>
			<td><i class="<?php echo ( $item->state)? 'icon-ok' : 'icon-remove' ; ?>"></i></td>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>

<div class="clearfix"></div>