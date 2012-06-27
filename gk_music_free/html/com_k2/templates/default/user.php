<?php

/**
 * @package		K2
 * @author		GavickPro http://gavick.com
 */

// no direct access
defined('_JEXEC') or die('Restricted access');
// Get user stuff (do not change)
$user = JFactory::getUser();

?>

<section id="k2Container" class="userView<?php if($this->params->get('pageclass_sfx')) echo ' '.$this->params->get('pageclass_sfx'); ?>">
		<?php if($this->params->get('show_page_title') && $this->params->get('page_title')!=$this->user->name): ?>
		<header>
				<h1><?php echo $this->escape($this->params->get('page_title')); ?></h1>
		</header>
		<?php endif; ?>
		<?php if ($this->params->get('userImage') || $this->params->get('userName') || $this->params->get('userDescription') || $this->params->get('userURL') || $this->params->get('userEmail')): ?>
		<div class="itemAuthorBlock">
				<?php if ($this->params->get('userImage') && !empty($this->user->avatar)): ?>
				<div class="gkAvatar"> <img src="<?php echo $this->user->avatar; ?>" alt="<?php echo $this->user->name; ?>" style="width:<?php echo $this->params->get('userImageWidth'); ?>px; height:auto;" /> </div>
				<?php endif; ?>
				<div class="itemAuthorDetails">
						<?php if ($this->params->get('userName')): ?>
						<h3 class="itemAuthorName"><?php echo $this->user->name; ?></h3>
						<?php endif; ?>
						<?php if ($this->params->get('userDescription') && isset($this->user->profile->description)): ?>
						<?php echo $this->user->profile->description; ?>
						<?php endif; ?>
						<?php if ($this->params->get('userEmail')): ?>
						<span class="itemAuthorEmail"> <?php echo JText::_('K2_EMAIL'); ?>: <?php echo JHTML::_('Email.cloak', $this->user->email); ?> </span>
						<?php endif; ?>
						<?php if ($this->params->get('userURL') && isset($this->user->profile->url)): ?>
						<span class="itemAuthorURL"> <?php echo JText::_('K2_WEBSITE_URL'); ?>: <a href="<?php echo $this->user->profile->url; ?>" target="_blank" rel="me"><?php echo $this->user->profile->url; ?></a> </span>
						<?php endif; ?>
				</div>
				<?php echo $this->user->event->K2UserDisplay; ?> </div>
		<?php endif; ?>
		<?php if(count($this->items)): ?>
		<section class="itemList">
				<?php foreach ($this->items as $item): ?>
				<article class="itemView<?php if(!$item->published || ($item->publish_up != $this->nullDate && $item->publish_up > $this->now) || ($item->publish_down != $this->nullDate && $item->publish_down < $this->now)) echo ' itemViewUnpublished'; ?><?php echo ($item->featured) ? ' itemIsFeatured' : ''; ?> clearfix"> <?php echo $item->event->BeforeDisplay; ?> <?php echo $item->event->K2BeforeDisplay; ?>
						<header>
								<?php if($item->params->get('userItemTitle')): ?>
								<h1>
										<?php if ($item->params->get('userItemTitleLinked') && $item->published): ?>
										<a href="<?php echo $item->link; ?>"> <?php echo $item->title; ?> </a>
										<?php else: ?>
										<?php echo $item->title; ?>
										<?php endif; ?>
										<?php if(!$item->published || ($item->publish_up != $this->nullDate && $item->publish_up > $this->now) || ($item->publish_down != $this->nullDate && $item->publish_down < $this->now)): ?>
										<sup><?php echo JText::_('K2_UNPUBLISHED'); ?></sup>
										<?php endif; ?>
								</h1>
								<?php endif; ?>
								<ul>
										<?php if($item->params->get('userItemDateCreated')): ?>
										<li>
												<time datetime="<?php echo JHTML::_('date', $item->created , JText::_('d M Y h:i')); ?>"> <?php echo JHTML::_('date', $item->created , JText::_('d F, Y')); ?> </time>
										</li>
										<?php endif; ?>
										<?php if($item->params->get('userItemCategory')): ?>
										<li class="itemCategory"> <span><?php echo JText::_('K2_PUBLISHED_IN'); ?></span> <a href="<?php echo $item->category->link; ?>"><?php echo $item->category->name; ?></a> </li>
										<?php endif; ?>
										<?php if($item->params->get('userItemCommentsAnchor') && ( ($item->params->get('comments') == '2' && !$this->user->guest) || ($item->params->get('comments') == '1')) ): ?>
										<li class="itemComments">
												<?php if(!empty($item->event->K2CommentsCounter)): ?>
												<!-- K2 Plugins: K2CommentsCounter --> 
												<?php echo $item->event->K2CommentsCounter; ?>
												<?php else: ?>
												<?php if($item->numOfComments > 0): ?>
												<a href="<?php echo $item->link; ?>#itemCommentsAnchor"> <?php echo $item->numOfComments; ?> <?php echo ($item->numOfComments>1) ? JText::_('K2_COMMENTS') : JText::_('K2_COMMENT'); ?> </a>
												<?php else: ?>
												<a href="<?php echo $item->link; ?>#itemCommentsAnchor"> <?php echo JText::_('K2_BE_THE_FIRST_TO_COMMENT'); ?> </a>
												<?php endif; ?>
												<?php endif; ?>
										</li>
										<?php endif; ?>
								</ul>
						</header>
						<?php echo $item->event->AfterDisplayTitle; ?> <?php echo $item->event->K2AfterDisplayTitle; ?>
						<?php if($item->params->get('userItemImage') && !empty($item->imageGeneric)): ?>
						<div class="itemImageBlock"> <a class="itemImage" href="<?php echo $item->link; ?>" title="<?php if(!empty($item->image_caption)) echo K2HelperUtilities::cleanHtml($item->image_caption); else echo K2HelperUtilities::cleanHtml($item->title); ?>"> <img src="<?php echo $item->imageGeneric; ?>" alt="<?php if(!empty($item->image_caption)) echo K2HelperUtilities::cleanHtml($item->image_caption); else echo K2HelperUtilities::cleanHtml($item->title); ?>" style="width:<?php echo $item->params->get('itemImageGeneric'); ?>px; height:auto;" /> </a> </div>
						<?php endif; ?>
						<div class="itemBody"> <?php echo $item->event->BeforeDisplayContent; ?> <?php echo $item->event->K2BeforeDisplayContent; ?>
								<?php if($item->params->get('userItemIntroText')): ?>
								<div class="itemIntroText"><?php echo $item->introtext; ?></div>
								<?php endif; ?>
								<?php echo $item->event->AfterDisplayContent; ?> <?php echo $item->event->K2AfterDisplayContent; ?>
								<?php if($item->params->get('userItemTags') && count($item->tags)): ?>
								<div class="itemTagsBlock">
										<ul class="itemTags">
												<?php foreach ($item->tags as $tag): ?>
												<li><a href="<?php echo $tag->link; ?>"><?php echo $tag->name; ?></a></li>
												<?php endforeach; ?>
										</ul>
								</div>
								<?php endif; ?>
						</div>
						<?php echo $item->event->AfterDisplay; ?> <?php echo $item->event->K2AfterDisplay; ?> </article>
				<?php endforeach; ?>
		</section>
		<?php if($this->params->get('userFeedIcon',1)): ?>
		<a class="k2FeedIcon" href="<?php echo $this->feed; ?>"><?php echo JText::_('K2_SUBSCRIBE_TO_THIS_RSS_FEED'); ?></a>
		<?php endif; ?>
		<?php if(count($this->pagination->getPagesLinks())): ?>
		<?php echo str_replace('</ul>', '<li class="counter">'.$this->pagination->getPagesCounter().'</li></ul>', $this->pagination->getPagesLinks()); ?>
		<?php endif; ?>
		<?php endif; ?>
</section>
