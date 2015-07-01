<?php

/**
 * controlador del vista Lista: Reservas
 * notar que nombre es el plural de la vista formulario de edicion: Reserva
 */
defined('_JEXEC') or die;
class ReservaControllerReservas extends JControllerAdmin
{
    // Se llama al modelo, que se usa para obtener los datos de la BD
    public function getModel($name = 'Reserva', $prefix = 'ReservaModel', $config = array('ignore_request' => true))
    {
        $model = parent::getModel($name, $prefix, $config);
        return $model;
    }
}