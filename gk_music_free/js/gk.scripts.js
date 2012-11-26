/**
 * jQuery Cookie plugin
 *
 * Copyright (c) 2010 Klaus Hartl (stilbuero.de)
 * Dual licensed under the MIT and GPL licenses:
 * http://www.opensource.org/licenses/mit-license.php
 * http://www.gnu.org/licenses/gpl.html
 *
 */
jQuery.noConflict();
jQuery.cookie = function (key, value, options) {

    // key and at least value given, set cookie...
    if (arguments.length > 1 && String(value) !== "[object Object]") {
        options = jQuery.extend({}, options);

        if (value === null || value === undefined) {
            options.expires = -1;
        }

        if (typeof options.expires === 'number') {
            var days = options.expires, t = options.expires = new Date();
            t.setDate(t.getDate() + days);
        }

        value = String(value);

        return (document.cookie = [
            encodeURIComponent(key), '=',
            options.raw ? value : encodeURIComponent(value),
            options.expires ? '; expires=' + options.expires.toUTCString() : '', // use expires attribute, max-age is not supported by IE
            options.path ? '; path=' + options.path : '',
            options.domain ? '; domain=' + options.domain : '',
            options.secure ? '; secure' : ''
        ].join(''));
    }

    // key and possibly options given, get cookie...
    options = value || {};
    var result, decode = options.raw ? function (s) { return s; } : decodeURIComponent;
    return (result = new RegExp('(?:^|; )' + encodeURIComponent(key) + '=([^;]*)').exec(document.cookie)) ? decode(result[1]) : null;
};


window.addEvent('domready', function(){
	// add loader
	if(document.id('gkPage').getChildren('.box').length > 2) {
		var content = document.id('gkPage').getChildren('.box')[0];
		var base = document.id('gkPage').getChildren('.box')[1];
		var width = document.id('gkPage').getSize().x - content.getSize().x;
		
		if(width < base.getSize().x) {
			// full width
			var loader = new Element('div', {
				'html': '<div>'+document.body.getProperty('data-loading-translation')+'</div>',
				'class': 'box gkSidebarPreloader gkPreloaderFullWidth'
			});
			loader.inject(content, 'after');
		} else {
			// other width
			var loader = new Element('div', {
				'html': '<div>'+$(document.body).getProperty('data-loading-translation')+'</div>',
				'class': 'box gkSidebarPreloader'
			});
			
			loader.inject(content, 'after');
		}
	}
	
	// style area
	if(jQuery('#gkStyleArea')){
		jQuery('#gkStyleArea').find('a').each(function(i, element){
			jQuery(element).click(function(e){
	            e.preventDefault();
	            e.stopPropagation();
				changeStyle(i+1);
			});
		});
	}
	
	// font-size switcher
	if(jQuery('#gkTools') && jQuery('#gkMainbody')) {
		var current_fs = 100;
		
		jQuery('#gkMainbody').css('font-size', current_fs+"%");
		
		jQuery('#gkToolsInc').click(function(e){ 
			e.stopPropagation();
			e.preventDefault(); 
			if(current_fs < 150) {  
				jQuery('#gkMainbody').animate({ 'font-size': (current_fs + 10) + "%"}, 200); 
				current_fs += 10; 
			} 
		});
		jQuery('#gkToolsReset').click(function(e){ 
			e.stopPropagation();
			e.preventDefault(); 
			jQuery('#gkMainbody').animate({ 'font-size' : "100%"}, 200); 
			current_fs = 100; 
		});
		jQuery('#gkToolsDec').click(function(e){ 
			e.stopPropagation();
			e.preventDefault(); 
			if(current_fs > 70) { 
				jQuery('#gkMainbody').animate({ 'font-size': (current_fs - 10) + "%"}, 200); 
				current_fs -= 10; 
			} 
		});
	}
	
	// K2 font-size switcher fix
	if(jQuery('#fontIncrease') && jQuery('.itemIntroText')) {
		jQuery('#fontIncrease').click(function() {
			jQuery('.itemIntroText').attr('class', 'itemIntroText largerFontSize');
		});
		
		jQuery('#fontDecrease').click( function() {
			jQuery('.itemIntroText').attr('class', 'itemIntroText smallerFontSize');
		});
	}
	// Tablet menu button
	if(jQuery('#gkTabletMenu') && jQuery('#gkInset')) {
		jQuery('#gkTabletMenu').click( function() {
			jQuery('#gkInset').toggleClass('visible');
		});
	}
	
	// login popup
	if(jQuery('#gkPopupLogin')) {
		var popup_overlay = jQuery('#gkPopupOverlay');
		popup_overlay.css({'display': 'block'});
		popup_overlay.fadeOut();
		
		jQuery('#gkPopupLogin').css({'display': 'block', 'opacity': 0, 'height' : 0});
		var opened_popup = null;
		var popup_login = null;
		var popup_login_h = null;
		var popup_login_fx = null;
		
		if(jQuery('#gkPopupLogin') && jQuery('#btnLogin')) {
			popup_login = jQuery('#gkPopupLogin');
			popup_login.css('display', 'block');
			popup_login_h = popup_login.find('.gkPopupWrap').outerHeight();
			 
			jQuery('#btnLogin').click( function(e) {
				e.preventDefault();
				e.stopPropagation();
				popup_overlay.fadeIn('slow');
				popup_login.css({'opacity':1, 'height': popup_login_h});
				opened_popup = 'login';
				
				(function() {
					if(jQuery('#modlgn-username')) {
						jQuery('#modlgn-username').focus();
					}
				}).delay(600);
			});
		}
		
		popup_overlay.click( function() {
			if(opened_popup == 'login')	{
				popup_overlay.fadeOut('slow');
				popup_login.css({
					'opacity' : 0,
					'height' : 0
				});
			}
		});
	}
	
	// toolbar action
	if(jQuery('#gkToolbar') && jQuery('#gkToolbar').find('ul')) {
		var el = jQuery('#gkToolbar').find('ul');
		el = jQuery(el);
		el.click(function() {
			if(el.hasClass('hover')) {
				el.removeClass('hover');
			} else {
				el.addClass('hover');
			}
		});
	}
	// footer menu
	if(jQuery('#gkFooter').find('ul.menu')) {
		var menu_items = jQuery('#gkFooter').find('ul.menu a');
		var selectInner = '';
		//
		for(var i = 0; i < menu_items.length; i++) {
			selectInner += '<option value="' + jQuery(menu_items[i]).attr('href') + '">' + jQuery(menu_items[i]).html() + "</option>";
		}
		//
		
		jQuery('#gkFooter').find('ul.menu').after('<select id="gkFooterMenu">'+selectInner+'</select>');		
		
		jQuery('#gkFooterMenu').change(function(e) {
			window.location = e.target.value;
		});
	}
});
// initial animation
window.addEvent('load', function() {
	var boxes = [];
	
	jQuery('#gkPage').find('.box').each(function(i, box){		
		if(i > 0 && box.parentNode.id == 'gkPage') {
			boxes.push(box);
		}
	});
	
	if(boxes.length > 0) {
		boxes[0].addClass('loaded');
		
		if(boxes[0].hasClass('gkSidebarPreloader')) {
			(function() {
				boxes[0].destroy();
				boxes[0] = false;
			}).delay(500);
			
			(function() {
				boxes.each(function(box, i) {
					if(box) {
						(function() {
							box = jQuery(box);
							box.addClass('loaded');
						}).delay(i * 100);
					}
				});
			}).delay(600);
		}
	}
});

// Function to change styles
function changeStyle(style){
	var file1 = $GK_TMPL_URL+'/css/style'+style+'.css';
	var file2 = $GK_TMPL_URL+'/css/typography/typography.style'+style+'.css';
	var file3 = $GK_TMPL_URL+'/css/typography/typography.iconset.style'+style+'.css';
	jQuery('head').append('<link rel="stylesheet" href="'+file1+'" type="text/css" />');
	jQuery('head').append('<link rel="stylesheet" href="'+file2+'" type="text/css" />');
	jQuery('head').append('<link rel="stylesheet" href="'+file3+'" type="text/css" />');
	jQuery.cookie('gk_music_free_j30_style', style, { expires: 365, path: '/' });
}