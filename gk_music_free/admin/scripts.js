jQuery.noConflict();

jQuery(document).ready(function() {
	
	// enable config manager
	initConfigManager();
	if(jQuery('#jform_params_top_banner0').attr('value') == 1) {          
		createTopBanner();
	}
	
	// help icons
	generateHelpIcons();
	generateFormElements();
	// load the template updates
	jQuery('a[data-parent*="#templatestyleOptions"]').click(function(){
		getUpdates();
	});	
	// get translations
	var $lang = getTranslations();
	
	// fonts forms
	jQuery('.gkfont_form').each(function(i, el) {
		el = jQuery(el);
		
		var base_id = el.find('input');
		base_id = jQuery(base_id).attr('id');
		
		var base_el = jQuery('#' + base_id);
		if(base_el.val() == '') base_el.attr('value','standard;Arial, Helvetica, sans-serif');
		var values = (base_el.val()).split(';');
		// id of selectbox are different from input id
		base_id = base_id.replace('jform_params_font_', 'jformparamsfont_');
		jQuery('#'+base_id + '_type').attr('value', values[0]);
		
		if(values[0] == 'standard') {
			jQuery('#' + base_id + '_normal').attr('value', values[1]);
			jQuery('#' + base_id + '_google_own_link').fadeOut();
			jQuery('#' + base_id + '_google_own_font').fadeOut();
			jQuery('#' + base_id + '_google_own_link_label').fadeOut();
			jQuery('#' + base_id + '_google_own_font_label').fadeOut();
			jQuery('#' + base_id + '_squirrel').fadeOut();
			jQuery('#' + base_id + '_adobe_edge_url_label').fadeOut();
		} else if(values[0] == 'google') {
			jQuery('#' + base_id + '_google_own_link').attr('value', values[2]);
			jQuery('#' + base_id + '_google_own_font').attr('value', values[3]);
			jQuery('#' + base_id + '_normal').fadeOut();
			jQuery('#' + base_id + '_squirrel').fadeOut();
			jQuery('#' + base_id + '_adobe_edge_url_label').fadeOut();
		} else if(values[0] == 'squirrel') {
			jQuery('#' + base_id + '_squirrel').attr('value', values[1]);
			jQuery('#' + base_id + '_normal').fadeOut();
			jQuery('#' + base_id + '_google_own_link').fadeOut();
			jQuery('#' + base_id + '_google_own_font').fadeOut();
			jQuery('#' + base_id + '_google_own_link_label').fadeOut();
			jQuery('#' + base_id + '_google_own_font_label').fadeOut();
			jQuery('#' + base_id + '_adobe_edge_url_label').fadeOut();
		} else if(values[0] == 'adobe') {
			jQuery('#' + base_id + '_adobe_edge_url').attr('value', values[1]);
			jQuery('#' + base_id + '_adobe_edge_url_label').fadeIn();
			jQuery('#' + base_id + '_normal').fadeOut();
			jQuery('#' + base_id + '_google_own_link').fadeOut();
			jQuery('#' + base_id + '_google_own_font').fadeOut();
			jQuery('#' + base_id + '_google_own_link_label').fadeOut();
			jQuery('#' + base_id + '_google_own_font_label').fadeOut();
			jQuery('#' + base_id + '_squirrel').fadeOut();
		}
		
		jQuery('#' + base_id + '_type').change(function() {
				var values = (base_el.val()).split(';');
				
				if(jQuery('#' + base_id + '_type').val() == 'standard') {
					jQuery('#' + base_id + '_normal').fadeIn();
					jQuery('#' + base_id + '_normal').trigger('change');
					jQuery('#' + base_id + '_google_own_link').fadeOut();
					jQuery('#' + base_id + '_google_own_font').fadeOut();
					jQuery('#' + base_id + '_google_own_link_label').fadeOut();
					jQuery('#' + base_id + '_google_own_font_label').fadeOut();
					jQuery('#' + base_id + '_squirrel').fadeOut();
					jQuery('#' + base_id + '_adobe_edge_url_label').fadeOut();
				} else if(jQuery('#' + base_id + '_type').val() == 'google') {
					jQuery('#' + base_id + '_normal').fadeOut();
					jQuery('#' + base_id + '_google_own_link').fadeIn();
					jQuery('#' + base_id + '_google_own_font').fadeIn();
					jQuery('#' + base_id + '_google_own_font').trigger('change');
					jQuery('#' + base_id + '_google_own_link_label').fadeIn();
					jQuery('#' + base_id + '_google_own_font_label').fadeIn();
					jQuery('#' + base_id + '_squirrel').fadeOut();
					jQuery('#' + base_id + '_adobe_edge_url_label').fadeOut();
				} else if(jQuery('#' + base_id + '_type').val() == 'squirrel') {
					jQuery('#' + base_id + '_normal').fadeOut();
					jQuery('#' + base_id + '_google_own_link').fadeOut();
					jQuery('#' + base_id + '_google_own_font').fadeOut();
					jQuery('#' + base_id + '_google_own_link_label').fadeOut();
					jQuery('#' + base_id + '_google_own_font_label').fadeOut();
					jQuery('#' + base_id + '_adobe_edge_url_label').fadeOut();
					jQuery('#' + base_id + '_squirrel').fadeIn();
					jQuery('#' + base_id + '_squirrel').trigger('change');
				} else if(jQuery('#' + base_id + '_type').val() == 'adobe') {
	               jQuery('#' + base_id + '_normal').fadeOut();
	               jQuery('#' + base_id + '_google_own_link').fadeOut();
	               jQuery('#' + base_id + '_google_own_font').fadeOut();
	               jQuery('#' + base_id + '_google_own_link_label').fadeOut();
	               jQuery('#' + base_id + '_google_own_font_label').fadeOut();
	               jQuery('#' + base_id + '_squirrel').fadeOut();
	               jQuery('#' + base_id + '_adobe_edge_url_label').fadeIn();
	               jQuery('#' + base_id + '_adobe_edge_url').trigger('change');
	           }
				
			});
			jQuery('#' + base_id + '_type').blur(function() {
				var values = (base_el.val()).split(';');
				
				if(jQuery('#' + base_id + '_type').val() == 'standard') {
					jQuery('#' + base_id + '_normal').fadeIn();
					jQuery('#' + base_id + '_normal').trigger('change');
					jQuery('#' + base_id + '_google_own_link').fadeOut();
					jQuery('#' + base_id + '_google_own_font').fadeOut();
					jQuery('#' + base_id + '_google_own_link_label').fadeOut();
					jQuery('#' + base_id + '_google_own_font_label').fadeOut();
					jQuery('#' + base_id + '_squirrel').css('display', 'none');
					jQuery('#' + base_id + '_adobe_edge_url_label').fadeOut();
				} else if(jQuery('#' + base_id + '_type').val() == 'google') {
					jQuery('#' + base_id + '_normal').fadeOut();
					jQuery('#' + base_id + '_google_own_link').fadeIn();
					jQuery('#' + base_id + '_google_own_font').fadeIn();
					jQuery('#' + base_id + '_google_own_font').trigger('change');
					jQuery('#' + base_id + '_google_own_link_label').fadeIn();
					jQuery('#' + base_id + '_google_own_font_label').fadeIn();
					jQuery('#' + base_id + '_squirrel').css('display', 'none');
					jQuery('#' + base_id + '_adobe_edge_url_label').fadeOut();
				} else if(jQuery('#' + base_id + '_type').val() == 'squirrel') {
					jQuery('#' + base_id + '_normal').fadeOut();
					jQuery('#' + base_id + '_google_own_link').fadeOut();
					jQuery('#' + base_id + '_google_own_font').fadeOut();
					jQuery('#' + base_id + '_google_own_link_label').fadeOut();
					jQuery('#' + base_id + '_google_own_font_label').fadeOut();
					jQuery('#' + base_id + '_adobe_edge_url_label').fadeOut();
					jQuery('#' + base_id + '_squirrel').fadeIn();
					jQuery('#' + base_id + '_squirrel').trigger('change');
					
				} else if(jQuery('#' + base_id + '_type').val() == 'adobe') {
				    jQuery('#' + base_id + '_normal').fadeOut();
				    jQuery('#' + base_id + '_google_own_link').fadeOut();
				    jQuery('#' + base_id + '_google_own_font').fadeOut();
				    jQuery('#' + base_id + '_google_own_link_label').fadeOut();
				    jQuery('#' + base_id + '_google_own_font_label').fadeOut();
				    jQuery('#' + base_id + '_squirrel').fadeOut();
					jQuery('#' + base_id + '_adobe_edge_url_label').fadeIn();
				}
		});
		
		jQuery('#' + base_id + '_normal').change(function() { 
			base_el.attr('value', jQuery('#' + base_id + '_type').val() + ';' + jQuery('#' + base_id + '_normal').val()); 
		});
		jQuery('#' + base_id + '_normal').blur(function()  { 
			base_el.attr('value', jQuery('#' + base_id + '_type').val() + ';' + jQuery('#' + base_id + '_normal').val());
		});
		
		
		jQuery('#' + base_id + '_google_own_link').keydown(function() {
			base_el.attr(
				'value',
				jQuery('#' + base_id + '_type').val() + ';' +
				'own;' +
				jQuery('#' + base_id + '_google_own_link').val() + ';' +
				jQuery('#' + base_id + '_google_own_font').val()
			);
		});
		jQuery('#' + base_id + '_google_own_link').blur(function() {
			base_el.attr(
				'value',
				jQuery('#' + base_id + '_type').val() + ';' +
				'own;' +
				jQuery('#' + base_id + '_google_own_link').val() + ';' +
				jQuery('#' + base_id + '_google_own_font').val()
			);
		});
		
		jQuery('#' + base_id + '_google_own_font').keydown(function() {
			base_el.attr(
				'value',
				jQuery('#' + base_id + '_type').val() + ';' +
				'own;' +
				jQuery('#' + base_id + '_google_own_link').val() + ';' +
				jQuery('#' + base_id + '_google_own_font').val()
			);
		});
		jQuery('#' + base_id + '_google_own_font').blur(function() {
			base_el.attr(
				'value',
				jQuery('#' + base_id + '_type').val() + ';' +
				'own;' +
				jQuery('#' + base_id + '_google_own_link').val() + ';' +
				jQuery('#' + base_id + '_google_own_font').val()
			);
		});
	
		
		jQuery('#' + base_id + '_squirrel').change(function() { 
			base_el.attr('value', jQuery('#' + base_id + '_type').val() + ';' + jQuery('#' + base_id + '_squirrel').val()); 
		});
		jQuery('#' + base_id + '_squirrel').blur(function() { base_el.attr('value', jQuery('#' + base_id + '_type').val() + ';' + jQuery('#' + base_id + '_squirrel').val());
		});
		
		
		jQuery('#' + base_id + '_adobe_edge_url').change(function() { 
			base_el.attr('value', jQuery('#' + base_id + '_type').val() + ';' + jQuery('#' + base_id + '_adobe_edge_url').val()); 
		});
		jQuery('#' + base_id + '_adobe_edge_url').blur(function()  { 
			base_el.attr('value', jQuery('#' + base_id + '_type').val() + ';' + jQuery('#' + base_id + '_adobe_edge_url').val());
		});
		
	});
	
	
	jQuery('.gkFormLine').each(function(i, el) {
		el = jQuery(el);
		el.parent().css('margin', '0');
		el.parents().eq(1).find('.control-label').css('display', 'none');
		el.parents().eq(1).css('border', 'none');
		//el.parents().eq(2).find('.control-label').css('display', 'none');
	
	});
	
	// overrides
	var elements = ['layout_override', 'tools_for_pages', 'suffix_override', 'module_override'/*, 'menu_override'*/, 'mootools_for_pages', 'content_width_for_pages'];
	jQuery.each(elements, function(i, txt) {	
		var rules = jQuery("#"+txt + '_rules');
		var textarea = jQuery("#jform_params_"+txt+"");
		
		var items = textarea.val().split( /\r\n|\r|\n/ );
		
		for(var i = 0; i < items.length; i++) {
			if(items[i] != "") {
				var item = jQuery('<div>');
				var type = items[i].split('=')[0].test(/^\d+$/) ? 'ItemID' : 'Option';
				item.html('<em>' + type + '</em> <strong>' + items[i].split('=')[0] + '</strong> - <strong>' + items[i].split('=')[1] + '</strong> <a href="#" class="' + txt + '_remove_rule">' + $lang['tpl_js_remove_rule'] + '</a>');
				item.append(rules);
			}
		}
	
		rules.click(function(e){
			e.stopPropagation();
			e.preventDefault();

			if(e.target.hasClass(txt + '_remove_rule')) {
				var parent = e.target.parent();
				var values = parent.find('strong');
				textarea.html(textarea.html().replace(values[0].html() + "=" + values[1].html() + "\n", ''));
				parent.remove();
			}
		});
	
		jQuery("#" + txt + '_add_btn').click(function(){
			var rule = jQuery("#" + txt + '_input').attr('value') + "=" + ((jQuery("#" + txt + '_select')) ? jQuery("#" + txt + '_select').attr('value') : 'enabled') + "\n";
			
			if(textarea.html().contains(rule)) {
				alert($lang['tpl_js_specified_rule_exists']);
			} else {
				textarea.append(rule);
				var item = jQuery('<div>');
				var type = jQuery("#" + txt + '_input').attr('value').test(/^\d+$/) ? 'ItemID' : 'Option';
				var value = jQuery("#" + txt + '_input').attr('value');
				var layout = jQuery("#" + txt + '_select') ? jQuery("#" + txt + '_select').attr('value') : '';
				item.html('<em>' + type + '</em> <strong>' + value + '</strong> <strong>' + layout + '</strong> <a href="#" class="' + txt + '_remove_rule">' + $lang['tpl_js_remove_rule'] + '</a>');
				item.append(rules);
			}
		});
	});
	
	// layout override
	var grules = jQuery('#google_analytics_rules');
	var gtextarea = jQuery('#jform_params_google_analytics');
	var gitems = gtextarea.val().split( /\r\n|\r|\n/ );
	
	for(var i = 0; i < gitems.length; i++) {
		if(gitems[i] != "") {
			var gitem = new jQuery('<div>');
			gitem.html('<strong>' + gitems[i] + '</strong> <a href="#" class="google_analytics_remove_rule">' + $lang['tpl_js_remove_rule'] + '</a>');
			gitem.append(grules);
		}
	}
	grules.click( function(e){
		e.stopPropagation();
		e.preventDefault();
		if(e.target.hasClass('google_analytics_remove_rule')) {
			var parent = e.target.parent();
			var values = parent.find('strong');
			gtextarea.html(gtextarea.html().replace(values.html() + "\n", ''));
			parent.remove();
		}
	});
	jQuery('#google_analytics_add_btn').click(function(){
		var rule = jQuery('#google_analytics_input').attr('value') + "\n";
		
		if(gtextarea.html().contains(rule)) {
			alert($lang['tpl_js_specified_rule_exists']);
		} else {
			gtextarea.append(rule);
			var item = jQuery('<div>');
			var value = jQuery('#google_analytics_input').attr('value');
			item.html('<strong>' + value + '</strong> <a href="#" class="google_analytics_remove_rule">' + $lang['tpl_js_remove_rule'] + '</a>');
			item.append(grules);
		}
	});
	// other form operations
	jQuery('.input-pixels').each(function(i, el){
		el = jQuery(el);
		el.parent().html("<div class=\"input-prepend\">" + el.parent().html() + "<span class=\"add-on\">px</span></div>");
	});
	
	jQuery('.input-percents').each(function(i, el){
		el = jQuery(el);
		el.parent().html("<div class=\"input-prepend\">" + el.parent().html() + "<span class=\"add-on\">%</span></div>");
	});
	jQuery('.input-ms').each(function(i, el){
		el = jQuery(el);
		el.parent().html("<div class=\"input-prepend\">" + el.parent().html() + "<span class=\"add-on\">ms</span></div>");
	});
	jQuery('#gk_template_updates').parent().css('margin-left', '10px');	
	jQuery('#config_manager_form').parent().css('margin-left', '10px');	
	jQuery('#jform_params_asset_js-lbl').parents().eq(1).css('display', 'none');
	jQuery('#jform_params_asset_css-lbl').parents().eq(1).css('display', 'none');
	jQuery('#jform_params_js_translations-lbl').parents().eq(1).css('display', 'none');
	
	// function to generate the help icons
	function generateHelpIcons() {
		
		var urls = [
			'https://wiki.gavick.com/joomla-templates/templates-for-joomla-1-6/gavern-framework/gavern-framework-page-layout-part-1/',
			'https://wiki.gavick.com/joomla-templates/templates-for-joomla-1-6/gavern-framework/gavern-framework-page-layout-part-2/',
			'https://wiki.gavick.com/joomla-templates/templates-for-joomla-1-6/gavern-framework/gavern-framework-fonts/',
			'https://wiki.gavick.com/joomla-templates/templates-for-joomla-1-6/gavern-framework/gavern-framework-features/',
			'https://wiki.gavick.com/joomla-templates/templates-for-joomla-1-6/gavern-framework/gavern-framework-menu/',			
			'https://wiki.gavick.com/joomla-templates/templates-for-joomla-1-6/gavern-framework/gavern-framework-social-api/',
			'https://www.gavick.com/documentation/joomla-templates/templates-for-joomla-1-6/cookie-law/',
			'https://wiki.gavick.com/joomla-templates/templates-for-joomla-1-6/gavern-framework/gavern-framework-advanced-settings/',
			'https://www.gavick.com/support/updates.html'
		]
		
		jQuery('div.accordion-group').each(function(i, el) {
			if(i > urls.length) { return true; }
			var link = jQuery('<a>', { 
				class : 'gkHelpLink', 
				href : urls[i-1], 
				target : '_blank' 
			});
			el = jQuery(el);
			el.find('div.accordion-heading strong').append(link);
			link.click(function(e) { e.stopPropagation();});
		
		});
	}
	
	if(jQuery('#jform_params_tools').val() != 'selected' && jQuery('#jform_params_tools').val() != 'selected_disabled') jQuery('#jform_params_tools_for_pages-lbl').parent().css('display','none');
	
	  jQuery('#jform_params_tools').change(function(){
		if(jQuery('#jform_params_tools').val() == 'selected' || jQuery('#jform_params_tools').val() == 'selected_disabled') jQuery('#jform_params_tools_for_pages-lbl').parents().eq(1).fadeIn();
		else jQuery('#jform_params_tools_for_pages-lbl').parents().eq(1).fadeOut();
	  });
	
	
	
	// function to generate the updates list
	function getUpdates() {
		jQuery('#jform_params_template_updates-lbl').remove(); // remove unnecesary label
		var update_url = 'https://www.gavick.com/updates/json/tmpl,component/query,product/product,gk_music_free_j30';
		var update_div = jQuery('#gk_template_updates');
		update_div.html('<div id="gk_update_div"><span id="gk_loader"></span>Loading update data from GavicPro Update service...</div>');
		
		jQuery.getScript(update_url, function(data, textStatus, jqxhr) {
		   	
		   	var content = '';
		   	var templateVersion = jQuery('#gk_template_updates').attr("data-gktplversion").split('.');
		   	templateVersion = templateVersion.map(function(version, i) { return version.toInt(); });
			jQuery.map(templateVersion, function(version, i) { return parseInt(version); }); 	
				
			jQuery($GK_UPDATE).each(function(i, el){
									
		   		var updateVersion = el.version.split('.');
   		        updateVersion = updateVersion.map(function(version, i) { return version.toInt(); });
   		        var isNewer = false;
   				
   		        if(updateVersion[0] > templateVersion[0]) {
   		            isNewer = true;
   		        } else if((updateVersion[0] >= templateVersion[0]) && (updateVersion[1] > templateVersion[1])) {
   		            isNewer = true;
   		        } else if(updateVersion.length > 2) {
   		            if(templateVersion.length > 2) {
   		                if(updateVersion[0] >= templateVersion[0] && updateVersion[1] >= templateVersion[1] && updateVersion[2] > templateVersion[2]) {
   		                    	isNewer = true;
   		                }
   		            } else {
   		                     if(updateVersion[1] >= templateVersion[1]) {
   		                		isNewer = true;
   		                     }
   		            }
   		        }
   		        //
   		        if(isNewer) {
   		                content += '<li><span class="gk_update_version"><strong>Version:</strong> ' + el.version + ' </span><span class="gk_update_data"><strong>Date:</strong> ' + el.date + ' </span><span class="gk_update_link"><a href="' + el.link + '" target="_blank">Download</a></span></li>';
   		                }
   		           });
   		           update_div.html('<ul class="gk_updates">' + content + '</ul>');
   		           if(update_div.html() == '<ul class="gk_updates"></ul>') {
   		        		update_div.html('<p>Your template is up to date</p>'); 
   		    		}
   		  });	
	}
	
	function getTranslations() {
		var translations = [];
		
		jQuery('#template_options_translations span').each(function(i,el){
			el = jQuery(el);
			translations[el.attr('id')] = el.html();
		});
		
		return translations;
	}
	
	function generateFormElements() {
		// remove next label
		var buf = null;
		jQuery('.next-remove').each(function(i, el) {
			if(i % 2 == 0) {
				el.parent().find('label').remove();
				buf = el.parent().hmtl();
				el.parent().remove();
			} else {
				el.parent().append(buf);
			}
		});
		// create suffix labels
		jQuery('.suffix-px').each(function(i, el) {
			var suff = jQuery('<span>', {'class' : 'gkFormSuffixPx', 'html' : 'px'});
			el.append(suff);
		});
		jQuery('.suffix-percents').each(function(i, el) {
			var suff = jQuery('span', {'class' : 'gkFormSuffixPercents', 'html' : '%'});
			el.append(suff);
		});
		jQuery('.suffix-pxorpercents').each(function(i, el) {
			var suff = jQuery('span', {'class' : 'gkFormSuffixPxOrPercents', 'html' : ''});
			el.append(suff);
		});
	}
	
	
	// init config manager
	function initConfigManager() {
		var loadbtn = jQuery('#config_manager_load');
		var savebtn = jQuery('#config_manager_save');
		var deletebtn = jQuery('#config_manager_delete');
			
		loadbtn.click(function(e) {
			e.stopPropagation();
			e.preventDefault();
			loadSaveOperation('load');
		});
		savebtn.click(function(e) {
			e.stopPropagation();
			e.preventDefault();
			loadSaveOperation('save');
		});
		deletebtn.click(function(e) {
			e.stopPropagation();
			e.preventDefault();
			loadSaveOperation('delete');
		});
	}
	// function to load/save settings
	function loadSaveOperation(type) {
		var current_url = window.location;
		if((current_url + '').indexOf('#', 0) === -1) {
			current_url = current_url + '&gk_template_task='+type+'&gk_template_file=' + jQuery('#config_manager_'+type+'_filename').val();
		} else {
			current_url = current_url.substr(0, (current_url + '').indexOf('#', 0) - 1);
			current_url = current_url + '&gk_template_task='+type+'&gk_template_file=' + jQuery('config_manager_'+type+'_filename').val();
		}
		window.location = current_url;
	}
	
	function createTopBanner() {     
		
		jQuery('#config_manager_form').before('<div id="gkTopBanner"><h3><a href="https://github.com/GavickPro/Music-Free-Responsive-Joomla-Template/issues?state=open">We are waiting for your feedback!</a></h3><p><a href="https://github.com/GavickPro/Music-Free-Responsive-Joomla-Template/">Music Free on github</a><a href="https://github.com/GavickPro/Music-Free-Responsive-Joomla-Template/commits/master">Latest commits</a></p></div>');
	}
	
	
	
});


