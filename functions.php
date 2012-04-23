<?php

include ('options/options.php');



function zs_killer_excerpt( $text ) {
	global $post;
	if ( '' == $text ) {
		$text = get_the_content('');
		$text = apply_filters('the_content', $text);
		$text = str_replace('\]\]\>', ']]&gt;', $text);
		$text = preg_replace('@<script[^>]*?>.*?</script>@si', '', $text);
		$text = strip_tags($text, '<p> <strong> <bold> <i> <em> <emphasis> <del> <h1> <h2> <h3> <h4> <h5> <img>');
		$excerpt_length = 50; //words for some reason... would prefer a char count. Not sure how to do it. 
		$words = explode(' ', $text, $excerpt_length + 1);
		if (count($words)> $excerpt_length) {
		  array_pop($words);
		  array_push($words, '...');
		  $text = implode(' ', $words);
		}
	}
return $text;
}

remove_filter('get_the_excerpt', 'wp_trim_excerpt');
add_filter('get_the_excerpt', 'zs_killer_excerpt');

if ( function_exists( 'add_theme_support' ) ) {
	add_theme_support( 'post-thumbnails' );
    set_post_thumbnail_size( 200, 200 ); // default Post Thumbnail dimensions   
}
if ( function_exists( 'add_image_size' ) ) { 
	add_image_size( 'main-thumb', 458, 310, true ); //(hard cropped)}
}

//Adds some nifty stuff to your userprofile so I can call it later.
function my_new_profilemethods( $profilemethods ) {
    //Add user title
	$contactmethods['authortitle'] = 'The position title of the user.';
	// Add Twitter
    $contactmethods['twitter'] = 'Twitter name without the "@"';
    //add Facebook
    $contactmethods['facebookURL'] = 'Facebook profile URL'; 
	//Add Google Plus. 
	$contactmethods['gplusURL'] = 'Google Profile URL for authorid. Should look like https://plus.google.com/108109243710611392513/posts'; 
    return $contactmethods;
}
add_filter('user_contactmethods','my_new_profilemethods',10,1);

function bh_widgets_init() {

	if ( function_exists('register_sidebar') )
	register_sidebar( array(
		'name' => __( 'Lower Left Sidebar', 'broadside-hybrid' ),
		'id' => 'lower-left-sidebar',
		'description' => __( 'The lower-left sidebar area, below the category titles.', 'broadside-hybrid' ),
		'before_widget' => '<div class="lower-left-widget">',
		'after_widget' => '</div>',
		'before_title' => '<h5>',
		'after_title' => '</h5>',
	) );	

}

add_action( 'widgets_init', 'bh_widgets_init' );	

function activate_slider() {

		echo '<script type="text/javascript" src="' . get_bloginfo('stylesheet_directory') . '/inc/jquery.cycle.all.js"></script>';
	?>
	<script type="text/javascript">
			$(document).ready(function () {
				$('.featured-box').after('<ul id="slide-nav"></ul>').cycle({
					fx: 'fade',
					autostop: false,
					delay: 2000,
					timeout: 7000,
					pause: true,
					pager: '#slide-nav',
					pagerAnchorBuilder: function(index) { 
							return '<li><a href="#"><img src="<?php echo get_bloginfo('stylesheet_directory'); ?>/images/slider/navdot-empty.png" width="28" height="28" /></a></li>'; 
						} 
					
				});
			});
	</script>
	<?php
}

add_action ('wp_head', 'activate_slider');

//I've put this in the header to avoid the weird 'oh a button just appeared' effect you get when you place it in the footer. 

function zs_enable_gplus() {

	?>
		<script type="text/javascript">
		  (function() {
			var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
			po.src = 'https://apis.google.com/js/plusone.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
		  })();
		</script>
	<?php

}

add_action ('wp_head', 'zs_enable_gplus');

function zs_enable_su() {

	?>
	 <script type="text/javascript"> 
	 (function() { 
		 var li = document.createElement('script'); li.type = 'text/javascript'; li.async = true; 
		 li.src = window.location.protocol + '//platform.stumbleupon.com/1/widgets.js'; 
		 var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(li, s); 
	 })(); 
	 </script>
	<?php
}

add_action ('wp_head', 'zs_enable_su');


function zs_enable_fb() {

	?>
		
		<script>(function(d, s, id) {
		  var js, fjs = d.getElementsByTagName(s)[0];
		  if (d.getElementById(id)) return;
		  js = d.createElement(s); js.id = id;
		  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
		  fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));</script>
	<?php
}

add_action ('wp_head', 'zs_enable_fb');

function add_photo_credit_option( $form_fields, $post ) {  
	
	$form_fields['photocredit'] = array(  
		'label' => '<span style="color:#ff0000; margin:0; padding:0;">'.__('Photo Credit', 'broadside-hybrid').'</span> <br />'.__('Add Photographer Name / Photo Type to image', 'broadside-hybrid'),
		'input' => 'text',
		'value' => get_post_meta($post->ID, '_photocredit', true)  
	);
	  
	return $form_fields;
}  

add_filter('attachment_fields_to_edit', 'add_photo_credit_option', null, 2);

// save custom option for images in media library

function save_photo_credit_option($post, $attachment) {
	if( isset($attachment['photocredit']) ){
		update_post_meta($post['ID'], '_photocredit', $attachment['photocredit']);  
	} 
		
	return $post;  
}

add_filter('attachment_fields_to_save', 'save_photo_credit_option', 10, 2);

function get_the_excerpt_here($post_id)
{
  global $wpdb;
  $query = "SELECT post_excerpt FROM $wpdb->posts WHERE ID = $post_id LIMIT 1";
  $result = $wpdb->get_results($query, ARRAY_A);
  return $result[0]['post_excerpt'];
}

?>