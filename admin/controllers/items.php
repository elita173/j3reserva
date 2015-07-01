<?php

/**
 * controlador del vista Lista: Items
 * notar que nombre es el plural de la vista formulario de edicion: Item
 */
defined('_JEXEC') or die;
class ReservaControllerItems extends JControllerAdmin
{
    public function getModel($name = 'Item', $prefix = 'ReservaModel', $config = array('ignore_request' => true))
    {
        $model = parent::getModel($name, $prefix, $config);
        return $model;
    }
}
