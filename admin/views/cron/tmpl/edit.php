<?php
defined('_JEXEC') or die;

JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select');
?>

<script type="text/javascript">
	Joomla.submitbutton = function(task){
		if( task == 'cron.cancel' || document.formvalidator.isValid( document.id( 'cron-form' ) ) ){
			Joomla.submitform(task, document.getElementById('cron-form'));
		}
		else{
			alert( '<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED'));?>' );
		}
	}
	
	jQuery(document).ready(function(){
		var intervalObj = jQuery('input[name*=interval][type=hidden]'),
			interval = intervalObj.val(),
			intervalName = intervalObj.attr('name'),
			partOfObj = jQuery('select[name*=partOf]'),
			intervalObjs = jQuery('[name*=interval]:not([type=hidden])').each( function() { 
				jQuery(this).attr('named', jQuery(this).attr('name') ) 
			});
		
		function changeInterval(){
			var curObj = jQuery('select[name*=\\[interval'+partOfObj.val()+'\\]]:not([type=hidden])');
			intervalObjs.each( function() {
				jQuery(this).attr('name', jQuery(this).attr('named')).parent().hide();
			});
			
			curObj.attr('name', intervalName).parent().show();
			( partOfObj.val() == 2 )? jQuery('select[name*=hour]').parent().hide() : jQuery('select[name*=hour]').parent().show();
			
			if ( interval != -1 ) {
				curObj.val(interval);
				curObj.parent().children('div').trigger('mousedown');
				jQuery(document).trigger('click');
				curObj.parent().find('li[data-option-array-index=' + ( interval - 1 ) + ']').trigger('mouseup');
				interval = 0;
			}
		}
		
		intervalObj.attr('name', 'checked');
		changeInterval();
		partOfObj.change(changeInterval);
	});
</script>

<form action="<?php echo JRoute::_('index.php?option=com_vkmachine&layout=edit&id='.(int) $this->item->id); ?>" method="post" name="adminForm" id="cron-form" class="form-validate">
	<fieldset class="adminform">
		<div class="row-fluid"><h3><?php echo ( JText::_('COM_VKMACHINE_CRON_EDIT_GENERAL_SETTINGS').':' );?></h3></div>
		<div class="row-fluid">
			<?php
				foreach ( $this->formatFieldset['general'] as $val ) {
					$style = ( !preg_match('/[A-Za-z]\[partOf\]/', $val->name) )? ' style="display: none;"':'';
					echo('<div class="span3"'.$style.'>'.$val->label.$val->input.'</div>'); 
				}
			?>
		</div>
		<div class="row-fluid"><h3><?php echo ( JText::_('COM_VKMACHINE_CRON_EDIT_ADDITIONAL_SETTINGS').':' );?></h3></div>
		<div class="row-fluid">
			<?php
				foreach ( $this->formatFieldset['common'] as $val ) {
					echo('<div class="span3">'.$val->label.$val->input.'</div>'); 
				}	
			?>
		</div>
		<div class="row-fluid">
			<?php
				foreach ( $this->formatFieldset['hidden'] as $val ) {
					echo('<div class="span3">'.$val->input.'</div>'); 
				}	
			?>
		</div>
	</fieldset>
	
	<div><input type="hidden" name="task" value="" /></div>
	<div><?php echo JHtml::_('form.token'); ?></div>
</form>