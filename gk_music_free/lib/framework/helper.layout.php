<?php 

//
// Functions used in layouts
//

class GKTemplateLayout {
    //
    private $parent;
    // APIs from the parent to use in the loadBlocks functions
    public $API;
    public $cache;
    public $social;
    public $utilities;
    public $menu;
    public $mootools;
    // access to the module styles
    public $module_styles;
    //
    function __construct($parent) {
    	$this->parent = $parent;
    	$this->API = $parent->API;
    	$this->cache = $parent->cache;
    	$this->social = $parent->social;
    	$this->utilities = $parent->utilities;
    	$this->menu = $parent->menu;
    	$this->mootools = $parent->mootools;
    	$this->module_styles = $parent->module_styles;
    }
	// function to load specified block
	public function loadBlock($path) {
	    jimport('joomla.filesystem.file');
	    
	    if(JFile::exists($this->API->URLtemplatepath() . DS . 'layouts' . DS . 'blocks' . DS . $path . '.php')) { 
	        include($this->API->URLtemplatepath() . DS . 'layouts' . DS . 'blocks' . DS . $path . '.php');
	    }
	}   
	// function to generate tablet and mobile width
	public function generateLayoutWidths() {
		$body_padding = $this->API->get('layout_body_space', 20); // get the body padding
		$grid_base = $this->API->get('layout_grid_base', 320); // get the grid base width
		$content_width = $this->getContentWidthOverride(); // get the content width
		$blocks_animation = $this->API->get('blocks_animation', 1); // get the state of the blocks animation
		$mobile_width = 480;
		$min_tablet_width = $this->API->get('tablet_min_width', 720); // get the minimum tablet width
		// calculate the minimal width for the content
		$min_content_width = ($body_padding * 2) + ($grid_base * $content_width);
		//
		if($min_content_width < $min_tablet_width) {
			$min_content_width = $min_tablet_width;
		}
		// generate the data attributes
		echo ' data-tablet-width="' . $min_content_width . '" data-mobile-width="' . $mobile_width . '" data-blocks-animation="' . $blocks_animation . '" data-content-width="' . (($content_width >= 4) ? '4' : $content_width ) . '"';
	}
    // function to generate blocks paddings
    public function generateLayout($offset) {
    	$body_padding = $this->API->get('layout_body_space', 20); // get the body padding
    	$grid_base = $this->API->get('layout_grid_base', 320); // get the grid base width
    	$grid_spaces = $this->API->get('layout_grid_base_spaces', 10); // get the grid spaces
    	$content_width = $this->getContentWidthOverride(); // get the content width
    	$max_columns = $this->API->get('layout_max_amount', 4); // get the maximal amount of columns
    	$min_tablet_width = $this->API->get('tablet_min_width', 720); // get the minimum tablet width
    	// create rules
    	
    	// main container
    	$this->API->addCSSRule('#gkPageWrap { min-width: '.$grid_base.'px; max-width: '.($grid_base * $max_columns).'px; margin: 0 auto; }');
    	// body paddings
		$this->API->addCSSRule('body { padding: 0 '.$body_padding.'px; }');  	
    	// content container
    	$this->API->addCSSRule('#gkPage > #gkContent { width: '.($grid_base * $content_width).'px; padding: '.$grid_spaces.'px; }');
    	// calculate the minimal width for the content
    	$min_content_width = ($body_padding * 2) + ($grid_base * $content_width);
    	
    	if($min_content_width < $min_tablet_width) {
    		$min_content_width = $min_tablet_width;
    	}
    	
    	$tablet_width = $min_content_width;
    	$mobile_width = 480;
    	// set media query for the tablet.css
    	$this->API->addCSS($this->API->URLtemplate() . '/css/tablet.css','text/css','(max-width: '.$tablet_width.'px)');	
    	// set media query for the mobile.css
    	$this->API->addCSS($this->API->URLtemplate() . '/css/mobile.css','text/css','(max-width: '.$mobile_width.'px)');
    	
    	// CSS to add spaces between modules on the mainbody postion
    	$this->API->addCSSRule('#gkContent .box { padding: '.(2* $grid_spaces).'px 0 0 0!important; }');
    	
    	// CSS to add spaces for the page top
    	$this->API->addCSSRule('body #gkPageTop, body #gkToolbar, #gkFooter { padding-left: '.$body_padding.'px; padding-right: '.$body_padding.'px; margin-left: '.(-1 * $body_padding).'px!important; }');
		
    	// CSS to avoid problems with the K2/com_content columns on the smaller screens
    	$this->API->addCSSRule('@media screen and (max-width: '.floor(($grid_base * $content_width) * 0.8).'px) {
    	#k2Container .itemsContainer { width: 100%!important; } 
    	.cols-2 .column-1,
    	.cols-2 .column-2,
    	.cols-3 .column-1,
    	.cols-3 .column-2,
    	.cols-3 .column-3,
    	.demo-typo-col2,
    	.demo-typo-col3,
    	.demo-typo-col4 {width: 100%; }
    	}');
    	
    	// module suffixes for the right column, #gkTop and #gkBottom
    	$this->API->addCSSRule('
    		.masonry > .box.half { width: '.(0.5 * $grid_base).'px; max-width: 100%; }
    		.masonry > .box.one,
    		.masonry > .box { width: '.($grid_base).'px; max-width: 100%; }
    		.masonry > .box.double { width: '.(2 * $grid_base).'px; max-width: 100%; }
    		.masonry > .box.triple { width: '.(3 * $grid_base).'px; max-width: 100%; }
    		.masonry > .box.fourfold { width: '.(4 * $grid_base).'px; max-width: 100%; }
    		.masonry > .box.full { width: 100%; max-width: 100%; }
    		.masonry > .box { padding: '.$grid_spaces.'px }
    	');
    	// add additional rules for specific content-widths
    	$this->API->addCSSRule('
	    	body[data-content-width="1"] .masonry .box.double,
	    	body[data-content-width="1.5"] .masonry .box.double,
	    	body[data-content-width="1"] .masonry .box.triple,
	    	body[data-content-width="1.5"] .masonry .box.triple,
	    	body[data-content-width="1"] .masonry .box.fourfold,
	    	body[data-content-width="1.5"] .masonry .box.fourfold { width: '.($grid_base).'px; max-width: 100%; }
	    	body[data-content-width="2"] .masonry .box.triple,
	    	body[data-content-width="2.5"] .masonry .box.triple,
	    	body[data-content-width="2"] .masonry .box.fourfold,
	    	body[data-content-width="2.5"] .masonry .box.fourfold { width: '.(2 * $grid_base).'px; max-width: 100%; }
	    	body[data-content-width="3"] .masonry .box.fourfold,
	    	body[data-content-width="3.5"] .masonry .box.fourfold { width: '.(3 * $grid_base).'px; max-width: 100%; }
    	');
    }
    
    public function getContentWidthOverride() {
    	// get current ItemID
        $ItemID = JRequest::getInt('Itemid');
        // get current option value
        $option = JRequest::getCmd('option');
        // override array
        $content_width_override = $this->parent->config->get('content_width_override');
        // check the config
        if (isset($content_width_override[$ItemID])) {
            return $content_width_override[$ItemID];
        } else {
            return (isset($content_width_override[$option])) ? $content_width_override[$option] : $this->API->get('layout_content_width', 2);
        }   
    }
    
    // function to check if the page is frontpage
    function isFrontpage() {
        // get all known languages
        $languages	= JLanguage::getKnownLanguages();
        $menu = JSite::getMenu();
        
        foreach($languages as $lang){
            if ($menu->getActive() == $menu->getDefault( $lang['tag'] )) {
            	return true;
            }
        }
    	   
        return false;    
    }

	public function addTemplateFavicon() {
		$favicon_image = $this->API->get('favicon_image', '');
		
		if($favicon_image == '') {
			$favicon_image = $this->API->URLtemplate() . '/images/favicon.ico';
		} else {
			$favicon_image = $this->API->URLbase() . $favicon_image;
		}
		
		$this->API->addFavicon($favicon_image);
	}
	
	public function getTemplateStyle($type) {
		$template_style = $this->API->get("template_color", 1);
		
		if($this->API->get("stylearea", 1)) {
			if(isset($_COOKIE['gk_'.$this->parent->name.'_'.$type])) {
				$template_style = $_COOKIE['gk_'.$this->parent->name.'_'.$type];
			} else {
				$template_style = $this->API->get("template_color", 1);
			}
		}
		
		return $template_style;
	}
}

// EOF