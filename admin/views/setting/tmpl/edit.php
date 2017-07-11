<?php
defined('_JEXEC') or die;

JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select');
?>
<script type="text/javascript">
	Joomla.submitbutton = function(task){
		if( task == 'setting.cancel' || document.formvalidator.isValid( document.id( 'setting-form' ) ) ){
			Joomla.submitform(task, document.getElementById('setting-form'));
		}
		else{
			alert( '<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED'));?>' );
		}
	}
</script>

<form action="<?php echo JRoute::_('index.php?option=com_vkmachine&layout=edit&id='.(int) $this->_item->id); ?>" method="post" name="adminForm" id="setting-form" class="form-validate">
	<fieldset class="adminform">
		<div class="row-fluid">
			<div class="span6">
				<div class="clearfix"> </div>
				<h3><?php echo ( JText::_('COM_VKMACHINE_SETTING_EDIT_GENERAL_SETTINGS').':' );?></h3>
				<?php
					foreach ( $this->_formatFieldset['general'] as $val ) {
						echo('<div class="span12">'.$val->label.$val->input.'</div>'); 
					}
				?>
			</div>
			
			<div class="span6">
				<div class="clearfix"> </div>
				<h3><?php echo ( JText::_('COM_VKMACHINE_SETTING_EDIT_ADDITIONAL_SETTINGS').':' );?></h3>
				<?php
					foreach ( $this->_formatFieldset['common'] as $val ) {
						echo('<div class="span12">'.$val->label.$val->input.'</div>'); 
					}	
				?>
			</div>
		</div>

		<div class="row-fluid">
			<?php
				foreach ( $this->_formatFieldset['hidden'] as $val ) {
					echo('<div class="span3">'.$val->input.'</div>'); 
				}	
			?>
			<input type="hidden" name="task" value="" />
			<?php echo JHtml::_('form.token'); ?>
		</div>
	</fieldset>
</form>