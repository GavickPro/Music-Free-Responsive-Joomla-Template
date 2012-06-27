<?php

// no direct access
defined('_JEXEC') or die;

?>

<?php if (count($this->items[$this->parent->id]) > 0 && $this->maxLevelcat != 0) : ?>
<ul>
<?php foreach($this->items[$this->parent->id] as $id => $item) : ?>
	<?php if ($this->params->get('show_empty_categories_cat') || $item->numitems || count($item->getChildren())) : ?>
	<li>
		<a href="<?php echo JRoute::_(ContactHelperRoute::getCategoryRoute($item->id));?>">
			<?php echo $this->escape($item->title); ?>
		</a>

		<?php if ($this->params->get('show_subcat_desc_cat') == 1 && $item->description) : ?>
		<div>
			<?php echo JHtml::_('content.prepare', $item->description, '', 'com_contact.categories'); ?>
		</div>
        <?php endif; ?>

		<?php if ($this->params->get('show_cat_items_cat') == 1) :?>
		<dl>
			<dt><?php echo JText::_('COM_CONTACT_COUNT'); ?></dt>
			<dd><?php echo $item->numitems; ?></dd>
		</dl>
		<?php endif; ?>

		<?php if(count($item->getChildren()) > 0) :
			$this->items[$item->id] = $item->getChildren();
			$this->parent = $item;
			$this->maxLevelcat--;
			echo $this->loadTemplate('items');
			$this->parent = $item->getParent();
			$this->maxLevelcat++;
		endif; ?>

	</li>
	<?php endif; ?>
<?php endforeach; ?>
</ul>
<?php endif; ?>