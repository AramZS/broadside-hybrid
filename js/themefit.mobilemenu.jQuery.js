/***************************************************************************************

By default, themefitmobilemenu() can be called on elements such 
as #main-nav below using $("#main-nav").themefitmenu()

<div id="main-nav">
	<a id="toggle-menu">Menu<span></span></a>
	<a id="hide-menu" ></a>
	<div id="main-nav-container">
		<ul class="menu">
			<li><a href="#"><span>Button 1</span></a></li>
			<li><a href="#"><span>Button 2</span></a></li>
		</ul>
	</div>
</div>

****************************************************************************************/

(function($){
	
	// public vars
	var wrapper = ''; // menu wrapper
	var wrapperWidth = 0; // wrapper width
	var currentWrapperWidth = 0; // wrapper width as window resizes
	var mobileWidth = 300;
	var mobileClass = 'tf-mobile-menu'; // enable mobile
	var menuOpenClass = "open";
	var toggleMenuBtnDownClass = 'button-down';
	var menuIsAnimating = false;
	var toggleMenuBtn = '';
	var closeMenuBtn = '';
	var menuContainer = '';
	var toggleMenuBtnID = 'a#toggle-menu';
	var closeMenuBtnID = 'a#close-menu'; 
	var menuContainerID = 'div#main-nav-container'; 
	var duration = 500;
	var delay = 700;
	var screenPosition = 0;
	var siteWrapper = $('#site-wrapper');

	// public functions
	var methods = {
		init:function() {
			assignData (this);
			resizeMenu(this);
			addControls();
		},
		refresh:function() {
			resizeMenu(this);
		}
	};
	
	function assignData(obj){
		wrapper = obj;
		toggleMenuBtn = wrapper.find(toggleMenuBtnID);
		closeMenuBtn = wrapper.find(closeMenuBtnID);
		menuContainer = wrapper.find(menuContainerID);	
	}
	
	function resizeMenu(obj){
		// the window has been resized
		wrapper = obj;
		currentWrapperWidth = wrapper.width();
		
		// prevent unnecessary resize
		if(currentWrapperWidth != wrapperWidth && !menuIsAnimating) {
			wrapperWidth = currentWrapperWidth;

			// apply class based on device
			if(wrapperWidth <= mobileWidth) {
				wrapper.addClass(mobileClass);
				wrapper.hasClass(menuOpenClass) ? menuContainer.show() : menuContainer.hide();
			}else{
				wrapper.removeClass(mobileClass);
				menuContainer.show();
			}
		}
	}
	
	function addControls() {
		toggleMenuBtn.click(function() {
			if(!menuIsAnimating)
			{
				menuIsAnimating = true;
				if(toggleMenuBtn.hasClass(toggleMenuBtnDownClass)) {
					toggleMenuBtn.removeClass(toggleMenuBtnDownClass);
				}else{
					toggleMenuBtn.addClass(toggleMenuBtnDownClass);
				}
				
				menuContainer.slideToggle(duration, "easeInOutQuint", function(){
					menuIsAnimating = false;
				});
				wrapper.toggleClass(menuOpenClass);
			}
			return false;
		});
		
		closeMenuBtn.click(function() {
			if(!menuIsAnimating)
			{
				menuIsAnimating = true;
				if(toggleMenuBtn.hasClass(toggleMenuBtnDownClass)) {
					toggleMenuBtn.removeClass(toggleMenuBtnDownClass);
				}else{
					toggleMenuBtn.addClass(toggleMenuBtnDownClass);
				}
				
				screenPosition = siteWrapper.offset();
				$('body,html').animate({scrollTop:screenPosition.top}, 300);
				
				menuContainer.slideToggle(duration, "easeInOutQuint", function(){
					menuIsAnimating = false;
				});
				wrapper.toggleClass(menuOpenClass);
			}
			return false;
		});
	}
	
	$.fn.themefitmobilemenu = function(method) {
		if ( methods[method] ) {
		  return methods[ method ].apply( this, Array.prototype.slice.call( arguments, 1 ));
		} else if ( typeof method === 'object' || ! method ) {
		  return methods.init.apply( this, arguments );
		} else {
		  $.error( 'Method ' +  method + ' does not exist in themefitmobilemenu' );
		} 
	}
})(jQuery);  	
