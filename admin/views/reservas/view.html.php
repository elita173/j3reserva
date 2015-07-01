<?php
/*
 * Aquí se definen los botones de la barra de tareas (toolbar),
 * títulos para la vista, y donde se llama al modelo para obtener 
 * los datos que se encuentran en /tmpl/default.php, listos para dárselos a la vista
 */
 
defined('_JEXEC') or die;
class ReservaViewReservas extends JViewLegacy
{
    protected $items; //items obtenidos del archivo de modelo /models/reservas.php
    protected $state;//permite saber cual es columna ordenar y la direccion  
    protected $pagination;//paginación de items
    public function display($tpl = null)
    {
        $this->items = $this->get('Items');
        //$this->state = $this->get('State');
        //$this->pagination = $this->get('Pagination');


        //agrega los links de submenus a la barra de navegación
        if (count($errors = $this->get('Errors')))
        {
            JError::raiseError(500, implode("\n", $errors));
            return false;
        }
        $this->addToolbar();
        // requerido para mostrar la barra de submenu variable mostrada /tmpl/default.php
        $this->sidebar = JHtmlSidebar::render();

        parent::display($tpl);
    }
    // Agrega los botones arriba de la vista [New, Edit, Options]
    protected function addToolbar()
    {	//agrega un sub menu de vavegacion entre vista
        ReservaHelper::addSubmenu('reservas');
        $canDo = ReservaHelper::getActions(); // Extrae los permisos del usuario actual
        $bar = JToolBar::getInstance('toolbar');
        JToolbarHelper::title(JText::_('COM_RESERVA_MANAGER_RESERVAS'), '');
    }

    protected function getSortFields()
    {
        return array(
        'a.ordering' => JText::_('JGRID_HEADING_ORDERING'),
        'a.state' => JText::_('JSTATUS'),
        'a.title' => JText::_('JGLOBAL_TITLE'),
        'a.id' => JText::_('JGRID_HEADING_ID'));
    }
}