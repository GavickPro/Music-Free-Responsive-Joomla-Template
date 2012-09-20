<?php

/**
 *
 * Framework module styles
 *
 * @version             1.0.0
 * @package             GK Framework
 * @copyright			Copyright (C) 2010 - 2011 GavickPro. All rights reserved.
 * @license                
 */
 
// No direct access.
defined('_JEXEC') or die;

/**
 * gk_style
 */
 
function modChrome_gk_style($module, $params, $attribs) {
	if(preg_match('@ clear@', $params->get('moduleclass_sfx'))) {
		if (!empty ($module->content)) {		
			echo '<div class="box' . $params->get('moduleclass_sfx') . '">';
			if($module->showtitle) {
			    if($params->get('module_link_switch')) {
			       echo '<h3 class="header"><a href="'. $params->get('module_link') .'">' . $module->title . '</a></h3>';
			    } else {
			       echo '<h3 class="header">' . $module->title . '</h3>';
			    }
			 }
			echo $module->content;
			echo '</div>';
			}
	} else {
		if (!empty ($module->content)) {		
			echo '<div class="box' . $params->get('moduleclass_sfx') . '"><div>';
			
			if($module->showtitle) {
			    if($params->get('module_link_switch')) {
			       echo '<h3 class="header"><a href="'. $params->get('module_link') .'">' . $module->title . '</a></h3>';
			    } else {
			       echo '<h3 class="header">' . $module->title . '</h3>';
			    }
			 }
		
			echo '<div class="content">' . $module->content . '</div>';
			echo '</div></div>';
	 	}
	}
}


// EOF