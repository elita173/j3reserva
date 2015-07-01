<?php
//Hay un controlador principal para el componente, y cada vista tiene su propio controlador
defined('_JEXEC') or die;
class ReservaController extends JControllerLegacy
{
	protected $default_view = 'reservas'; //se define el default si el nombre de la vista a mostrar no coincide con el nombre del componente
	
	//Esta función es la default, si no se especifica una tarea
	public function display($cachable = false, $urlparams = false)
	{
		/*
		 * Se incluye codigo del helper, para luego chequear que el usuario tenga permiso
		 *  para realizar una tarea y agregar submenus
		 */
		require_once JPATH_COMPONENT.'/helpers/reserva.php';

		parent::display();
		return $this;
	}
}
