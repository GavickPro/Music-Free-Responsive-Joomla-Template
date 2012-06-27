$ = Zepto;
$(document).ready(function(){
	/*
		Menu code
	 */ 
	
	// stack of opened submenus
	var openedStack = [];
	// array of all submenus
	var submenus = [];
	// change all hrefs in links with submenu to #
	$('#gkNav a.haschild').each(function(i,el){
		$(el).attr('href', '#'+i);
		var submenu = $(el).parent().find('ul').first();
		submenu.css('display', 'none');
		$('#gkMenuContent').dom[0].appendChild(submenu.dom[0]);
		submenus[i] = submenu;
	});
	// prepare events
	$('#gkNav a.haschild').bind('click', function(e){
		var submenu = $(submenus[parseInt($(e.target).attr('href').replace('#', ''))]);
		openedStack.push(submenu);
		btnBack.css('display', 'inline-block');
		openedStack[openedStack.length-2].css('display', 'none');
		submenu.css('display', 'block');
	});
	// prepare buttons handlers
	var btnMenu = $('#gk-btn-menu');
	var btnSearch = $('#gk-btn-search');
	var btnSwitch = $('#gk-btn-switch');
	var btnBack = $('#gk-btn-nav-prev');
	var btnClose = $('#gk-btn-nav-close');
	// switcher desktop-mobile
	if(btnSwitch) {
		btnSwitch.bind('click', function(e){
			e.preventDefault();
			var agree = confirm($('#translation-confirm').html());
			if(agree) {
				setCookie('gkGavernMobile'+$('#translation-name').html(), 'desktop', 365);
				window.location.reload();
			}
		});
	}
	// menu button
	btnMenu.bind('click', function() {
		$('#gkMenuContent').css('display', 'block');
		$('#gkContent').css('opacity', 0.3);
		// hide / show buttons
		btnMenu.css('display', 'none');
		btnSearch.css('display', 'none');
		btnClose.css('display', 'block');
		openedStack.push($('#gkMenuContent').find('ul').first());
	});
	// menu close button
	btnClose.bind('click', function() {
		$('#gkMenuContent').css('display', 'none');
		$('#gkContent').css('opacity', 1.0);
		// hide / show buttons
		btnMenu.css('display', 'inline-block');
		btnSearch.css('display', 'inline-block');
		btnClose.css('display', 'none');
		btnBack.css('display', 'none');
		// reset menu
		$('#gkMenuContent ul').css('display', 'none');
		$('#gkMenuContent > ul').first().css('display', 'block');
		openedStack = [];
	});
	// menu back button
	btnBack.bind('click', function() {
		var toHide = openedStack.pop();
		if(openedStack.length == 1) btnBack.css('display', 'none');
		$('#gkMenuContent ul').css('display', 'none');
		openedStack[openedStack.length-1].css('display', 'block');
	});
	
	if(btnSearch) {
		var search_opened = false;
		btnSearch.bind('click', function() {
			$('#gkSearch').css('display', (search_opened) ? 'none' : 'block');
			search_opened = !search_opened; 
		});
	}
	
	/* 
		Collapsible blocks code
	 */
	 
	if($('.gkCollapsible').length > 0) {
		$('.gkCollapsible').each(function(i, el) {
			$(el).bind('click', function(){
				var toggled = $($('.gkFeaturedItem').get(i));
				if(toggled.css('display') == 'none' || toggled.css('display') == '') {
					$($('.gkFeaturedItem').get(i)).css('display', 'block');
					$($('.gkToggle').get(i)).attr('class', 'gkToggle hide');
				} else {
					$($('.gkFeaturedItem').get(i)).css('display', 'none');
					$($('.gkToggle').get(i)).attr('class', 'gkToggle show');
				}
			});
			
			$('a',el).bind('click', function(e) {
				e.preventDefault(); // disable links on toggler
			});
		});
	}
});

function setCookie(c_name, value, expire) {
	var exdate=new Date();
	exdate.setDate(exdate.getDate()+expire);
	document.cookie=c_name+ "=" +escape(value) + ((expire==null) ? "" : ";expires=" + exdate.toUTCString());
}
