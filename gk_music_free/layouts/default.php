<?php

/**
 *
 * Default view
 *
 * @version             1.0.0
 * @package             Gavern Framework
 * @copyright			Copyright (C) 2010 - 2011 GavickPro. All rights reserved.
 *               
 */
 
// No direct access.
defined('_JEXEC') or die;
// 
$this->layout->generateLayout(20);
//
$app = JFactory::getApplication();
$user = JFactory::getUser();
// getting User ID
$userID = $user->get('id');
// getting params
$option = JRequest::getCmd('option', '');
$view = JRequest::getCmd('view', '');
// defines if login is active
define('GK_LOGIN', $this->API->modules('login'));
// defines if com_users
define('GK_COM_USERS', $option == 'com_users' && ($view == 'login' || $view == 'registration'));
// other variables
$btn_login_text = ($userID == 0) ? JText::_('TPL_GK_LANG_LOGIN') : JText::_('TPL_GK_LANG_LOGOUT');
$tpl_page_suffix = $this->page_suffix != '' ? ' class="'.$this->page_suffix.'"' : '';

?>
<!DOCTYPE html>
<html lang="<?php echo $this->APITPL->language; ?>">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=<?php echo $this->API->get("zoom_scale", "1.0"); ?>">
<jdoc:include type="head" />
<?php $this->layout->loadBlock('head'); ?>
<?php $this->layout->loadBlock('cookielaw'); ?>
</head>
<body<?php echo $tpl_page_suffix; ?><?php if($this->browser->get("tablet") == true) echo ' data-tablet="true"'; ?><?php $this->layout->generateLayoutWidths(); ?><?php echo ' data-loading-translation="'.JText::_('TPL_GK_LANG_SIDEBAR_LOADING').'"'; ?>>
<?php if ($this->browser->get('browser') == 'ie7' || $this->browser->get('browser') == 'ie6') : ?>
<!--[if lte IE 7]>
<div id="ieToolbar"><div><?php echo JText::_('TPL_GK_LANG_IE_TOOLBAR'); ?></div></div>
<![endif]-->
<?php endif; ?>
<?php if(count($app->getMessageQueue())) : ?>
<jdoc:include type="message" />
<?php endif; ?>
<div id="gkPageWrap">
	<section id="gkPageTop">
		<?php $this->layout->loadBlock('logo'); ?>
		
		<?php if($this->API->modules('login or top_toolbar or lang') || ($this->API->get('register_link', 1) && $userID == 0) ) : ?>
		<div id="gkUserLinks">
			<?php if($this->API->modules('top_toolbar')) : ?>
			<div id="gkTopToolbar">
				<jdoc:include type="modules" name="top_toolbar" style="<?php echo $this->module_styles['top_toolbar']; ?>" />
			</div>
			<?php endif; ?>
						
			<?php if($this->API->modules('lang')) : ?>
				<jdoc:include type="modules" name="lang" style="<?php echo $this->module_styles['lang']; ?>" />
			<?php endif; ?>
				
			<?php if($this->API->get('register_link', 1) && $userID == 0) : ?>
			<a id="btnRegister" href="<?php echo $this->API->URLbase(); ?>index.php?option=com_users&amp;view=registration"><?php echo JText::_('TPL_GK_LANG_REGISTER'); ?></a>
			<?php endif; ?>
			
			<?php if($this->API->modules('login')) : ?>
			<a href="<?php echo $this->API->URLbase(); ?>index.php?option=com_users&amp;view=login" id="btnLogin"><?php echo $btn_login_text; ?></a>
			<?php endif; ?>


		</div>
		<?php endif; ?>
		<?php if($this->API->get('show_menu',1) == 1) : ?>
		<div id="gkMainMenu">
			<?php
				$this->mainmenu->loadMenu($this->API->get('menu_name','mainmenu')); 
			    $this->mainmenu->genMenu($this->API->get('startlevel', 0), $this->API->get('endlevel',-1));
			?>
			<div id="gkMobileMenu">
				<select onChange="window.location.href=this.value;">
				<?php 
    	    		$this->mobilemenu->loadMenu($this->API->get('menu_name','mainmenu')); 
    	    		$this->mobilemenu->genMenu($this->API->get('startlevel', 0), $this->API->get('endlevel',-1));
    			?>
				</select>
			</div>
		</div>
		<?php endif; ?>
	</section>
	
	<?php if($this->API->modules('social + toolbar')) : ?>
	<section id="gkToolbar">
		<jdoc:include type="modules" name="toolbar" style="<?php echo $this->module_styles['toolbar']; ?>" />
		<jdoc:include type="modules" name="social" style="<?php echo $this->module_styles['social']; ?>" />
	</section>
	<?php endif; ?>
	
	<?php if($this->API->modules('top')) : ?>
	<section id="gkTop" class="masonry">
		<jdoc:include type="modules" name="top" style="<?php echo $this->module_styles['top']; ?>" />
	</section>
	<?php endif; ?>
	
	<div id="gkPageContent">
		<section id="gkPage" class="masonry">
			<section id="gkContent" class="box">
				<div>
					<?php if($this->API->modules('mainbody_top')) : ?>
					<section id="gkMainbodyTop">
						<jdoc:include type="modules" name="mainbody_top" style="<?php echo $this->module_styles['mainbody_top']; ?>" />
					</section>
					<?php endif; ?>
						
					<?php if($this->API->modules('breadcrumb') || $this->getToolsOverride()) : ?>
					<section id="gkBreadcrumb">
						<?php if($this->API->modules('breadcrumb')) : ?>
						<jdoc:include type="modules" name="breadcrumb" style="<?php echo $this->module_styles['breadcrumb']; ?>" />
						<?php endif; ?>
						
						<?php if($this->getToolsOverride()) : ?>
						<?php $this->layout->loadBlock('tools/tools'); ?>
						<?php endif; ?>
					</section>
					<?php endif; ?>
					
					<section id="gkMainbody">
						<?php if(($this->layout->isFrontpage() && !$this->API->modules('mainbody')) || !$this->layout->isFrontpage()) : ?>
						<jdoc:include type="component" />
						<?php else : ?>
						<jdoc:include type="modules" name="mainbody" style="<?php echo $this->module_styles['mainbody']; ?>" />
						<?php endif; ?>
					</section>
					
					<?php if($this->API->modules('mainbody_bottom')) : ?>
					<section id="gkMainbodyBottom">
						<jdoc:include type="modules" name="mainbody_bottom" style="<?php echo $this->module_styles['mainbody_bottom']; ?>" />
					</section>
					<?php endif; ?>
				</div>
			</section>
			
			<?php if($this->API->modules('sidebar')) : ?>
			<jdoc:include type="modules" name="sidebar" style="<?php echo $this->module_styles['sidebar']; ?>" />
			<?php endif; ?>
		</section>
	</div>
		
	<?php if($this->API->modules('bottom')) : ?>
	<section id="gkBottom" class="masonry">
		<jdoc:include type="modules" name="bottom" style="<?php echo $this->module_styles['bottom']; ?>" />
	</section>
	<?php endif; ?>
</div>

<?php $this->layout->loadBlock('footer'); ?>

<?php $this->layout->loadBlock('tools/login'); ?>
<div id="gkPopupOverlay"></div>
<?php $this->layout->loadBlock('social'); ?>

<jdoc:include type="modules" name="debug" />
</body>
</html>