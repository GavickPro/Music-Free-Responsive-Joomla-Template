<?php

//
// Functions for MooTools
//

class GKTemplateMooTools {
    //
    private $parent;
    //
    function __construct($parent) {
    	$this->parent = $parent;
    }
    //
	public function getMooToolsOverride() {
		// get current ItemID
	    $ItemID = JRequest::getInt('Itemid');
	    // get current option value
	    $option = JRequest::getCmd('option');
	    // override array
	    $mootools_override = $this->parent->config->get('mootools_override');
	    // check the config
	    if (isset($mootools_override[$ItemID])) {
	        return $mootools_override[$ItemID];
	    } else {
	        return (isset($mootools_override[$option])) ? $mootools_override[$option] : false;
	    }   
	}

	public function getMooTools() {
        $isOverrided = $this->getMooToolsOverride();
        
        if($isOverrided){
            $document = JFactory::getDocument();
            $header = $document->getHeadData();
            $scripts = $header['scripts'];
            // table which contains scripts to disable
            $toRemove = array('mootools-core.js', 'mootools-more.js', 'caption.js');
       
            foreach ($scripts as $key => $value) {
                foreach ($toRemove as $remove) {
                    if (strpos($key, $remove) !== false) unset($scripts[$key]);
                }
            }
            $header['scripts'] = $scripts;
            $document->setHeadData($header);
        }
    }
}

// EOF