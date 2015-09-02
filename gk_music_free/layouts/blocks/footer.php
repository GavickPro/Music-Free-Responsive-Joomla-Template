<?php

// No direct access.
defined('_JEXEC') or die;

$app    = JFactory::getApplication();
$menu 	= $app->getMenu();
$lang 	= JFactory::getLanguage();

?>

<footer id="gkFooter">
	<a href="#gkPageWrap" id="gkTopLink">Top</a>
	
	<?php if($this->API->get('framework_logo', '0') == '1') : ?>
	<a href="https://www.gavick.com/" id="gkFrameworkLogo" title="Gavern Framework">Gavern Framework</a>
	<?php endif; ?>
	
	<?php if($this->API->modules('footer_nav')) : ?>
	<jdoc:include type="modules" name="footer_nav" style="<?php echo $this->module_styles['footer_nav']; ?>" />	
	<?php endif; ?>
	
	<?php if($this->API->get('copyrights', '') !== '') : ?>
	<p>
		<?php echo $this->API->get('copyrights', ''); ?> 
		<?php if ($menu->getActive() == $menu->getDefault($lang->getTag())) : ?> 
			<p>Joomla Template Design by <a href="https://www.gavick.com/" title="Joomla Templates">GavickPro</a></p>
		<?php else : ?>
			<p>Joomla Template Design by GavickPro</p>
		<?php endif; ?>
	</p>
	<?php else : ?>

		<?php if ($menu->getActive() == $menu->getDefault($lang->getTag())) : ?> 
			<p>Joomla Template Design by <a href="https://www.gavick.com/" title="Joomla Templates">GavickPro</a></p>
		<?php else : ?>
			<p>Joomla Template Design by GavickPro</p>
		<?php endif; ?>
	
	<?php endif; ?>
	
	<?php if($this->API->get('stylearea', '0') == '1') : ?>
	<div id="gkStyleArea"> 
		<a href="#" id="gkColor1"><?php echo JText::_('TPL_GK_LANG_COLOR_1'); ?></a> 
		<a href="#" id="gkColor2"><?php echo JText::_('TPL_GK_LANG_COLOR_2'); ?></a> 
		<a href="#" id="gkColor3"><?php echo JText::_('TPL_GK_LANG_COLOR_3'); ?></a>  
	</div>
	<?php endif; ?>
</footer>