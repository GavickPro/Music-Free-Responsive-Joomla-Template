<?php

/**
 * @package		K2
 * @author		GavickPro http://gavick.com
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

?>

<section id="k2Container" class="genericView<?php if($this->params->get('pageclass_sfx')) echo ' '.$this->params->get('pageclass_sfx'); ?>">
		<?php if($this->params->get('show_page_title')): ?>
		<header>
				<h1><?php echo $this->escape($this->params->get('page_title')); ?></h1>
		</header>
		<?php endif; ?>
		<?php if(count($this->items)): ?>
		<section class="itemList">
				<?php foreach($this->items as $item): ?>
				<article class="itemView">
						<header>
								<?php if($item->params->get('genericItemTitle')): ?>
								<h1>
										<?php if ($item->params->get('genericItemTitleLinked')): ?>
										<a href="<?php echo $item->link; ?>"> <?php echo $item->title; ?> </a>
										<?php else: ?>
										<?php echo $item->title; ?>
										<?php endif; ?>
								</h1>
								<?php endif; ?>
								<?php if($item->params->get('genericItemCategory') || $item->params->get('tagItemDateCreated',1)): ?>
								<ul>
										<?php if($item->params->get('tagItemDateCreated',1)): ?>
										<li>
												<time datetime="<?php echo JHTML::_('date', $item->created , JText::_('d M Y h:i')); ?>"> <?php echo JHTML::_('date', $item->created , JText::_('d F, Y')); ?> </time>
										</li>
										<?php endif; ?>
										<?php if($item->params->get('genericItemCategory')) : ?>
										<li class="itemCategory"> <span><?php echo JText::_('K2_PUBLISHED_IN'); ?></span> <a href="<?php echo $item->category->link; ?>"><?php echo $item->category->name; ?></a> </li>
										<?php endif; ?>
								</ul>
								<?php endif; ?>
						</header>
						<?php if($item->params->get('genericItemImage') && !empty($item->imageGeneric)): ?>
						<div class="itemImageBlock"> <a class="itemImage" href="<?php echo $item->link; ?>" title="<?php if(!empty($item->image_caption)) echo $item->image_caption; else echo $item->title; ?>"> <img src="<?php echo $item->imageGeneric; ?>" alt="<?php if(!empty($item->image_caption)) echo $item->image_caption; else echo $item->title; ?>" style="width:<?php echo $item->params->get('itemImageGeneric'); ?>px; height:auto;" /> </a> </div>
						<?php endif; ?>
						<div class="itemBody">
								<?php if($item->params->get('genericItemIntroText')): ?>
								<div class="itemIntroText"> <?php echo $item->introtext; ?> </div>
								<?php endif; ?>
								<?php if($item->params->get('genericItemExtraFields') && count($item->extra_fields)): ?>
								<div class="itemExtraFields">
										<h4><?php echo JText::_('K2_ADDITIONAL_INFO'); ?></h4>
										<ul>
												<?php foreach ($item->extra_fields as $key=>$extraField): ?>
												<li class="<?php echo ($key%2) ? "odd" : "even"; ?> type<?php echo ucfirst($extraField->type); ?> group<?php echo $extraField->group; ?>"> <span class="itemExtraFieldsLabel"><?php echo $extraField->name; ?></span> <span class="itemExtraFieldsValue"><?php echo ($extraField->type=='date')?JHTML::_('date', $extraField->value, JText::_('K2_DATE_FORMAT_LC')):$extraField->value; ?></span> </li>
												<?php endforeach; ?>
										</ul>
								</div>
								<?php endif; ?>
								<?php if ($item->params->get('genericItemReadMore')): ?>
								<a class="itemReadMore button" href="<?php echo $item->link; ?>"> <?php echo JText::_('K2_READ_MORE'); ?> </a>
								<?php endif; ?>
						</div>
				</article>
				<?php endforeach; ?>
		</section>
		<?php if($this->params->get('tagFeedIcon',1)): ?>
		<a class="k2FeedIcon" href="<?php echo $this->feed; ?>"><?php echo JText::_('K2_SUBSCRIBE_TO_THIS_RSS_FEED'); ?></a>
		<?php endif; ?>
		<?php if($this->pagination->getPagesLinks()): ?>
		<?php echo str_replace('</ul>', '<li class="counter">'.$this->pagination->getPagesCounter().'</li></ul>', $this->pagination->getPagesLinks()); ?>
		<?php endif; ?>
		<?php endif; ?>
</section>
