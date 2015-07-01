<?php
/*
 * Es el layout de la vista para editar
 */
defined('_JEXEC') or die;
/*
JFormHelper::addFieldPath(JPATH_COMPONENT . '/models/fields');
$items = JFormHelper::loadFieldType('itemsselect', false);
$itemsOptions=$items->getOptions();
*/

$doc = JFactory::getDocument();
$doc->addScript('http://momentjs.com/downloads/moment.js');
$doc->addScriptDeclaration('
	function updatePrice() {
		var inicio = document.getElementById("jform_inicio").value;
		var fin = document.getElementById("jform_fin").value;
		var ms = moment(fin,"YYYY-MM-DD hh:mm:ss").diff(moment(inicio,"YYYY-MM-DD hh:mm:ss"));
		var timediff = moment.duration(ms);
		
		var checks = document.getElementsByName("jform[items_checkboxes][]");
		var price = 0;
		for (i=0;i<checks.length;i++){
			var check = checks[i];
			if (check.checked){
				var itemDesc = check.nextSibling.innerHTML;
				var parts = itemDesc.split("$");
				price = price + parseFloat(parts[1]);
            }
		}
		price = price * timediff.asHours();
		if (price > 0) {
			document.getElementById("jform_precio").value = "$" + price;
		}
	}	
    ');
?>
<form action="<?php echo JRoute::_('index.php?option=com_reserva&layout=edit&id='.(int) $this->item->id); ?>" method="post" name="adminForm" id="adminForm" class="form-validate">
	<div class="row-fluid">
		<div class="span10 form-horizontal">
			<fieldset>
				<?php echo JHtml::_('bootstrap.startPane', 'myTab', array('active' => 'details')); ?>
				<?php echo JHtml::_('bootstrap.addPanel', 'myTab', 'details', empty($this->item->id) ?
					JText::_('COM_RESERVA_NEW_EVENTO', true) : JText::sprintf('COM_RESERVA_EDIT_EVENTO',$this->item->id, true)); ?>
					<div class="control-group">
						<div class="controls"> <?php echo $this->form->getInput('id'); ?> </div>
					</div>
					<div class="control-group">
						<div class="control-label"> <?php echo $this->form->getLabel('titulo'); ?> </div>
						<div class="controls"> <?php echo $this->form->getInput('titulo'); ?> </div>
					</div>
					<div class="control-group">
						<div class="control-label"> <?php echo $this->form->getLabel('descripcion'); ?> </div>
						<div class="controls"> <?php echo $this->form->getInput('descripcion'); ?> </div>
					</div>
					<div class="control-group">
						<div class="control-label"> <?php echo $this->form->getLabel('lugar'); ?> </div>
						<div class="controls"> <?php echo $this->form->getInput('lugar'); ?> </div>
					</div>
					<div class="control-group">
						<div class="control-label"> <?php echo $this->form->getLabel('inicio'); ?> </div>
						<div class="controls" id="eventoinicio"> <?php echo $this->form->getInput('inicio'); ?> </div>
					</div>
					<div class="control-group">
						<div class="control-label"> <?php echo $this->form->getLabel('fin'); ?> </div>
						<div class="controls" id="eventofin"> <?php echo $this->form->getInput('fin'); ?> </div>
					</div>
					<div class="control-group">
						<div class="control-label"> <?php echo $this->form->getLabel('items_checkboxes'); ?> </div>
						<div class="controls" style="display: block"><?php echo $this->form->getInput('items_checkboxes'); ?></div>
					</div>
					<div class="control-group">
						<div class="control-label"> <?php echo $this->form->getLabel('precio'); ?> </div>
						<div class="controls"> <?php echo $this->form->getInput('precio'); ?> </div>
					</div>
					<div class="control-group">
						<div class="control-label"> <?php echo $this->form->getLabel('tel'); ?> </div>
						<div class="controls"> <?php echo $this->form->getInput('tel'); ?> </div>
					</div>
					<div class="control-group">
						<div class="control-label"> <?php echo $this->form->getLabel('mail'); ?> </div>
						<div class="controls"> <?php echo $this->form->getInput('mail'); ?> </div>
					</div>
				<?php echo JHtml::_('bootstrap.endPanel'); ?>
				<input type="hidden" name="task" value="" />
				<?php echo JHtml::_('form.token'); ?>
				<?php echo JHtml::_('bootstrap.endPane'); ?>
			</fieldset>
		</div>
	</div>
</form>