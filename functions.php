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
		$excerpt_length = 50; //200 words for some reason... would prefer a char count. Not sure how to do it. 
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
?>