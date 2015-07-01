<?php
defined('_JEXEC') or die;
//Verificar que el usuario actual tiene un permiso manage sobre este componente
if (!JFactory::getUser()->authorise('core.manage', 'com_reserva'))
{
	return JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
}
//Este será el prefijo para todas las clases; se crea una instancia de JControllerLegacy
$controller = JControllerLegacy::getInstance('Reserva');
//Se determina lo que hace el componente después
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();

?>