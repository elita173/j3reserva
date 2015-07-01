<?php
/*
 * Es el layout de la vista para editar
 */
defined('_JEXEC') or die;
?>
<form action="<?php echo JRoute::_('index.php?option=com_reserva&layout=edit&id='.(int) $this->item->id); ?>" method="post" name="adminForm" id="adminForm" class="form-validate">
    <div class="row-fluid">
		<div class="span10 form-horizontal">
			<fieldset>
				<?php echo JHtml::_('bootstrap.startPane', 'myTab', array('active' => 'details')); ?>
				<?php echo JHtml::_('bootstrap.addPanel', 'myTab','details',
						empty($this->item->id) ? JText::_('COM_RESERVA_NEW_ITEM', true) : JText::sprintf('COM_RESERVA_EDIT_ITEM',$this->item->id, true)); ?>
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('nombre'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('nombre'); ?></div>
				</div>
				<div class="control-group">
						<div class="control-label"><?php echo $this->form->getLabel('img'); ?></div>
						<div class="controls"><?php echo $this->form->getInput('img'); ?></div>
				</div>
				<div class="control-group">
						<div class="control-label"><?php echo $this->form->getLabel('descripcion'); ?></div>
						<div class="controls"><?php echo $this->form->getInput('descripcion'); ?></div>
				</div>
				<div class="control-group">
						<div class="control-label"><?php echo $this->form->getLabel('costo'); ?></div>
						<div class="controls"><?php echo $this->form->getInput('costo'); ?></div>
				</div>
				<?php echo JHtml::_('bootstrap.endPanel'); ?>
				<input type="hidden" name="task" value="" />
				<?php echo JHtml::_('form.token'); ?>
				<?php echo JHtml::_('bootstrap.endPane'); ?>
			</fieldset>
		</div>
    </div>
</form>