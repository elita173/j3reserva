<?php
//Hay un controlador principal para el componente, y cada vista tiene su propio controlador
defined('_JEXEC') or die;
class ReservaController extends JControllerLegacy
{
	protected $default_view = 'reservas'; //se define el default si el nombre de la vista a mostrar no coincide con el nombre del componente
	
	//Esta funci�n es la default, si no se especifica una tarea
	public function display($cachable = false, $urlparams = false)
	{
		//Se incluye c�digo del helper, para luego chequear que el usuario tenga permiso para realizar una tarea
		require_once JPATH_COMPONENT.'/helpers/reserva.php';
		//Se especifica la vista y el layout
		$view = $this->input->get('view', 'reserva');
		$layout = $this->input->get('layout', 'default');
		$id = $this->input->getInt('id');
		//Chequea error: por si intentan aceder con la url directamente
		if ($view == 'reserva' && $layout == 'edit' && !$this->checkEditId('com_reserva.edit.reserva', $id))
		{
			$this->setError(JText::sprintf('JLIB_APPLICATION_ERROR_UNHELD_ID', $id));
			$this->setMessage($this->getError(), 'error');
			$this->setRedirect(JRoute::_('index.php?option=com_reserva&view=reservas', false));
			return false;
		}
		parent::display();
		return $this;
	}
}