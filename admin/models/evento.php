<?php
defined('_JEXEC') or die;
class ReservaModelEvento extends JModelAdmin
{
    //Prefijo que será usado con los mensajes del controlador
    protected $text_prefix = 'COM_RESERVA';

    /**
     * El modelo llama a la tabla
     * La tabla tiene el prefijo [ComponentName]Table, y un tipo que coincide con el nombre de la vista
     * @param type $type
     * @param type $prefix
     * @param type $config
     * @return type
     */
    public function getTable($type = 'Evento', $prefix = 'ReservaTable', $config = array())
    {
        return JTable::getInstance($type, $prefix, $config);
    }

    /**
     * Se usa para obtener el formulario, basado en el archivo XML donde se definieron todos los campos 
     * @param type $data
     * @param type $loadData
     * @return boolean
     */
    public function getForm($data = array(), $loadData = true)
    {
        $app = JFactory::getApplication();
        $form = $this->loadForm('com_reserva.evento', 'evento', array('control' => 'jform', 'load_data' => $loadData));
        if (empty($form))
        {
            return false;
        }
        return $form;
    }

    // Carga los datos en el formulario. En $data estás los datos de la BD, se le agrega el campo item_checkboxes
    protected function loadFormData()
    {
        $data = JFactory::getApplication()->getUserState('com_reserva.edit.evento.data', array());
        if (empty($data))
        {
            $data = $this->getItem();
        }
       $itemList=$this->getEventosItemlist();
		if ((null!= $itemList )) {//evita error de crear eventos sin items
			//var_dump($data->item_checkboxes);
			$data->items_checkboxes=$itemList;
		}
        return $data;
    }

    protected function getEventosItemlist()
    {// Se pone el check los items seleccionados
        if (empty( $this->_itemslist )) {
            $db = $this->getDbo();
            $query = $db->getQuery(true);
            $query->select('r.item_id');
            $query->from('#__reserva_evento AS e');
            $query->innerjoin('#__reserva_reserva AS r ON r.evento_id = e.id');
            $query->where('e.id = '.(int) $this->getItem()->id);
            $db->setQuery($query);
            $this->_itemslist = $db->loadColumn();
        }
        return $this->_itemslist;
    }
    /**
     * Transforma algunos datos antes de que sean mostrados
     * @param type $table
     */
    protected function prepareTable($table)
    {
            //$table->title = htmlspecialchars_decode($table->title, ENT_QUOTES);
    }


    /**
     *  controla permisos para borrar items
     * @param type $record
     * @return type
     */
    protected function canDelete($record)
    {
        if (!empty($record->id))
        {
            // Si no está en Trash, salir
            if ($record->state != -2)
            {
                return;
            }
            $user = JFactory::getUser();
            if ($record->catid)
            {
                return $user->authorise('core.delete','com_reserva.category.'.(int) $record->catid);
            }
            else
            {
                return parent::canDelete($record);
            }
        }
    }

    /**
     * permisos para cambiar el estado de los items publicar/despublicar/papelera/archivar
     * @param type $record
     * @return type
     */
    protected function canEditState($record)
    {
        $user = JFactory::getUser();
        if (!empty($record->catid))
        {
            return $user->authorise('core.edit.state','com_reserva.category.'.(int) $record->catid);
        }
        else
        {
            return parent::canEditState($record);
        }
    }

    public function save($data)
    {	
		if ($data['inicio'] > $data['fin']) {
			$this->setError(JText::sprintf('COM_RESERVA_WRONG_DATETIME', $this->getError()));
			return false;
		}
	
        $table_reserva = $this->getTable('Reserva', 'ReservaTable', array());
        $table_evento = $this->getTable('Evento', 'ReservaTable', array());

        $isNew = false;

        if ($data['id'] == 0){
            $isNew = true;
        }

        // Obtener los items existentes
        if (isset($data['items_checkboxes'])){
            $itemsReserva = $data['items_checkboxes'];
        } else {
            $itemsReserva = array();
        }

        // Setear los items a borrar y los items a insertar
        if ($isNew){
                $itemsExistentes = array();
        }
        else {
            $itemsExistentes = $this->getItemsForEvent($data['id']);
        }
        $insertarItems = array_diff($itemsReserva, $itemsExistentes);
        $borrarItems = array_diff($itemsExistentes, $itemsReserva);
	$sinCambios = array_intersect($itemsReserva, $itemsExistentes);

        // Si los items insertados no se solapan con los existentes, se modifica la BD

        if ($this->thereIsOverlapping(0, $insertarItems, $data['inicio'], $data['fin'])) {
        	$this->setError(JText::sprintf('COM_RESERVA_OVERLAPPING_EVENT', $this->getError()));
    		return false;
        } else {
		if ((!$isNew) && ($this->thereIsOverlapping($data['id'], $sinCambios, $data['inicio'], $data['fin']))) {
	            $this->setError(JText::sprintf('COM_RESERVA_OVERLAPPING_EVENT', $this->getError()));
	            return false;
		} else {
			// Primero insertar el evento
			if (!$table_evento->bind($data))
			{
				$this->setError(JText::sprintf('EVENTO BIND FAILED', $user->getError()));
				return false;
			}
			if (!$table_evento->save($data))
			{
				$this->setError(JText::sprintf('EVENTO SAVE FAILED', $this->getError()));
				return false;
			}
				
			// El ID del evento en la relación depende de si es nuevo o se está modificando
			if ($isNew) {
			$data['evento_id'] = (int) $table_evento->id;
			}
			else {
			$data['evento_id'] = $data['id'];
			}
				
			unset($data['items_checkboxes']);
			$data['id'] = '';
			
			// Finalmente se crean las relaciones y se borran otras según corresponda
			$this->deleteItems($data['evento_id'], $borrarItems);
			$this->insertItems($table_reserva, $data, $insertarItems);
			
			return true;
		}
        }
    }

    protected function insertItems($table_reserva, $data, $items){
        // Bind the data.
        if (!$table_reserva->bind($data))
        {
            $this->setError(JText::sprintf('RESERVA BIND FAILED', $user->getError()));
            return false;
        }

        $len = count($items);

        foreach ($items as $item)
        {
            $data['item_id'] = $item;

            // Store the data.
            if (!$table_reserva->save($data))
            {
                $this->setError(JText::sprintf('RESERVA SAVE FALIED', $this->getError()));
                return false;
            }
        }
    }

    protected function deleteItems($evento_id, $items){		
        $len = count($items);

        $db = &JFactory::getDBO();

        foreach ($items as $item)
        {
            $query = $db->getQuery(true);
            $query->delete($db->quoteName('#__reserva_reserva'));
            $query->where($db->quoteName('evento_id') . '=' . $evento_id, 'AND');
            $query->where($db->quoteName('item_id') . '=' . $item);
            $db->setQuery($query);
            $db->query();
        }
        return true;
    }

    protected function getItemsForEvent($evento_id){
        $db =&JFactory::getDBO();
        $query = $db->getQuery(true);
        $query->select('item_id');
        $query->from('#__reserva_reserva'); 
        $query->where($db->quoteName('evento_id') . '=' . $evento_id);
        $db->setQuery($query);
        if ($db->getErrorNum()) {
            echo $db->getErrorMsg();
            exit;
        }
        $listaItems = $db->loadObjectList();
        $listaResultado = array();
        $len = count($listaItems);

        for($i=0; $i<$len; $i++){
            $listaResultado[$i] = $listaItems[$i]->item_id;
        }

        return $listaResultado;
    }

    protected function thereIsOverlapping($evento_id, $items, $inicio, $fin){
        foreach ($items as $item)
        {
            if ($this->overlaps($evento_id, $item, $inicio, $fin))
            {
                return true;
            }
        }
        return false;
    }

    protected function overlaps($evento_id, $item, $inicio, $fin){
        $db =&JFactory::getDBO();
        $query = $db->getQuery(true);
        $query->select('COUNT(*) AS overlap')
                ->from($db->quoteName('#__reserva_evento', 'b'))
                ->join('INNER', $db->quoteName('#__reserva_reserva', 'a') . ' ON (' . $db->quoteName('a.evento_id') . ' = ' . $db->quoteName('b.id') . ')')
                ->join('INNER', $db->quoteName('#__reserva_item', 'c') . ' ON (' . $db->quoteName('a.item_id') . ' = ' . $db->quoteName('c.id') . ')');
        $query->where($db->quoteName('c.id') . '=' . $item, 'AND');
        if ($evento_id != 0) {
        	$query->where($db->quoteName('b.id') . '<>' . $evento_id, 'AND');
        }
        $query->where($db->quoteName('c.state') . '<> -2', 'AND');
        $query->where($db->quoteName('b.fin') . '>\'' . $inicio . '\'', 'AND');
        $query->where($db->quoteName('b.inicio') . '<\'' . $fin . '\'');
        $db->setQuery($query);
        if ($db->getErrorNum()) {
            echo $db->getErrorMsg();
            exit;
        }
        $result = $db->loadObjectList();

        if($result[0]->overlap > 0){
            return true;
        } else {
            return false;
        }
    }
}

?>
