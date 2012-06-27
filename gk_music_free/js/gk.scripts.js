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
	// smooth anchor scrolling
	new SmoothScroll({ wheelStops: false, duration: 125 }); 
	// style area
	if(document.id('gkStyleArea')){
		$$('#gkStyleArea a').each(function(element,index){
			element.addEvent('click',function(e){
	            e.stop();
				changeStyle(index+1);
			});
		});
	}
	// font-size switcher
	if(document.id('gkTools') && document.id('gkMainbody')) {
		var current_fs = 100;
		var content_fx = new Fx.Tween(document.id('gkMainbody'), { property: 'font-size', unit: '%', duration: 200 }).set(100);
		document.id('gkToolsInc').addEvent('click', function(e){ 
			e.stop(); 
			if(current_fs < 150) { 
				content_fx.start(current_fs + 10); 
				current_fs += 10; 
			} 
		});
		document.id('gkToolsReset').addEvent('click', function(e){ 
			e.stop(); 
			content_fx.start(100); 
			current_fs = 100; 
		});
		document.id('gkToolsDec').addEvent('click', function(e){ 
			e.stop(); 
			if(current_fs > 70) { 
				content_fx.start(current_fs - 10); 
				current_fs -= 10; 
			} 
		});
	}
	// K2 font-size switcher fix
	if(document.id('fontIncrease') && document.getElement('.itemIntroText')) {
		document.id('fontIncrease').addEvent('click', function() {
			document.getElement('.itemIntroText').set('class', 'itemIntroText largerFontSize');
		});
		
		document.id('fontDecrease').addEvent('click', function() {
			document.getElement('.itemIntroText').set('class', 'itemIntroText smallerFontSize');
		});
	}
	// Tablet menu button
	if(document.id('gkTabletMenu') && document.id('gkInset')) {
		document.id('gkTabletMenu').addEvent('click', function() {
			document.id('gkInset').toggleClass('visible');
		});
	}
	// login popup
	if(document.id('gkPopupLogin')) {
		var popup_overlay = document.id('gkPopupOverlay');
		popup_overlay.setStyles({'display': 'block', 'opacity': '0'});
		popup_overlay.fade('out');

		var opened_popup = null;
		var popup_login = null;
		var popup_login_h = null;
		var popup_login_fx = null;
		
		if(document.id('gkPopupLogin') && document.id('btnLogin')) {
			popup_login = document.id('gkPopupLogin');
			popup_login.setStyle('display', 'block');
			popup_login_h = popup_login.getElement('.gkPopupWrap').getSize().y;
			popup_login_fx = new Fx.Morph(popup_login, {duration:200, transition: Fx.Transitions.Circ.easeInOut}).set({'opacity': 0, 'height': 0 }); 
			document.id('btnLogin').addEvent('click', function(e) {
				new Event(e).stop();
				popup_overlay.fade(0.45);
				popup_login_fx.start({'opacity':1, 'height': popup_login_h});
				opened_popup = 'login';
				
				(function() {
					if(document.id('modlgn-username')) {
						document.id('modlgn-username').focus();
					}
				}).delay(600);
			});
		}
		
		popup_overlay.addEvent('click', function() {
			if(opened_popup == 'login')	{
				popup_overlay.fade('out');
				popup_login_fx.start({
					'opacity' : 0,
					'height' : 0
				});
			}
		});
	}
	// toolbar action
	if(document.id('gkToolbar').getElement('ul')) {
		var el = document.id('gkToolbar').getElement('ul');
		el.addEvent('click', function() {
			if(el.hasClass('hover')) {
				el.removeClass('hover');
			} else {
				el.addClass('hover');
			}
		});
	}
	// footer menu
	if(document.id('gkFooter').getElement('ul.menu')) {
		var menu_items = document.id('gkFooter').getElements('ul.menu a');
		var selectInner = '';
		//
		for(var i = 0; i < menu_items.length; i++) {
			selectInner += '<option value="' + menu_items[i].getProperty('href') + '">' + menu_items[i].innerHTML + "</option>";
		}
		//
		var footerSelect = new Element('select', {
			'id': 'gkFooterMenu',
			'html': selectInner
		});
		//
		footerSelect.addEvent('change', function(e) {
			window.location = e.target.value;
		});
		//
		footerSelect.inject(document.id('gkFooter').getElement('ul.menu'), 'after');	
	}
});
// initial animation
window.addEvent('load', function() {
	var boxes = [];
	
	document.id('gkPage').getElements('.box').each(function(box, i){		
		if(i > 0 && box.getParent().getAttribute('id') == 'gkPage') {
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
							box.addClass('loaded');
						}).delay(i * 100);
					}
				});
			}).delay(600);
		}
	}
});
// function to set cookie
function setCookie(c_name, value, expire) {
	var exdate=new Date();
	exdate.setDate(exdate.getDate()+expire);
	document.cookie=c_name+ "=" +escape(value) + ((expire==null) ? "" : ";expires=" + exdate.toUTCString());
}
// Function to change styles
function changeStyle(style){
	var file1 = $GK_TMPL_URL+'/css/style'+style+'.css';
	var file2 = $GK_TMPL_URL+'/css/typography/typography.style'+style+'.css';
	var file3 = $GK_TMPL_URL+'/css/typography/typography.iconset.style'+style+'.css';
	new Asset.css(file1);
	new Asset.css(file2);
	new Asset.css(file3);
	Cookie.write('gk_music_free_j25_style', style, { duration:365, path: '/' });
}