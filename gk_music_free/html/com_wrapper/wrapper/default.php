<?php

// no direct access
defined('_JEXEC') or die;

?>
<script type="text/javascript">
function iFrameHeight() {
	var h = 0;
	if (!document.all) {
		h = document.getElementById('blockrandom').contentDocument.height;
		document.getElementById('blockrandom').style.height = h + 60 + 'px';
	} else if (document.all) {
		h = document.frames('blockrandom').document.body.scrollHeight;
		document.all.blockrandom.style.height = h + 20 + 'px';
	}
}
</script>

<section class="contentpane<?php echo $this->pageclass_sfx; ?>">
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
	
	<iframe <?php echo $this->wrapper->load; ?>
		id="blockrandom"
		name="iframe"
		src="<?php echo $this->escape($this->wrapper->url); ?>"
		width="<?php echo $this->escape($this->params->get('width')); ?>"
		height="<?php echo $this->escape($this->params->get('height')); ?>"
		scrolling="<?php echo $this->escape($this->params->get('scrolling')); ?>">
		<?php echo JText::_('COM_WRAPPER_NO_IFRAMES'); ?>
	</iframe>
</section>