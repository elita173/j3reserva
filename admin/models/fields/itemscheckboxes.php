<?php

/* 
 * check boxes custom carga todo los items 
 */

defined('JPATH_BASE') or die;

jimport('joomla.html.html');
jimport('joomla.form.formfield');

class JFormFieldItemsCheckBoxes extends JFormField
{
   protected $type = 'checkboxes';
   protected function getInput()
   {
      //Get form details
      $db = JFactory::getDBO();
      $query = $db->getQuery(true);
      $query->select('a.id As value, CONCAT(a.nombre, " $", CAST(a.costo AS CHAR)) As text');
      $query->from($db->quoteName('#__reserva_item').' AS a');
      $db->setQuery($query);
      $items = $db->loadObjectList();
      $var_list ='';
	// print_r($this->value);
      foreach($items as $item){
		$checked = $this->getValues($item->value);
         $var_list.= '<input name="'.$this->name.'" ' . $checked . 'type="checkbox" value="'.$item->value.'">'.$item->text.'<br />';
      }
      return $var_list;
   }
   
   protected function getValues($itemsid) {
		$itemsid = (int) $itemsid;
		$checked='';
		foreach ($this-> value as $values)
		{
			if ($itemsid == $values)
			{
				$checked = 'checked = "checked"';
			}

		}
		return $checked;
	}
  

}
