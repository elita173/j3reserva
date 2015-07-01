<?php
// La vista que realmente se muestra. Por defecto, Joomla espera encontrar un layout llamado default para las vistas de listas
defined('_JEXEC') or die;
$listOrder = '';
$listDirn = '';
?>
<div id="j-main-container" class="span10">
<form action="<?php echo JRoute::_('index.php?option=com_reserva&view=eventos'); ?>" method="post" name="adminForm" id="adminForm">
	<?php if (!empty($this->sidebar)) : ?>
		<div id="j-sidebar-container" class="span2"><?php echo $this->sidebar; ?></div>
		<div id="j-main-container" class="span10">
	<?php else : ?><div id="j-main-container">
	<?php endif;?>
		<div class="clearfix"> </div>
		<table class="table table-striped" id="reservaList">
			<thead>
				<tr>
					<th width="1%" class="hidden-phone"> 
						<input type="checkbox" name="checkall-toggle" value="" 
						titulo="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>" 
						onclick="Joomla.checkAll(this)" />
					</th>
					<th class="title"><?php echo JHtml::_('grid.sort', 'COM_RESERVA_EVENTOS_TITULO','evento_titulo', $listDirn, $listOrder); ?></th>
					<th width="1%" class="nowrap center hidden-phone"><?php echo JHtml::_('grid.sort', 'COM_RESERVA_EVENTOS_DESCRIPCION', 'evento_descripcion', $listDirn, $listOrder); ?></th>
					<th width="1%" class="nowrap center "><?php echo JHtml::_('grid.sort', 'COM_RESERVA_EVENTOS_INICIO', 'evento_inicio', $listDirn, $listOrder); ?></th>
					<th width="1%" class="nowrap center hidden-phone"><?php echo JHtml::_('grid.sort', 'COM_RESERVA_EVENTOS_FIN', 'evento_fin', $listDirn, $listOrder); ?></th>
					<th width="1%" class="nowrap center "><?php echo JHtml::_('grid.sort', 'COM_RESERVA_EVENTOS_LUGAR', 'lugar', $listDirn, $listOrder); ?></th>
					<th width="1%" class="nowrap center hidden-phone"><?php echo JHtml::_('grid.sort', 'COM_RESERVA_EVENTOS_ITEMS', '', $listDirn, $listOrder); ?></th>
					<th width="1%" class="nowrap center "><?php echo JHtml::_('grid.sort', 'COM_RESERVA_EVENTOS_TEL', 'tel', $listDirn, $listOrder); ?></th>
					<th width="1%" class="nowrap center hidden-phone"><?php echo JHtml::_('grid.sort', 'COM_RESERVA_EVENTOS_MAIL', 'mail', $listDirn, $listOrder); ?></th>
				</tr>
			</thead>
			<tbody>
			<!--  agrega los items obtenidos del modelo a cada fila -->
				<?php
				$i = 0;
				$len = count($this->items);
				while ($i < $len) {
				$item = $this->items[$i]?>
					<tr class="row<?php echo $i % 2; ?>">
						<td class="center hidden-phone">
							<?php echo JHtml::_('grid.id', $i, $item->evento_id); ?>
						</td>
						<td class="nowrap has-context">
							<a href="<?php echo JRoute::_('index.php?option=com_reserva&task=evento.edit&id='.(int) $item->evento_id); ?>">
								<?php echo $this->escape($item->evento_titulo); ?></a>
						</td>
						<td class="nowrap has-context">
							<?php echo $this->escape($item->evento_descripcion); ?>
						</td>
						<td class="nowrap has-context ">
							<?php echo $this->escape($item->evento_inicio); ?>
						</td>
						<td class="nowrap has-context center hidden-phone">
							<?php echo $this->escape($item->evento_fin); ?>
						</td>
						<td class="nowrap has-context">
							<?php echo $this->escape($item->lugar); ?>
						</td>
						<td>
						<?php $eventoActual = $item->evento_id;
						while (($i < $len) && ($eventoActual == $this->items[$i]->evento_id)) { 
							echo $this->escape($this->items[$i]->item_nombre); ?> </br>
						<?php $i = $i+1;} $i = $i-1; ?>
						</td>
						<td class="nowrap has-context">
							<?php echo $this->escape($item->tel); ?>					
						</td>
						<td class="nowrap has-context center hidden-phone">
							<?php echo $this->escape($item->mail); ?>
						</td>                
					</tr>
				<?php $i = $i+1; } ?>
			</tbody>
		</table>

		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
		<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
		<?php echo JHtml::_('form.token'); ?>
    </div>
</form>