<?php

/**
 *
 * Main file
 *
 * @version             3.0.0
 * @package             Gavern Framework
 * @license				GPL v.2.0
 * @copyright			Copyright (C) 2010 - 2012 GavickPro. All rights reserved.
 *               
 */
 
// No direct access.
defined('_JEXEC') or die;
if(!defined('DS')){
   define('DS',DIRECTORY_SEPARATOR);
}
// include framework classes and files
require_once('lib/gk.framework.php');
require_once('lib/framework/gk.const.php');
// run the framework
$tpl = new GKTemplate($this, $GK_TEMPLATE_MODULE_STYLES);

// EOF