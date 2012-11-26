jQuery(document).ready(function() {


	if(jQuery('#gkExtraMenu')) {
	        // fix for the iOS devices     
	        jQuery('#gkExtraMenu ul li span').each(function(el) {
	            el.attr('onmouseover', '');
	        });
	
	        jQuery('#gkExtraMenu ul li a').each(function(el) {
	            el = jQuery(el);
	            el.attr('onmouseover', '');
	
	            if(el.parent().hasClass('haschild') && jQuery(document.body).attr('data-tablet') != null) {
	                el.click(function(e) {
	                    if(el.attr("dblclick") == undefined) {
	                        e.preventDefault();
	                        e.stopPropagation();
	                        el.attr("dblclick", new Date().getTime());
	                    } else {
	                        var now = new Date().getTime();
	                        if(now - attr("dblclick", 0) < 500) {
	                            window.location = el.attr('href');
	                        } else {
	                           e.preventDefault();
	                           e.stopPropagation();
	                           el.attr("dblclick", new Date().getTime());
	                        }
	                    }
	                });
	            }
	        });
	
	        var base = jQuery('#gkExtraMenu');

	        if($GKMenu && ($GKMenu.height || $GKMenu.width)) {    
	      	  	 
	            base.find('li.haschild').each(function(i, el){   
	            	el = jQuery(el);  
	               
	                if(el.children('.childcontent').length > 0) {
	                    var content = el.children('.childcontent').first();
	                    var prevh = content.height();
	                    var prevw = content.width();
						var duration = $GKMenu.duration;
						var heightAnim = $GKMenu.height;
						var widthAnim = $GKMenu.width;
						

	                    var fxStart = { 
							'height' : heightAnim ? 0 : prevh, 
							'width' : widthAnim ? 0 : prevw, 
							'opacity' : 0 
						};
						var fxEnd = { 
							'height' : prevh, 
							'width' : prevw, 
							'opacity' : 1 
						};	
						
						
	                    content.css(fxStart);
	                    content.css({'left' : 'auto', 'overflow' : 'hidden' });
												
	                    el.mouseenter(function(){
                    			                    
                            var content = el.children('.childcontent').first();
                            content.css('display', 'block');
							
							if(content.attr('data-base-margin') != null) {
								content.css({
									'margin-left': content.attr('data-base-margin') + "px"
								});
							}
								
							var pos = content.offset();
							var winWidth = jQuery(window).outerWidth();
							var winScroll = jQuery(window).scrollLeft();
								
							if(pos.left + prevw > (winWidth + winScroll)) {
								var diff = (winWidth + winScroll) - (pos.left + prevw) - 5;
								var base = parseInt(content.css('margin-left'));
								var margin = base + diff;
								
								if(base > 0) {
									margin = -prevw + 10;	
								}
								content.css('margin-left', margin + "px");
								
								if(content.attr('data-base-margin') == null) {
									content.attr('data-base-margin', base);
								}
							}
							//
							content.animate(
								fxEnd, 
								duration, 
								function() { 
									if(content.outerHeight() == 0){ 
										content.css('overflow', 'hidden'); 
									} else if(
										content.outerHeight() - prevh < 30 && 
										content.outerHeight() - prevh >= 0
									) {
										content.css('overflow', 'visible');
									}
								}
							);
						});
					el.mouseleave(function(){
					
							content.css({
								'overflow': 'hidden'
							});
							//
							content.animate(
								fxStart, 
								duration, 
								function() { 
									if(content.outerHeight() == 0){ 
										content.css('overflow', 'hidden'); 
									} else if(
										content.outerHeight() - prevh < 30 && 
										content.outerHeight() - prevh >= 0
									) {
										content.css('overflow', 'visible');
									}
									
									content.css('display', 'none');
								}
							);
						});
					}
				});
	            
	            base.find('li.haschild').each(function(i, el) {
	            						el = jQuery(el);
	            						content = jQuery(el.children('.childcontent').first());
	            						content.css({ 'display': 'none' });
	            					});
	            
	        }
	    }
	


});