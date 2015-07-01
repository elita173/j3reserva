<?php

/**
 * controlador del vista Lista: Eventos
 * notar que nombre es el plural de la vista formulario de edicion: Evento
 */
defined('_JEXEC') or die;
class ReservaControllerEventos extends JControllerAdmin
{
    public function getModel($name = 'Evento', $prefix = 'ReservaModel', $config = array('ignore_request' => true))
    {
        $model = parent::getModel($name, $prefix, $config);
        return $model;
    }
}