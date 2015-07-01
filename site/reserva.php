<?php
defined('_JEXEC') or die;
//Este será el prefijo para todas las clases; se crea una instancia de JControllerLegacy
$controller = JControllerLegacy::getInstance('Reserva');
//Se determina lo que hace el componente después
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();

?>