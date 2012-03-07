(function( $ ){
	var mobileWidth = 300;
	var methods = {
		init : function() {
			return this.each(function(i){
				
				var wrapper = $(this); // slideshow wrapper
							
				if(wrapper.data('initialized') === undefined)
				{	
					wrapper.data('initialized', true);
					
					var hasAutoplayClass = false; // true if wrapper has autoplay class
					var autoplay = false; // tracks if slideshow is currently autoplaying
					var autoplayDelay = 5000; // default autoplay delay value (in milliseconds)
					var autoplayInterval = null; // stores object returned by setInterval
					var fakeMouseClick = false; // true if simulated mouse click event triggered in autoplay mode
					var wrapperWidth = 0; // wrapper width
					var ulList = ''; // slide list
					var listItems = []; // slides
					var listAnchors = []; // slide anchors
					var listImages = []; // slide images
					var listSize = 0; // # of slides
					var ulWidth = 0; // width of combined slides
					var toggleDistance = 0; // single increment to toggle
					var maxMarginLength = 0; // distance to last slide
					var leftMargin = 0; // property to animate ( margin-left of ulList )
					var leftArrow = ''; // left toggle arrow 
					var rightArrow = ''; // right toggle arrow
					var titleAnchor = ''; // slide title with link
					var currentListItem = 0; // keeps track of current slide. used in updating titleAnchor
					var anchorData = []; // 2D array [ title, link ]. stores data for titleAnchor
					var enabledClass = "tf-slideshow-enabled"; // enable a slideshow control
					var disabledClass = "no-hover"; // disable a slideshow control
					var slideshowData = {}; // data to be stored/carried on sideshow object
					
					// populate vars
					hasAutoplayClass = wrapper.hasClass('autoplay');
					autoplay = hasAutoplayClass;
					wrapperWidth = wrapper.width();
					ulList = wrapper.find('ul.tf-slideshow-slide-list');
					listItems = ulList.find('li.tf-slideshow-slide');
					listAnchors = ulList.find('li.tf-slideshow-slide a'); 
					listImages = ulList.find('img.tf-slideshow-image');
					listSize = listItems.length;
					ulWidth = listSize * wrapperWidth;
					toggleDistance = wrapperWidth;
					maxMarginLength = -ulWidth + toggleDistance;
					leftMargin = -(currentListItem * wrapperWidth);
					leftArrow = wrapper.find('a.tf-slideshow-left-arrow');
					rightArrow = wrapper.find('a.tf-slideshow-right-arrow');
					titleAnchor = wrapper.find('a.tf-slideshow-title');
					
					// set new autoplay delay value if it was set in the shortcode
					if(wrapper.attr("data-autoplay-delay") != undefined) {
						autoplayDelay = parseInt(wrapper.attr("data-autoplay-delay")) * 1000;
					}
					
					// hide titles if slideshow is smaller than mobile width
					if(wrapperWidth < mobileWidth) { titleAnchor.css({'display' : 'none'}) }
					
					$.each(listAnchors, function( ) {
						anchorData.push([$(this).attr("title"), $(this).attr("href")]);
					});
					
					// populate slideshow object
					slideshowData.wrapperWidth = wrapperWidth;
					slideshowData.ulList = ulList;
					slideshowData.listItems = listItems;
					slideshowData.listSize = listSize;
					slideshowData.ulWidth = ulWidth;
					slideshowData.toggleDistance = wrapperWidth;
					slideshowData.maxMarginLength = maxMarginLength;
					slideshowData.leftMargin = leftMargin;
					slideshowData.currentListItem = currentListItem;
					slideshowData.titleAnchor = titleAnchor;
					
					wrapper.data('slideshowData', slideshowData);
					
					// set defaults
					$.each(listItems, function(){
						$(this).css({'width' : wrapperWidth});
					});
					
					ulList.css({'width' : ulWidth, 'marginLeft' : leftMargin});
					
					$.each(listImages, function( ) {
						$(this).css({'visibility' : 'visible'});
					});
					
					leftArrow.removeClass(enabledClass);
					rightArrow.removeClass(disabledClass);
					
					// enable controls
					if(listSize > 1){
						
						rightArrow.addClass(enabledClass);
						rightArrow.removeClass(disabledClass);
						
						leftArrow.click(function(event){
							var slideshowObj = wrapper.data('slideshowData');
							// are we on slide 1?
							if(slideshowObj.leftMargin < 0){
								// is our next slide slide 1?
								if(slideshowObj.leftMargin == -slideshowObj.toggleDistance)
									leftArrow.removeClass(enabledClass);
									leftArrow.addClass(disabledClass);
								
								slideshowObj.leftMargin += slideshowObj.toggleDistance;
								ulList.animate({marginLeft: slideshowObj.leftMargin}, 750, "easeInOutQuart");
			
								updateAnchorData( --slideshowData.currentListItem );
							}
							
							fakeMouseClick = (event.originalEvent == undefined);
							if(autoplay && !fakeMouseClick) 
							{
								autoplay = false;
								clearInterval(autoplayInterval);
							}
							
							return false;
						});
						
						rightArrow.click(function(event) {
							var slideshowObj = wrapper.data('slideshowData');
							// are we on the last slide?
							if(slideshowObj.leftMargin <= slideshowObj.maxMarginLength){
								// reset to land on slide 1
								 slideshowObj.leftMargin = 0;
								 updateAnchorData( slideshowData.currentListItem = 0 );
								 leftArrow.removeClass(enabledClass);
								 leftArrow.addClass(disabledClass);
							}else{
								// are we off slide 1?
								if(slideshowObj.leftMargin == 0)
									leftArrow.addClass(enabledClass);
									leftArrow.removeClass(disabledClass);
				
								slideshowObj.leftMargin -= slideshowObj.toggleDistance;
								updateAnchorData( ++slideshowData.currentListItem );
							}
							ulList.animate({marginLeft: slideshowObj.leftMargin}, 750, "easeInOutQuart");
							
							fakeMouseClick = (event.originalEvent == undefined);
							if(autoplay && !fakeMouseClick) 
							{
								autoplay = false;
								clearInterval(autoplayInterval);
							}
							
							return false;
						});
						
						if(autoplay)
						{
							var clickObj = rightArrow;
							autoplayInterval = setInterval(function(){rightArrow.click();}, autoplayDelay);
						}
					}
					
					function updateAnchorData( currentSlideNum ){
						// get title and url
						title = anchorData[currentSlideNum][0];
						url = anchorData[currentSlideNum][1];
						
						// update title anchor
						titleAnchor.html(title);
						titleAnchor.attr("title", title);
						titleAnchor.attr("href", url);
					}
					
					updateAnchorData(currentListItem);
				}
			});
		},
		refresh : function() {
			return this.each(function(){
				
				var wrapper = $(this); // slideshow wrapper
				
				if(wrapper.data('initialized') !== undefined)
				{
					var slideshowObj = wrapper.data('slideshowData');
					var currentWrapperWidth = wrapper.width( );
		
					// prevent unnecessary resize
					if(currentWrapperWidth != slideshowObj.width){
						slideshowObj.width = currentWrapperWidth;
						slideshowObj.ulWidth = slideshowObj.listSize * currentWrapperWidth;
						slideshowObj.toggleDistance = currentWrapperWidth;
						slideshowObj.maxMarginLength = -slideshowObj.ulWidth + slideshowObj.toggleDistance;
						slideshowObj.leftMargin = -(slideshowObj.currentListItem * currentWrapperWidth); 
						
						// resize list items
						$.each(slideshowObj.listItems, function(){
							$(this).css({'width' : currentWrapperWidth});
						});	
						
						slideshowObj.ulList.css({'width' : slideshowObj.ulWidth, 'marginLeft' : slideshowObj.leftMargin});
						
						// show or hide title anchor
						currentWrapperWidth < mobileWidth ? slideshowObj.titleAnchor.css({'display' : 'none'}) : slideshowObj.titleAnchor.css({'display' : 'block'});
					}
				}
			});
		}
	};
	
	$.fn.themefitslideshow = function( method ) {
		if ( methods[method] ) {
		  return methods[ method ].apply( this, Array.prototype.slice.call( arguments, 1 ));
		} else if ( typeof method === 'object' || ! method ) {
		  return methods.init.apply( this, arguments );
		} else {
		  $.error( 'Method ' +  method + ' does not exist in themefitslideshow' );
		} 
	};
})( jQuery );