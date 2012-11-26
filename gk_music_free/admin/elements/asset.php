<?php

defined('JPATH_BASE') or die;
if(!defined('DS')){
   define('DS',DIRECTORY_SEPARATOR);
}


jimport('joomla.form.formfield');

class JFormFieldAsset extends JFormField {
     protected $type = 'Asset';

     protected function getInput() {
          $doc = JFactory::getDocument();
         
          if($this->element['extension'] == 'js') {
               $doc->addScript(JURI::root().$this->element['path']);
          } else {
               $doc->addStyleSheet(JURI::root().$this->element['path']);       
          }
         
          return;
     }
}

/* EOF */
