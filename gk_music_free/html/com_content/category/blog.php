<?php

// no direct access
defined('_JEXEC') or die;
JHtml::_('behavior.caption'); 

JHtml::addIncludePath(JPATH_COMPONENT.'/helpers');

?>
<section class="blog<?php echo $this->pageclass_sfx;?>">
	<?php 
		if(
			$this->params->get('show_page_heading', 1) ||
			$this->params->get('show_category_title', 1) || 
			$this->params->get('page_subheading') ||
			(
				(
					$this->params->get('show_description', 1) || 
					$this->params->def('show_description_image', 1)
				)
				||
				(
					(
						$this->params->get('show_description_image') && 
						$this->category->getParams()->get('image')
					)
					||
					(
						$this->params->get('show_description') && 
						$this->category->description
					)
				)
			)
		) : 
	?>
	<header>
		<?php if ($this->params->get('show_page_heading', 1)) : ?>
		<h1><?php echo $this->escape($this->params->get('page_heading')); ?></h1>
		<?php endif; ?>
	
		<?php if ($this->params->get('show_category_title', 1) || $this->params->get('page_subheading')) : ?>
		<h2>
			<?php echo $this->escape($this->params->get('page_subheading')); ?>
			<?php if ($this->params->get('show_category_title')) : ?>
			<small><?php echo $this->category->title;?></small>
			<?php endif; ?>
		</h2>
		<?php endif; ?>
	
		<?php if ($this->params->get('show_description', 1) || $this->params->def('show_description_image', 1)) : ?>
		<div>
			<?php if ($this->params->get('show_description_image') && $this->category->getParams()->get('image')) : ?>
			<img src="<?php echo $this->category->getParams()->get('image'); ?>"/>
			<?php endif; ?>
			<?php if ($this->params->get('show_description') && $this->category->description) : ?>
			<?php echo JHtml::_('content.prepare', $this->category->description, '', 'com_content.category'); ?>
			<?php endif; ?>
		</div>
		<?php endif; ?>
	</header>
	<?php endif; ?>

	<?php $leadingcount=0 ; ?>
	<?php if (!empty($this->lead_items)) : ?>
	<div class="leading">
		<?php foreach ($this->lead_items as &$item) : ?>
			<?php
				$this->item = &$item;
				echo $this->loadTemplate('item');
			?>
			<?php
			$leadingcount++;
		?>
		<?php endforeach; ?>
	</div>
	<?php endif; ?>

	<?php
		$introcount=(count($this->intro_items));
		$counter=0;
	?>
	<?php if (!empty($this->intro_items)) : ?>
		<?php foreach ($this->intro_items as $key => &$item) : ?>
			<?php
				$key= ($key-$leadingcount)+1;
				$rowcount=( ((int)$key-1) %	(int) $this->columns) +1;
				$row = $counter / $this->columns ;
		
				if ($rowcount==1) : ?>
			<div class="items-row cols-<?php echo (int) $this->columns;?> <?php echo 'row-'.$row ; ?>">
			<?php endif; ?>
			<div class="column-<?php echo $rowcount;?><?php echo $item->state == 0 ? ' system-unpublished' : null; ?>">
				<?php
					$this->item = &$item;
					echo $this->loadTemplate('item');
				?>
			</div>
			<?php $counter++; ?>
			<?php if (($rowcount == $this->columns) or ($counter ==$introcount)): ?>
			</div>
			<?php endif; ?>
		<?php endforeach; ?>
	<?php endif; ?>

	<?php if (!empty($this->link_items)) : ?>
		<?php echo $this->loadTemplate('links'); ?>
	<?php endif; ?>

	<?php if (!empty($this->children[$this->category->id])&& $this->maxLevel != 0) : ?>
	<div class="children">
		<h3><?php echo JTEXT::_('JGLOBAL_SUBCATEGORIES'); ?></h3>
		<?php echo $this->loadTemplate('children'); ?>
	</div>
	<?php endif; ?>

	<?php if (($this->params->def('show_pagination', 1) == 1  || ($this->params->get('show_pagination') == 2)) && ($this->pagination->get('pages.total') > 1)) : ?>
	<?php echo str_replace('</ul>', '<li class="counter">'.$this->pagination->getPagesCounter().'</li>', $this->pagination->getPagesLinks()); ?>
	<?php endif; ?>
</section>