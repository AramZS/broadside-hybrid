
/***************************************************************************************

By default, themefitshowhide() can be called on elements such 
as #main-nav below using $(".showhide").themefitshowhide()

<div class="showhide">

	<div class="persistent-content">
		<!-- content always remains visible -->
	</div>
	
	<a id="toggle-button"></a>
	
	<!-- force ie8 to toogle smoothly -->
    <p class="ie8-toggle-fix">&nbsp;</p>
	
	<div class="toggle-content">
		<!-- content to be shown or hidden, toggled -->
	</div>
	
</div>

****************************************************************************************/

(function( $ ){
	
	var duration = 300;
	var mobileWidth = 300;			
	var methods = {
		init : function() {
			return this.each(function(i){
				
				var wrapper = $(this); // show/hide container div
				
				if(wrapper.data('initialized') === undefined)
				{	
					wrapper.data('initialized', true);
					
					var toggleBtn = wrapper.find('a.toggle-button');
					var showHideData = { }
					showHideData.width = wrapper.width( );
					showHideData.open = false;
					showHideData.divToToggle = wrapper.find('div.toggle-content');
					showHideData.isAnimating = false;
					
					wrapper.data('showHideData', showHideData)
						
					if(showHideData.width <= mobileWidth) {
						showHideData.divToToggle.css('height', '0');
						showHideData.divToToggle.css('display', 'none');
					}else{
						showHideData.divToToggle.css('display', 'block');
						showHideData.divToToggle.css('height', 'auto');
					}
					
					toggleBtn.click(function( ){
						var showHideObj = wrapper.data('showHideData');
						
						if(!showHideObj.isAnimating){
							showHideObj.isAnimating = true;
							if(showHideObj.open ){
								$(this).removeClass('open');
								showHideObj.divToToggle.css({'height' : '0'});
								showHideObj.divToToggle.css({'display' : 'none'});
							}else{
								$(this).addClass('open');
								showHideObj.divToToggle.css({'display' : 'block'});
								showHideObj.divToToggle.css({'height' : 'auto'});
							}
							showHideObj.open = !showHideObj.open;
							showHideObj.isAnimating = false;
						}
						
						return false;
					});
				}
			});
		},
		refresh : function() {
			return this.each(function(){
				
				var wrapper = $(this); // show / hide div
				
				if(wrapper.data('initialized') !== undefined)
				{
					var showHideObj = wrapper.data('showHideData');
					var currentWrapperWidth = wrapper.width( );

					// prevent unnecessary resize
					if(currentWrapperWidth != showHideObj.width){
						showHideObj.width = currentWrapperWidth;
						
						if(currentWrapperWidth <= mobileWidth) {
							 showHideObj.open ?  showHideObj.divToToggle.css('display', 'block') : showHideObj.divToToggle.css('display', 'none');
							 showHideObj.open ?  showHideObj.divToToggle.css('height', 'auto') : showHideObj.divToToggle.css('height', '0');
						}else{
							showHideObj.divToToggle.css({'display' : 'block'});
							showHideObj.divToToggle.css({'height' : 'auto'});
						}
					}
				}
			});
		}
	};
	
	$.fn.themefitshowhide = function( method ) {
		if ( methods[method] ) {
		  return methods[ method ].apply( this, Array.prototype.slice.call( arguments, 1 ));
		} else if ( typeof method === 'object' || ! method ) {
		  return methods.init.apply( this, arguments );
		} else {
		  $.error( 'Method ' +  method + ' does not exist in themefitshowhide' );
		} 
	};
})( jQuery );