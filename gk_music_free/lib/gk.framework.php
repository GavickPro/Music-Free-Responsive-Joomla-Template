<?php

/**
 *
 * Main framework class
 *
 * @version             1.0.0
 * @package             Gavern Framework
 * @copyright			Copyright (C) 2010 - 2011 GavickPro. All rights reserved.
 *               
 */
 
// No direct access.
defined('_JEXEC') or die;

require_once(dirname(__file__) . DS . 'framework' . DS . 'gk.parser.php');
require_once(dirname(__file__) . DS . 'framework' . DS . 'gk.browser.php');

require_once(dirname(__file__) . DS . 'framework' . DS . 'helper.api.php');
require_once(dirname(__file__) . DS . 'framework' . DS . 'helper.cache.php');
require_once(dirname(__file__) . DS . 'framework' . DS . 'helper.layout.php');
require_once(dirname(__file__) . DS . 'framework' . DS . 'helper.menu.php');
require_once(dirname(__file__) . DS . 'framework' . DS . 'helper.mootools.php');
require_once(dirname(__file__) . DS . 'framework' . DS . 'helper.social.php');
require_once(dirname(__file__) . DS . 'framework' . DS . 'helper.utilities.php');

/*
* Main framework class
*/
class GKTemplate {
    // template name
    public $name = 'music_free_j25';
    // access to the standard Joomla! template API
    public $API;
    // access to the helper classes
    public $cache;
    public $layout;
    public $social;
    public $utilities;
    public $menu;
    public $mootools;
    // detected browser:
    public $browser;
    // page config
    public $config;
    // page menu
    public $mainmenu;
    // mobile menu
    public $mobilemenu;
    // module styles
    public $module_styles;
    // page suffix
    public $page_suffix;
    
    // constructor
    public function __construct($tpl, $module_styles, $embed_mode = false) {
        // load the mootools
        JHtml::_('behavior.framework', true);
		// put the template handler into API field
        $this->API = new GKTemplateAPI($tpl);
        $this->APITPL = $tpl;
        // get the helpers
        $this->cache = new GKTemplateCache($this);
        $this->social = new GKTemplateSocial($this);
        $this->utilities = new GKTemplateUtilities($this);
        $this->menu = new GKTemplateMenu($this);
        $this->mootools = new GKTemplateMooTools($this);
        // create instance of GKBrowser class and detect
        $browser = new GKBrowser();
        $this->browser = $browser->result;
        // get the params
        $this->getParameters();
        // get the page suffix
        $this->getSuffix();
        // put the styles to class field
        $this->module_styles = $module_styles;
        // get the modules overrides
        $this->getModuleStylesOverride();
        // get type and generate menu
        $this->mainmenu = $this->menu->getMenuType();
        $this->mobilemenu = $this->menu->getMenuType(true);
		// enable/disable mootools for pages 
        $this->mootools->getMooTools();
        // load the layout helper
        $this->layout = new GKTemplateLayout($this);
        // get the layout
        if(!$embed_mode) {   
    		if ($this->browser->get('browser') == 'facebook') { // facebook mode
				$this->getLayout('facebook');
			} else { // normal mode
				$this->getLayout('normal');
    		}
        }
        // parse FB and Twitter buttons
        $this->social->socialApiParser($embed_mode);
        // define an event for replacement
        $dispatcher = JDispatcher::getInstance();
 		// set a proper event for GKParserPlugin 
 		if($this->API->get('use_gk_cache', 0) == 0) {
 			$dispatcher->register('onAfterRender', 'GKParserPlugin');
 		} else {
 			$dispatcher->register('onBeforeCache', 'GKParserPlugin');
 		}
    }
    
    // get the template parameters in PHP form
    public function getParameters() {
        // create config object
        $this->config = new JObject();
        // set layout override param
        $this->config->set('layout_override', $this->utilities->overrideArrayParse($this->API->get('layout_override', '')));
        $this->config->set('suffix_override', $this->utilities->overrideArrayParse($this->API->get('suffix_override', '')));
        $this->config->set('module_override', $this->utilities->overrideArrayParse($this->API->get('module_override', '')));  
        $this->config->set('tools_override', $this->utilities->overrideArrayParse($this->API->get('tools_for_pages', '')));
    	$this->config->set('mootools_override', $this->utilities->overrideArrayParse($this->API->get('mootools_for_pages', '')));
    	$this->config->set('content_width_override', $this->utilities->overrideArrayParse($this->API->get('content_width_for_pages', '')));
	}
   
    // function to get layout for specified mode
    public function getLayout($mode) {
        // check layout saved in cookie
		if ($mode == 'facebook') { // facebook mode
			$layoutpath = $this->API->URLtemplatepath() . DS . 'layouts' . DS . $this->API->get('facebook_layout', 'facebook') . '.php';
			if (is_file($layoutpath)) include ($layoutpath);
			else echo 'Facebook layout doesn\'t exist!';
		} else { // normal mode
			// check the override
			$is_overrided = $this->getLayoutOverride();
			// if current page is overrided
			if ($is_overrided !== false) {
				$layoutpath = $this->API->URLtemplatepath() . DS . 'layouts' . DS . $is_overrided . '.php';
				if (is_file($layoutpath)) {
					include ($layoutpath);
				} else {	
					$layoutpath = $this->API->URLtemplatepath() . DS . 'layouts' . DS . $this->API->get('default_layout', 'default') . '.php';
					if (is_file($layoutpath)) {
						include ($layoutpath);
					} else {
						echo 'Default layout doesn\'t exist!';
					}
				}
			} else { // else - load default layout
				$layoutpath = $this->API->URLtemplatepath() . DS . 'layouts' . DS . $this->API->get('default_layout', 'default') . '.php';
				if (is_file($layoutpath)) {
					include ($layoutpath);	
				} else {
					echo 'Default layout doesn\'t exist!';
				}
			}	
    	}
    }
   
    // function to get layout override
    public function getLayoutOverride() {
        // get current ItemID
        $ItemID = JRequest::getInt('Itemid');
        // get current option value
        $option = JRequest::getCmd('option');
        
        // override array
        $layout_overrides = $this->config->get('layout_override');
        // check the config
        if (isset($layout_overrides[$ItemID])) {
            return $layout_overrides[$ItemID];
        } else {
            if (isset($layout_overrides[$option])) {
                return $layout_overrides[$option];
            } else {
                return false;
            }
        }
    }

	// function to get page suffix
	public function getModuleStylesOverride() {
	    if(is_array($this->module_styles)) {
		    $keys = array_keys($this->module_styles);
		    $module_override = $this->config->get('module_override');
		    
		    for($i = 0; $i < count($keys); $i++) {
		    	if(isset($module_override[$keys[$i]])) {
		    		$this->module_styles[$keys[$i]] = $module_override[$keys[$i]];
		    	}
		    }
	    }
	}

	// function to get page suffix
	public function getSuffix() {
	    // check the override
	    $is_overrided = $this->getSuffixOverride();
	    // if current page is overrided
	    if ($is_overrided !== false) {
	        $this->page_suffix = $is_overrided;
	    } else { 
	    	$this->page_suffix = '';
	    }
	}

	// function to get layout override
	public function getSuffixOverride() {
	    // get current ItemID
	    $ItemID = JRequest::getInt('Itemid');
	    // get current option value
	    $option = JRequest::getCmd('option');
	    // override array
	    $suffix_overrides = $this->config->get('suffix_override');
	    // check the config
	    if (isset($suffix_overrides[$ItemID])) {
	        return $suffix_overrides[$ItemID];
	    } else {
	        if (isset($suffix_overrides[$option])) {
	            return $suffix_overrides[$option];
	        } else {
	            return false;
	        }
	    }
	}
	
	// function to get tools override
    public function getToolsOverride() {
		// get current ItemID
		$ItemID = JRequest::getInt('Itemid');
		// get current option value
		$option = JRequest::getCmd('option');
		// override array
		$tools_override = $this->config->get('tools_override');
		// get current tools setting
        $tools_type = $this->API->get('tools', 'all');
        //
        if($tools_type == 'all') { 
        	return true; 
        } else if($tools_type == 'none') { 
        	return false; 
        } else if($tools_type == 'selected') {
            return isset($tools_override[$ItemID]) || isset($tools_override[$option]);
        } else {
            return !isset($tools_override[$ItemID]) && !isset($tools_override[$option]);
        }
    }
}

if(!function_exists('GKParserPlugin')){
	function GKParserPlugin(){
		$parser = new GKParser();
	}
}