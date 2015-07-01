<?php
/*
 * El formulario que se usa al crear un nuevo registro o al editar uno existente
 */
defined('_JEXEC') or die;
class ReservaViewItem extends JViewLegacy
{
    protected $item;
    protected $form;
    
    public function display($tpl = null)
    {
        $this->item = $this->get('Item');
        $this->form = $this->get('Form');
        if (count($errors = $this->get('Errors')))
        {
            JError::raiseError(500, implode("\n", $errors));
            return false;
        }
        $this->addToolbar();
        parent::display($tpl);
    }
    
    protected function addToolbar()
    {
        //oculta el menu de la vista lista asi no se ven el resto de los links    
        JFactory::getApplication()->input->set('hidemainmenu', true);
        JToolbarHelper::title(JText::_('COM_RESERVA_MANAGER_ITEM'), '');
        JToolbarHelper::save('item.save');
        if (empty($this->item->id))
        {//si un nuevo item mostramos el boton cancel
            JToolbarHelper::cancel('item.cancel');
        }
        else
        {//si estamos editando muestra el boton con nombre close
            JToolbarHelper::cancel('item.cancel', 'JTOOLBAR_CLOSE');
        }
    }
}