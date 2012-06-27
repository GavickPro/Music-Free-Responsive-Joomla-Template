<?php

// no direct access
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');

?>
<section class="blog-featured<?php echo $this->pageclass_sfx;?>">
	<?php if ($this->params->get('show_page_heading')!=0 ): ?>
	<header>	
		<h1><?php echo $this->escape($this->params->get('page_heading')); ?></h1>
	</header>
	<?php endif; ?>

	<?php echo $this->loadTemplate('items'); ?>
	
	<?php if ($this->params->def('show_pagination', 2) == 1  || ($this->params->get('show_pagination') == 2 && $this->pagination->get('pages.total') > 1)) : ?>
	<?php echo str_replace('</ul>', '<li class="counter">'.$this->pagination->getPagesCounter().'</li>', $this->pagination->getPagesLinks()); ?>
	<?php endif; ?>
</section>