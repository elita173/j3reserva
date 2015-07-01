<?php
/*
 * El formulario que se usa al crear un nuevo registro o al editar uno existente
 */
defined('_JEXEC') or die;
class ReservaViewEvento extends JViewLegacy
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
        JFactory::getApplication()->input->set('hidemainmenu', true);
        JToolbarHelper::title(JText::_('COM_RESERVA_MANAGER_EVENTO'), '');
        JToolbarHelper::save('evento.save');
        if (empty($this->item->id))
        {
            JToolbarHelper::cancel('evento.cancel');
        }
        else
        {
            JToolbarHelper::cancel('evento.cancel', 'JTOOLBAR_CLOSE');
        }
    }
}
?>