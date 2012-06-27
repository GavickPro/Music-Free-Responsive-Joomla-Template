<?php

defined('_JEXEC') or die;

?>
<section class="registration-complete<?php echo $this->pageclass_sfx;?>">
	<?php if ($this->params->get('show_page_heading')) : ?>
	<header>
		<h1><?php echo $this->escape($this->params->get('page_heading')); ?></h1>
	</header>
	<?php endif; ?>
</section>