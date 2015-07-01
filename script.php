<?php
/*
 * archivo que sirva para ejecutar codigo cuando el componente
 * se instala, actualiza o desinstala
 */
defined('_JEXEC') or die;
class com_reservaInstallerScript
{
    function install($parent)
    {   echo '<p>' . JText::_('COM_RESERVA_INSTALL_TEXT') . '</p>';
        $parent->getParent()->setRedirectURL('index.php?option=com_reserva');
    }
    function uninstall($parent)
    {
        echo '<p>' . JText::_('COM_RESERVA_UNINSTALL_TEXT') . '</p>';
    }
    function update($parent)
    {
        echo '<p>' . JText::_('COM_RESERVA_UPDATE_TEXT') . '</p>';
    }
    function preflight($type, $parent)
    {
       // echo '<p>' . JText::_('COM_RESERVA_PREFLIGHT_' . $type . '_TEXT') . '</p>';
    }
    function postflight($type, $parent)
    {
     //   echo '<p>' . JText::_('COM_RESERVA_POSTFLIGHT_' . $type . '_TEXT') . '</p>';
    }
}
?>