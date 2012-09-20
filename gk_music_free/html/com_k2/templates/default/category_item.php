<?php

/**
 * @package		K2
 * @author		GavickPro http://gavick.com
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

// Define default image size (do not change)
K2HelperUtilities::setDefaultImage($this->item, 'itemlist', $this->params);

?>

<article class="itemView group<?php echo ucfirst($this->item->itemGroup); ?><?php echo ($this->item->featured) ? ' itemIsFeatured' : ''; ?><?php if($this->item->params->get('pageclass_sfx')) echo ' '.$this->item->params->get('pageclass_sfx'); ?>"> <?php echo $this->item->event->BeforeDisplay; ?> <?php echo $this->item->event->K2BeforeDisplay; ?>
		<header>
				<?php if(isset($this->item->editLink)): ?>
				<a class="catItemEditLink modal" rel="{handler:'iframe',size:{x:990,y:550}}" href="<?php echo $this->item->editLink; ?>">
					<?php echo JText::_('K2_EDIT_ITEM'); ?>
				</a>
				<?php endif; ?>
		
				<?php if($this->item->params->get('catItemTitle')): ?>
				<h2>
						<?php if ($this->item->params->get('catItemTitleLinked')): ?>
						<a href="<?php echo $this->item->link; ?>"><?php echo $this->item->title; ?></a>
						<?php else: ?>
						<?php echo $this->item->title; ?>
						<?php endif; ?>
						<?php if($this->item->params->get('catItemFeaturedNotice') && $this->item->featured): ?>
						<sup><?php echo JText::_('K2_FEATURED'); ?></sup>
						<?php endif; ?>
				</h2>
				<?php endif; ?>
				<ul>
						<?php if($this->item->params->get('catItemDateCreated')): ?>
						<li>
								<time datetime="<?php echo JHTML::_('date', $this->item->created, JText::_('d M Y h:i')); ?>"> <?php echo JHTML::_('date', $this->item->created, JText::_('d F, Y')); ?> </time>
						</li>
						<?php endif; ?>
						<?php if($this->item->params->get('catItemCategory')): ?>
						<li class="itemCategory"> <span><?php echo JText::_('K2_PUBLISHED_IN'); ?></span> <a href="<?php echo $this->item->category->link; ?>"><?php echo $this->item->category->name; ?></a> </li>
						<?php endif; ?>
						<?php if($this->item->params->get('catItemAuthor')): ?>
						<li class="itemAuthor"> <?php echo K2HelperUtilities::writtenBy($this->item->author->profile->gender); ?> <a rel="author" href="<?php echo $this->item->author->link; ?>"><?php echo $this->item->author->name; ?></a> </li>
						<?php endif; ?>
						<?php if($this->item->params->get('catItemCommentsAnchor')): ?>
						<li class="itemComments"> 
						<?php if(!empty($this->item->event->K2CommentsCounter)): ?>
							<!-- K2 Plugins: K2CommentsCounter -->
							<?php echo $this->item->event->K2CommentsCounter; ?>
						<?php else: ?>
							<?php if($this->item->numOfComments > 0): ?>
							<a href="<?php echo $this->item->link; ?>#itemCommentsAnchor">
								<?php echo $this->item->numOfComments; ?> <?php echo ($this->item->numOfComments>1) ? JText::_('K2_COMMENTS') : JText::_('K2_COMMENT'); ?>
							</a>
							<?php else: ?>
							<a href="<?php echo $this->item->link; ?>#itemCommentsAnchor">
								<?php echo JText::_('K2_BE_THE_FIRST_TO_COMMENT'); ?>
							</a>
							<?php endif; ?>
						<?php endif; ?>
						</li>
						<?php endif; ?>
						<?php if($this->item->params->get('catItemRating')): ?>
						<li class="itemRatingBlock"> <span><?php echo JText::_('K2_RATE_THIS_ITEM'); ?></span>
								<div class="itemRatingForm">
										<ul class="itemRatingList">
												<li class="itemCurrentRating" id="itemCurrentRating<?php echo $this->item->id; ?>" style="width:<?php echo $this->item->votingPercentage; ?>%;"></li>
												<li><a href="#" rel="<?php echo $this->item->id; ?>" title="<?php echo JText::_('K2_1_STAR_OUT_OF_5'); ?>" class="one-star">1</a></li>
												<li><a href="#" rel="<?php echo $this->item->id; ?>" title="<?php echo JText::_('K2_2_STARS_OUT_OF_5'); ?>" class="two-stars">2</a></li>
												<li><a href="#" rel="<?php echo $this->item->id; ?>" title="<?php echo JText::_('K2_3_STARS_OUT_OF_5'); ?>" class="three-stars">3</a></li>
												<li><a href="#" rel="<?php echo $this->item->id; ?>" title="<?php echo JText::_('K2_4_STARS_OUT_OF_5'); ?>" class="four-stars">4</a></li>
												<li><a href="#" rel="<?php echo $this->item->id; ?>" title="<?php echo JText::_('K2_5_STARS_OUT_OF_5'); ?>" class="five-stars">5</a></li>
										</ul>
										<div id="itemRatingLog<?php echo $this->item->id; ?>" class="itemRatingLog"><?php echo $this->item->numOfvotes; ?></div>
								</div>
						</li>
						<?php endif; ?>
						<?php if($this->item->params->get('catItemHits')): ?>
						<li class="itemHitsBlock"> <span class="itemHits"><?php echo JText::_('K2_READ'); ?>: <?php echo $this->item->hits; ?> <?php echo JText::_('K2_TIMES'); ?></span> </li>
						<?php endif; ?>
						<?php if($this->item->params->get('catItemDateModified') && $this->item->created != $this->item->modified): ?>
						<li class="itemDateModified"> <?php echo JText::_('K2_LAST_MODIFIED_ON'); ?> <?php echo JHTML::_('date', $this->item->modified, JText::_('K2_DATE_FORMAT_LC2')); ?> </li>
						<?php endif; ?>
						<?php echo $this->item->event->AfterDisplay; ?> <?php echo $this->item->event->K2AfterDisplay; ?>
				</ul>
		</header>
		<?php echo $this->item->event->AfterDisplayTitle; ?> <?php echo $this->item->event->K2AfterDisplayTitle; ?>
		<div class="itemBlock">
				<?php if($this->item->params->get('catItemImage') && !empty($this->item->image)): ?>
				<div class="itemImageBlock"> <a class="itemImage" href="<?php echo $this->item->link; ?>" title="<?php if(!empty($this->item->image_caption)) echo K2HelperUtilities::cleanHtml($this->item->image_caption); else echo K2HelperUtilities::cleanHtml($this->item->title); ?>"> <img src="<?php echo $this->item->image; ?>" alt="<?php if(!empty($this->item->image_caption)) echo K2HelperUtilities::cleanHtml($this->item->image_caption); else echo K2HelperUtilities::cleanHtml($this->item->title); ?>" style="width:<?php echo $this->item->imageWidth; ?>px; height:auto;" /> </a> </div>
				<?php endif; ?>
				<div class="itemBody"> <?php echo $this->item->event->BeforeDisplayContent; ?> <?php echo $this->item->event->K2BeforeDisplayContent; ?>
						<?php if($this->item->params->get('catItemIntroText')): ?>
						<div class="itemIntroText"> <?php echo $this->item->introtext; ?> </div>
						<?php endif; ?>
						<?php if($this->item->params->get('catItemExtraFields') && count($this->item->extra_fields)): ?>
						<div class="itemExtraFields">
								<h4><?php echo JText::_('K2_ADDITIONAL_INFO'); ?></h4>
								<ul>
										<?php foreach ($this->item->extra_fields as $key=>$extraField): ?>
										<?php if($extraField->value): ?>
										<li class="<?php echo ($key%2) ? "odd" : "even"; ?> type<?php echo ucfirst($extraField->type); ?> group<?php echo $extraField->group; ?>"> <span class="itemExtraFieldsLabel"><?php echo $extraField->name; ?></span> <span class="itemExtraFieldsValue"><?php echo $extraField->value; ?></span> </li>
										<?php endif; ?>
										<?php endforeach; ?>
								</ul>
						</div>
						<?php endif; ?>
						<?php if($this->item->params->get('catItemVideo') && !empty($this->item->video)): ?>
						<div class="itemVideoBlock">
								<h3><?php echo JText::_('K2_RELATED_VIDEO'); ?></h3>
								<?php if($this->item->videoType=='embedded'): ?>
								<div class="itemVideoEmbedded"> <?php echo $this->item->video; ?> </div>
								<?php else: ?>
								<span class="itemVideo"><?php echo $this->item->video; ?></span>
								<?php endif; ?>
						</div>
						<?php endif; ?>
						<?php if($this->item->params->get('catItemImageGallery') && !empty($this->item->gallery)): ?>
						<div class="itemImageGallery">
								<h4><?php echo JText::_('K2_IMAGE_GALLERY'); ?></h4>
								<?php echo $this->item->gallery; ?> </div>
						<?php endif; ?>
						<?php if($this->item->params->get('catItemAttachments') && count($this->item->attachments)): ?>
						<div class="itemAttachmentsBlock"> <span><?php echo JText::_('K2_DOWNLOAD_ATTACHMENTS'); ?></span>
								<ul class="itemAttachments">
										<?php foreach ($this->item->attachments as $attachment): ?>
										<li> <a title="<?php echo K2HelperUtilities::cleanHtml($attachment->titleAttribute); ?>" href="<?php echo $attachment->link; ?>"> <?php echo $attachment->title ; ?> </a>
												<?php if($this->item->params->get('catItemAttachmentsCounter')): ?>
												<span>(<?php echo $attachment->hits; ?> <?php echo ($attachment->hits==1) ? JText::_('K2_DOWNLOAD') : JText::_('K2_DOWNLOADS'); ?>)</span>
												<?php endif; ?>
										</li>
										<?php endforeach; ?>
								</ul>
						</div>
						<?php endif; ?>
						<?php if ($this->item->params->get('catItemReadMore')): ?>
						<a class="itemReadMore button" href="<?php echo $this->item->link; ?>"> <?php echo JText::_('K2_READ_MORE'); ?> </a>
						<?php endif; ?>
						<?php echo $this->item->event->AfterDisplayContent; ?> <?php echo $this->item->event->K2AfterDisplayContent; ?>
						<?php if($this->item->params->get('catItemTags') && count($this->item->tags)): ?>
						<ul class="itemTags">
								<?php foreach ($this->item->tags as $tag): ?>
								<li> <a href="<?php echo $tag->link; ?>"><?php echo $tag->name; ?></a> </li>
								<?php endforeach; ?>
						</ul>
						<?php endif; ?>
				</div>
		</div>
</article>
