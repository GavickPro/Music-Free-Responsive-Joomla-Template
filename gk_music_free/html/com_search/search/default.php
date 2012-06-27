<?php

// no direct access
defined('_JEXEC') or die;

?>

<section class="search<?php echo $this->pageclass_sfx; ?>">
	<?php if ($this->params->get('show_page_heading', 1)) : ?>
	<header>
		<h1>
		<?php if ($this->escape($this->params->get('page_heading'))) :?>
			<?php echo $this->escape($this->params->get('page_heading')); ?>
		<?php else : ?>
			<?php echo $this->escape($this->params->get('page_title')); ?>
		<?php endif; ?>
		</h1>
	</header>
	<?php endif; ?>
	
	<?php echo $this->loadTemplate('form'); ?>
	<?php if ($this->error==null && count($this->results) > 0) :
		echo $this->loadTemplate('results');
	else :
		echo $this->loadTemplate('error');
	endif; ?>
</section>
