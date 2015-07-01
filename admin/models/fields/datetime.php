<?php
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

// Agregar CSS and JS
JHtml::stylesheet('http://netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/css/bootstrap-combined.min.css');
JHtml::stylesheet('http://tarruda.github.com/bootstrap-datetimepicker/assets/css/bootstrap-datetimepicker.min.css');
JHtml::script('http://tarruda.github.com/bootstrap-datetimepicker/assets/js/bootstrap-datetimepicker.min.js');

jimport('joomla.form.formfield');



class JFormFieldDateTime extends JFormField {

    protected $type = 'DateTime';

    public function getInput() {
			// id="'.$this->id.'" name="'.$this->name. this->value'">' es fundamental para lo encuentre el modelo o la vista
			//y traiga los datos guardados
            return //'<div class="well">'.
				'<div class="datetimepicker2" class="input-append">'.
					'<input data-format="yyyy-MM-dd hh:mm:ss" type="text" id="'.$this->id.'" name="'.$this->name.'" value="'.$this->value.'" onChange="updatePrice();"></input>'.
					'<span class="add-on">'.
						'<i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>'.
					'</span>'.
				'</div>'.
				'<script type="text/javascript">'.
					'jQuery(function() {'. 'jQuery(".datetimepicker2").datetimepicker({'.
						'language: "es",'. 'pick12HourFormat: true'.
						'});'.
					'});'.
				'</script>';
			
				
   }
}