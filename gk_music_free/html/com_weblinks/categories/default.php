<?php

// no direct access
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT.'/helpers');

?>
<section class="categories-list<?php echo $this->pageclass_sfx;?>">
	<?php if (
				$this->params->get('show_page_heading', 1) ||
				(
					$this->params->get('show_base_description')	&&
					(
						$this->params->get('categories_description') ||
						$this->parent->description
					)
				)
	) : ?>
	<header>
		<?php if ($this->params->get('show_page_heading', 1)) : ?>
		<h1><?php echo $this->escape($this->params->get('page_heading')); ?></h1>
		<?php endif; ?>
		
		<?php if ($this->params->get('show_base_description')) : ?>
			<?php if($this->params->get('categories_description')) : ?>
			<?php echo JHtml::_('content.prepare', $this->params->get('categories_description'), '', 'com_weblinks.categories'); ?>
			<?php else: ?>
				<?php if ($this->parent->description) : ?>
				<?php echo JHtml::_('content.prepare', $this->parent->description, '', 'com_weblinks.categories'); ?>
				<?php endif; ?>
			<?php endif; ?>
		<?php endif; ?>
	</header>
	<?php endif; ?>
	
	<?php echo $this->loadTemplate('items'); ?>
</section>
