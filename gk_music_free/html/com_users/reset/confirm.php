<?php

defined('_JEXEC') or die;

JHtml::_('behavior.keepalive');
JHtml::_('behavior.formvalidation');
?>
<section class="reset-confirm<?php echo $this->pageclass_sfx?>">
	<?php if ($this->params->get('show_page_heading')) : ?>
	<header>
		<h1><?php echo $this->escape($this->params->get('page_heading')); ?></h1>
	</header>
	<?php endif; ?>

	<form action="<?php echo JRoute::_('index.php?option=com_users&task=reset.confirm'); ?>" method="post" class="form-validate">
		<?php foreach ($this->form->getFieldsets() as $fieldset): ?>
		<p><?php echo JText::_($fieldset->label); ?></p>
		<fieldset>
			<dl>
			<?php foreach ($this->form->getFieldset($fieldset->name) as $name => $field): ?>
				<dt><?php echo $field->label; ?></dt>
				<dd><?php echo $field->input; ?></dd>
			<?php endforeach; ?>
			</dl>
		</fieldset>
		<?php endforeach; ?>

		<div>
			<button type="submit" class="validate"><?php echo JText::_('JSUBMIT'); ?></button>
			<?php echo JHtml::_('form.token'); ?>
		</div>
	</form>
</section>