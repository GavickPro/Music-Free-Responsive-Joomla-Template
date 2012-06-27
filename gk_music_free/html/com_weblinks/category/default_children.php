<?php

// no direct access
defined('_JEXEC') or die;

?>

<?php if (count($this->children[$this->category->id]) > 0 && $this->maxLevel != 0) : ?>
<ul>
<?php foreach($this->children[$this->category->id] as $id => $child) : ?>
	<?php if($this->params->get('show_empty_categories') || $child->numitems || count($child->getChildren())) : ?>
	<li>
		<a href="<?php echo JRoute::_(WeblinksHelperRoute::getCategoryRoute($child->id));?>">
			<?php echo $this->escape($child->title); ?>
		</a>

		<?php if ($this->params->get('show_subcat_desc') == 1 && $child->description) : ?>
		<div><?php echo JHtml::_('content.prepare', $child->description, '', 'com_weblinks.category'); ?></div>
        <?php endif; ?>

        <?php if ($this->params->get('show_cat_num_links') == 1) :?>
		<dl>
			<dt><?php echo JText::_('COM_WEBLINKS_NUM'); ?></dt>
			<dd><?php echo $child->numitems; ?></dd>
		</dl>
		<?php endif; ?>

		<?php if(count($child->getChildren()) > 0 ) :
			$this->children[$child->id] = $child->getChildren();
			$this->category = $child;
			$this->maxLevel--;
			echo $this->loadTemplate('children');
			$this->category = $child->getParent();
			$this->maxLevel++;
		endif; ?>
	</li>
	<?php endif; ?>
<?php endforeach; ?>
</ul>
<?php endif; ?>