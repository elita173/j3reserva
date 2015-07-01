<?php
defined('_JEXEC') or die;
class ReservaHelper
{
    /**
     * chequea los permisos del usuario actual que tiene sobre el componente
     * @param type $categoryId
     * @return \JObject
     */
    public static function getActions($categoryId = 0)
    {
        $user = JFactory::getUser();
        $result = new JObject;
        if (empty($categoryId))
        {
            $assetName = 'com_reserva';
            $level = 'component';
        }
        else
        {
            $assetName = 'com_reserva.category.'.(int) $categoryId;
            $level = 'category';
        }
        $actions = JAccess::getActions('com_reserva', $level);
        foreach ($actions as $action)
        {
            $result->set($action->name, $user->authorise($action->name,$assetName));
        }
        return $result;
    }
    /**
    * agregar sub menus barra de navegacion
    * esta funcion crea un link a la vista por defecto reservas(vista de lista)
    * y  link a la vista de categorias
    */
    public static function addSubmenu($vName = 'reservas')
    {
        JHtmlSidebar::addEntry(
        JText::_('COM_RESERVA_SUBMENU_RESERVAS'),
        'index.php?option=com_reserva&view=reservas',
        $vName == 'reservas'
        );
        
        JHtmlSidebar::addEntry(
        JText::_('COM_RESERVA_SUBMENU_EVENTOS'),
        'index.php?option=com_reserva&view=eventos',
        $vName == 'eventos'
        );
        JHtmlSidebar::addEntry(
        JText::_('COM_RESERVA_SUBMENU_ITEMS'),
        'index.php?option=com_reserva&view=items',
        $vName == 'items'
        );
    }
}
?>