<?php
// La vista que realmente se muestra. Por defecto, Joomla espera encontrar un layout llamado default para las vistas de listas
defined('_JEXEC') or die;
$listOrder = '';
$listDirn = '';
	
 
	$doc = JFactory::getDocument();
	$doc->addStyleSheet('http://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.3.2/fullcalendar.min.css');
	$doc->addStyleSheet('cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.3.2/fullcalendar.print.css');
	$doc->addScript('http://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js');
	$doc->addCustomTag( '<script type="text/javascript">jQuery.noConflict();</script>' );
	$doc->addScript('http://momentjs.com/downloads/moment.min.js');
    $doc->addScript('http://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.3.2/fullcalendar.min.js');
//si agregamos este estilo seteamos espacio para el calendario 
/*
	$doc->addStyleDeclaration('
	body {
		margin: 40px 10px;
		padding: 0;
		font-family: "Lucida Grande",Helvetica,Arial,Verdana,sans-serif;
		font-size: 14px;
	}
	#calendar {
		max-width: 900px;
		margin: 0 auto;
	}
	');
*/
	$doc->addScriptDeclaration('
		$(document).ready($(function(){
				$("#calendar").fullCalendar({
			header: {
				left: "prev,next today",
				center: "title",
				right: "month,agendaWeek,agendaDay"
			},
			//defaultDate: "2015-02-12",
			//editable: true,
			eventLimit: true, // allow "more" link when too many events
			//events: evento
		});	
		
				
				');
				
					//$doc = JFactory::getDocument();
				
				$i = 0;
				$len = count($this->items);
				while ($i < $len) {
				$item = $this->items[$i];
				
				$inicio=new DateTime($item->inicio);
				$fin=new DateTime($item->fin);
				
				$doc->addScriptDeclaration('
					var eventoi=[
									{	id: "'.$item->evento_id.'",
										title: "'.$item->titulo.' '.$item->tel. ' '.$item->descripcion.'",
										start: "'. $inicio->format(DateTime::ISO8601).'",
										end: "'.$fin->format(DateTime::ISO8601).'",
										url: "'.
										  'index.php?option=com_reserva&task=evento.edit&id='.(int) $item->evento_id.'"
									}
								];
					$("#calendar").fullCalendar( "addEventSource", eventoi );
				');
				
						$eventoActual = $item->evento_id;
						//filtra reservas con mismo id_evento y obtiene los item de ese evento
						while (($i < $len) && ($eventoActual == $this->items[$i]->evento_id)) { 
							//echo $this->escape($this->items[$i]->item_nombre); 
						 $i = $i+1;} $i = $i-1; 
							//echo $this->escape($item->tel);
			
							 //echo $this->escape($item->mail);
			
			
						$i = $i+1; }
						//cierra el scrip todo los eventos deben ser cargados una vez que cargo la pagina sino no los muestra
	$doc->addScriptDeclaration('}));');
?>
<div id="j-sidebar-container-fluid" class="span2">
        <?php  echo $this->sidebar; 
		/*muestra la barra de sub_menu del archivo /helpers/reserva.php */
		?>
      
</div>
  <div id='calendar' ></div>