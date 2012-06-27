<?php

// no direct access
defined('_JEXEC') or die;

?>
<section class="newsfeed<?php echo $this->pageclass_sfx?><?php echo $direction; ?>">
	<header>
		<?php if ($this->params->get('show_page_heading', 1)) : ?>
		<h1><?php echo $this->escape($this->params->get('page_heading')); ?></h1>
		<?php endif; ?>
		
		<h2>
			<a href="<?php echo $this->newsfeed->channel['link']; ?>" target="_blank">
				<?php echo str_replace('&apos;', "'", $this->newsfeed->channel['title']); ?></a>
		</h2>
	
		<?php if ($this->params->get('show_feed_description')) : ?>
		<div>
			<?php echo str_replace('&apos;', "'", $this->newsfeed->channel['description']); ?>
		</div>
		<?php endif; ?>
	</header>

	<?php if (isset($this->newsfeed->image['url']) && isset($this->newsfeed->image['title']) && $this->params->get('show_feed_image')) : ?>
	<div class="feed-img">
		<img src="<?php echo $this->newsfeed->image['url']; ?>" alt="<?php echo $this->newsfeed->image['title']; ?>" />
	</div>
	<?php endif; ?>

	<ol>
	<?php foreach ($this->newsfeed->items as $item) :  ?>
		<li>
			<?php if (!is_null($item->get_link())) : ?>
			<a href="<?php echo $item->get_link(); ?>" target="_blank">
					<?php echo $item->get_title(); ?></a>
			<?php endif; ?>
			<?php if ($this->params->get('show_item_description') && $item->get_description()) : ?>
			<div class="feed-item-description">
				<?php $text = $item->get_description();
				if($this->params->get('show_feed_image', 0) == 0)
				{
					$text = JFilterOutput::stripImages($text);
				}
				$text = JHtml::_('string.truncate', $text, $this->params->get('feed_character_count'));
					echo str_replace('&apos;', "'", $text);
				?>

			</div>
			<?php endif; ?>
		</li>
	<?php endforeach; ?>
	</ol>
</section>