<?php
/*
 * Aquí se definen los botones de la barra de tareas (toolbar),
 * títulos para la vista, y donde se llama al modelo para obtener 
 * los datos que se encuentran en /tmpl/default.php, listos para dárselos a la vista
 */
 
defined('_JEXEC') or die;
class ReservaViewReservas extends JViewLegacy
{
	protected $items; //items obtenidos del archivo de modelo /models/reservas.php
	
	public function display($tpl = null)
	{
		$this->items = $this->get('Items');
			
		if (count($errors = $this->get('Errors')))
		{
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}
		                
		parent::display($tpl);
	}

}