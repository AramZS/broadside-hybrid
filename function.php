<?php

function zs_killer_excerpt( $text ) {
	global $post;
	if ( '' == $text ) {
		$text = get_the_content('');
		$text = apply_filters('the_content', $text);
		$text = str_replace('\]\]\>', ']]&gt;', $text);
		$text = preg_replace('@<script[^>]*?>.*?</script>@si', '', $text);
		$text = strip_tags($text, '<p> <strong> <bold> <i> <em> <emphasis> <del> <h1> <h2> <h3> <h4> <h5> <img>');
		$excerpt_length = 200; //200 words for some reason... would prefer a char count. Not sure how to do it. 
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

include ('options/options.php');

?>