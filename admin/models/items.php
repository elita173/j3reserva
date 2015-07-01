<?php
defined('_JEXEC') or die;
class ReservaModelItems extends JModelList
{
    public function __construct($config = array())
    {
        if (empty($config['filter_fields']))
        {/*
         * se setean los campos que se usaran en la vista, no todos 
         * los campos son requeridos
         */
            $config['filter_fields'] = array(
            'id', 'a.id',
            'nombre', 'a.nombre',
            'img','a.img',    
            'descripcion','a.descripcion',
            'costo','a.costo',    
            );
        }
        parent::__construct($config);
    }
    protected function getListQuery()
    {
        $db = $this->getDbo();
        $query = $db->getQuery(true);
        //$query->select('c.*');
        $query->select(
            $this->getState(
                   'list.select',
                   'a.id, a.nombre,'.
                    'a.img,'.
                    'a.descripcion,'.
                    'a.costo'
                    ));
        $query->from($db->quoteName('#__reserva_item').' AS a');
        return $query;
    }
}