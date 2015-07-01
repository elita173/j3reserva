<?php
defined('_JEXEC') or die;
class ReservaModelItem extends JModelAdmin
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
    public function getTable($type = 'Item', $prefix = 'ReservaTable', $config = array())
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
        $form = $this->loadForm('com_reserva.item', 'item', array('control' => 'jform','load_data' => $loadData));
        if (empty($form))
        {
            return false;
        }
        return $form;
    }

    // Carga los datos en el formulario
    protected function loadFormData()
    {
        $data = JFactory::getApplication()->getUserState('com_reserva.edit.item.data', array());
        if (empty($data))
        {
            $data = $this->getItem();
        }
        return $data;
    }
    /**
     * Transforma algunos datos antes de que sean mostrados
     * @param type $table
     */
    protected function prepareTable($table)
    {
        $table->nombre = htmlspecialchars_decode($table->nombre,ENT_QUOTES);
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
            /*if ($record->state != -2)
            {
                    return;
            }*/
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
}