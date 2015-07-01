<?php

/*
 * modelo para la Vista Reservas
 * Selecciona los datos de la base de datos que se muestran en la vista
 */

defined('_JEXEC') or die;

class ReservaModelEventos extends JModelList
{
    public function __construct($config = array())
    {//se setean los campos que se necesitaran en la vista
        if (empty($config['filter_fields']))
        {
            $config['filter_fields'] = array(
            'evento_id', 'b.id',
            'evento_titulo', 'b.titulo',
            'evento_inicio', 'b.inicio',
            'evento_fin', 'b.fin',
            'evento_lugar', 'b.lugar',
            'evento_descripcion', 'b.descripcion',
            'evento_tel', 'b.tel',
            'evento_mail', 'b.mail',
            'item_id', 'c.id',
            'item_nombre', 'c.nombre',
            'item_imagen','c.img',
            'item_descripcion','c.descripcion',
            'precio','a.precio',
            );
        }
        parent::__construct($config);
    }
	
    protected function populateState($ordering = null, $direction = null)
    {
            $published = $this->getUserStateFromRequest($this->context.'.filter.state', 'filter_state', '', 'string');
            $this->setState('filter.state', $published);
            parent::populateState('a.title', 'asc');
    }

    // Prepara la consulta para seleccionar la información necesaria.
    protected function getListQuery()
    {
        $db = $this->getDbo();
        $query = $db->getQuery(true);

        //realizar un inner join para obtener la relacion Muchos a Muchos entre eventos e items
        /* sql probado
         SELECT * FROM (az94y_eventos_items INNER JOIN az94y_eventos ON az94y_eventos_items.eventos_id = az94y_eventos.id) 
                          INNER JOIN az94y_items ON az94y_eventos_items.items_id = az94y_items.id

         */
        $query->select(array('a.precio AS precio_total', 'a.id AS reserva_id', 
                                'b.id AS evento_id', 'c.id AS item_id', 
                                'b.titulo AS evento_titulo', 'b.descripcion AS evento_descripcion', 'b.inicio AS evento_inicio', 'b.fin AS evento_fin',
                                'b.lugar AS lugar','b.tel AS tel','b.mail AS mail',
                                'c.descripcion AS item_descripcion', 'c.img AS imagen', 'c.costo AS item_costo', 'c.nombre AS item_nombre'))
            ->from($db->quoteName('#__reserva_evento', 'b'))
            ->join('LEFT OUTER', $db->quoteName('#__reserva_reserva', 'a') . ' ON (' . $db->quoteName('a.evento_id') . ' = ' . $db->quoteName('b.id') . ')')
            ->join('LEFT OUTER', $db->quoteName('#__reserva_item', 'c') . ' ON (' . $db->quoteName('a.item_id') . ' = ' . $db->quoteName('c.id') . ')');

        $published = $this->getState('filter.state');
        if (is_numeric($published))
        {
            $query->where('b.state = '.(int) $published);
        } elseif ($published === '')
        {
            $query->where('(b.state IN (0, 1))');
        }

        $query->order('evento_inicio', 'evento_id');
        /*
        // Add the list ordering clause.
        $orderCol = $this->state->get('list.ordering');
        $orderDirn = $this->state->get('list.direction');
        if ($orderCol == 'a.ordering')
        {
                $orderCol = 'a.title '.$orderDirn.', a.ordering';
        }
        $query->order($db->escape($orderCol.' '.$orderDirn));
        */

        return $query;
    }
}