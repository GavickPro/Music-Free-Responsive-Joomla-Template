<?php

/**
 *
 * Component view
 *
 * @version             3.0.0
 * @package             Gavern Framework
 * @copyright			Copyright (C) 2010 - 2012 GavickPro. All rights reserved.
 *               
 */
 
// No direct access.
defined('_JEXEC') or die;

$print = JRequest::getCmd('print');
$option = JRequest::getCmd('option');
$view = JRequest::getCmd('view');
// include framework classes and files
require_once('lib/gk.framework.php');
// run the framework
$tpl = new GKTemplate($this, $GK_TEMPLATE_MODULE_STYLES, true);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
	<jdoc:include type="head" />
	<?php if($print == 1) : ?>
        <?php if($this->params->get('print_behaviour') == 'auto') : ?>
        <script type="text/javascript">window.addEvent('domready', function() { window.print(); });</script>
        <?php endif; ?>
        
        <?php if($this->params->get('print_behaviour') == 'button') : ?>
        <div id="btnWrapper">
            <input type="button" id="printBtn" value="<?php echo JText::_('TPL_GK_LANG_PRINT_BUTTON_TEXT'); ?>" onclick="document.getElementById('printBtn').style.display='none'; window.print(); return false;" />
        </div>
        <?php endif; ?>
	<link rel="stylesheet" href="<?php echo JURI::base(); ?>templates/<?php echo $this->template; ?>/css/system/print.css" type="text/css" />
	<link rel="stylesheet" href="<?php echo JURI::base(); ?>templates/<?php echo $this->template; ?>/css/system/print.css" type="text/css" media="Print" />
	<?php endif; ?>
	
	<?php if($option == 'com_mailto') : ?>
	<link rel="stylesheet" href="<?php echo JURI::base(); ?>templates/<?php echo $this->template; ?>/css/system/mailto.css" type="text/css" />
	<?php endif; ?>
	
	<script type="text/javascript" src="<?php echo JURI::base(); ?>templates/<?php echo $this->template; ?>/js/prefixfree.js"></script>
</head>
<body class="contentpane">
	<?php if($print != 1) : ?>
		<jdoc:include type="message" />
		<jdoc:include type="component" />
	<?php else : ?>
		<div id="gkPrintTop">
			<img src="<?php echo ($this->params->get('print_logo') != '') ? $this->params->get('print_logo') : JURI::base().'templates/'.$this->template.'/images/print_logo.png'; ?>" alt="Logo" />
		</div>
		
		<jdoc:include type="component" />
		
		<div id="gkPrintBottom">
			<?php if($this->params->get('copyrights', '') != '') : ?>
				<?php echo $this->params->get('copyrights', ''); ?>
			<?php else : ?>
				Template Design &copy; <a href="http://www.gavick.com" title="Joomla Templates">Joomla Templates</a> | GavickPro. All rights reserved.
			<?php endif; ?>
		</div>	
	<?php endif; ?>
</body>
</html>
