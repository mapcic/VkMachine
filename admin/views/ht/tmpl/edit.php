<?php
defined('_JEXEC') or die;

JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select');

$node = $this->item->parent_id ? $this->item->parent_id : 0;
$isExist =  $this->item->id ? 1 : 0;
$script ="
	var nodeId =".$node.";
	var isExist =".$isExist.";
	jQuery('div#jform_parent_id_chzn a.chzn-single span').html();
	jQuery(document).ready(function ($){
		function parentId(){
			var menutype = $('#jform_menutype').val();
			var flag = 0;
			var text = '';
			$.ajax({
				url: 'index.php?option=com_menus&task=item.getParentItem&menutype=' + menutype,
				dataType: 'json'
			}).done(function(data) {
				$('#jform_parent_id option').each(function() {
					if ($(this).val() != '1') {
						$(this).remove();
					}
				});

				$.each(data, function (i, val) {
					var option = $('<option>');
					option.text(val.title).val(val.id);
					$('#jform_parent_id').append(option);
					if( nodeId == val.id ){
						flag = 1;
					}
				});
				$('#jform_parent_id').trigger('liszt:updated');
				if(isExist && flag){
					$('#jform_parent_id').val(nodeId);
					text = $('#jform_parent_id option[value='+nodeId+']').html();
					$('div#jform_parent_id_chzn a.chzn-single span').html(text);		
				}else{
					$('#jform_parent_id').val(1);
					text = $('#jform_parent_id option[value=1]').html();
					$('div#jform_parent_id_chzn a.chzn-single span').html(text);
				}
			});
		
		}
		$('#jform_menutype').change(parentId);
		parentId();		
	});
";
JFactory::getDocument()->addScriptDeclaration($script);
?>

<script type="text/javascript">
	Joomla.submitbutton = function(task){
		if( task == 'ht.cancel' || document.formvalidator.isValid( document.id( 'ht-form' ) ) ){
			jQuery('#jform_hashtag').val((jQuery('#jform_hashtag').val()).replace(/(?:#|\s|[\.\:;\?\!\,\'\"$])+/g,''));
			Joomla.submitform(task, document.getElementById('ht-form'));
		}
		else{
			alert( '<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED'));?>' );
		}
	}
</script>

<form action="<?php echo JRoute::_('index.php?option=com_vkmachine&layout=edit&id='.(int) $this->item->id); ?>" method="post" name="adminForm" id="ht-form" class="form-validate">
	<div class="width-100 fltlft">		
		<fieldset class="adminform">
		<?php 
			foreach($this->form->getFieldset() as $field){
				if (!$field->hidden){
					echo $field->label;
				}
				echo $field->input;
			}
		?>
		</fieldset>
	</div>		
	<div>
		<input type="hidden" name="task" value="" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>