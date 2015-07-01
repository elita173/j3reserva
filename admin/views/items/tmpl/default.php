<?php
// La vista que realmente se muestra. Por defecto, Joomla espera encontrar un layout llamado default para las vistas de listas
    defined('_JEXEC') or die;
    $listOrder = '';
    $listDirn = '';
?>
<div id="j-sidebar-container" class="span2">
    <?php
        echo $this->sidebar; 
        /*muestra la barra de sub_menu del archivo /helpers/reserva.php */
    ?>
</div>
<form action="<?php echo JRoute::_('index.php?option=com_reserva&view=items'); ?>" method="post" name="adminForm" id="adminForm">
    <div id="j-main-container" class="span10">
		<div class="clearfix"> </div>
		<table class="table table-striped" id="itemList">
			<thead>
				<tr>
					<th width="1%" class="hidden-phone">
					<input type="checkbox" name="checkall-toggle" value="" 
					title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>" 
					onclick="Joomla.checkAll(this)" />
					</th>
					
					<th class="nombre">
					<?php echo JHtml::_('grid.sort', 'COM_RESERVA_NOMBRE', 
					'a.nombre', $listDirn, $listOrder); ?>
					</th>
					
					<th class="imagen">
					<?php echo JHtml::_('grid.sort', 'COM_RESERVA_IMAGEN', 
					'a.img', $listDirn, $listOrder); ?>
					</th>
					
					<th class="descripcion hidden-phone">
					<?php echo JHtml::_('grid.sort', 'COM_RESERVA_DESCRIPCION', 
					'a.descripcion', $listDirn, $listOrder); ?>
					</th>
					
					<th class="costo hidden-phone">
					<?php echo JHtml::_('grid.sort', 'COM_RESERVA_COSTO', 
					'a.costo', $listDirn, $listOrder); ?>
					</th>
					
					
				</tr>
			</thead>
			<tbody>
			<?php foreach ($this->items as $i => $item) : ?>
				<tr class="row<?php echo $i % 2; ?>">
					<td class="center hidden-phone">
						<?php echo JHtml::_('grid.id', $i, $item->id); ?>
					</td>
					<td class="nowrap has-context">
						<a href="<?php echo JRoute::_('index.php?option=com_reserva&task=item.edit&id='.(int) $item->id); ?>">
						   <?php echo $this->escape($item->nombre); ?>
						</a>
					</td>
					<td class="nowrap has-context">
						<img src="../<?php echo $item->img; ?>" width="150">
					</td>
					<td class="center hidden-phone">
						<?php echo $this->escape($item->descripcion); ?>
					</td>
				   <td class="center hidden-phone">
						<?php echo $this->escape($item->costo); ?>
					</td> 
				</tr>
			  <?php endforeach; ?>
			</tbody>
		</table>
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
		<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
		<?php echo JHtml::_('form.token'); ?>
    </div>
</form>