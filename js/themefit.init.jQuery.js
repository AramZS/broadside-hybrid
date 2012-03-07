(function($){
	$(document).ready(function(){
		
		function isiPhone(){
			return (
				(navigator.platform.indexOf("iPhone") != -1) ||
				(navigator.platform.indexOf("iPod") != -1)
			);
		}
		
		// add these classes to all list items
		$("li:first-child").addClass("tf-first-child");
		$("li:last-child").addClass("tf-last-child");
		
		// wrap iframes, objects and embeds to for resposive behavior
		$('iframe').wrap('<div class="responsive-container" />');
		$('object').wrap('<div class="responsive-container" />');
		$('embed').wrap('<div class="responsive-container" />');
		
		var applyStylesWithJS = false;
		var mobileSafari = isiPhone();
		
		// apply css styles with javascript if ie < 9 or safari (safari media queries exclude scrollbars when calculating viewport width)
		if(($.browser.webkit && !mobileSafari && !/chrome/.test(navigator.userAgent.toLowerCase())) || $.browser.msie && parseInt($.browser.version, 10) < 9)
		{	
			
			applyStylesWithJS = true;
			
			// detect ie8 and fix bugs
			if($.browser.msie && parseInt($.browser.version, 10) == 8) {
				
				// persistent vertical scrollbar stops ie8 from entering into js resize loops
				$('html').css({'height' : '100%', 'overflow-y' : 'scroll'});
				
				themefitApplyStyles($(this).width( )); 
				
				var delayResize = null;  // resize on timer to slow ie8 jQuery triggering
				var delayTime = 50;
				
				$(window).resize(function( ) {
					if (delayResize){
						clearTimeout(delayResize);
					}
				
					delayResize = setTimeout(function( ) {
							themefitApplyStyles($(this).width( ));
							themefitRefresh( );
					}, delayTime);
				});
			// safari or ie7	
			}else{
				
				themefitApplyStyles($(this).width( ));
				
				$(window).resize(function( ) {
					themefitApplyStyles($(this).width( ));
					themefitRefresh( );
				});
			}
		// all other browsers	
		}else{
			
			$(window).resize(function( ) {
				themefitRefresh( );
			});
		}
		
		// apply styles with javascript
		function themefitApplyStyles(width) {
			width = parseInt(width);
			if (width <= 750) {
				$("#styles-751-970").attr("media", "none");
				$("#styles-0-750").attr("media", "screen");
			} else if ((width >= 751) && (width <= 970)) {
				$("#styles-751-970").attr("media", "screen");
				$("#styles-0-750").attr("media", "none");
			} else {
				$("#styles-751-970").attr("media", "none");
				$("#styles-0-750").attr("media", "none");
			}
		}
		
		// refresh all dynamicaly sized modules
		function themefitRefresh( ) {
			$("#main-nav").themefitmobilemenu('refresh');
			$('div.tf-slideshow-wrapper').themefitslideshow('refresh');
			$('.showhide').themefitshowhide('refresh');
		}
		
		// initialize all modules
		function themefitInit( ){
			$("#main-nav").themefitmobilemenu( );
			$('div.tf-slideshow-wrapper').themefitslideshow( );
			$('.showhide').themefitshowhide( );
		}
		
		// ensure resize executes after all css has been loaded
		function cssLoadPrecaution( ){
			if(applyStylesWithJS)
				themefitApplyStyles($(this).width());
			
			themefitRefresh( );
		}
		
		themefitInit( );
		
		setTimeout(function( ) { cssLoadPrecaution(); }, 2000); 
		
	});
})(jQuery);  	