<?php

global $wp_rewrite;

$wp_query->query_vars['paged'] > 1 ? $currentpage = $wp_query->query_vars['paged'] : $currentpage = 1;

$pagination = array(
	'base' => @add_query_arg('page','%#%'),
	'format' => '',
	'total' => $wp_query->max_num_pages,
	'current' => $currentpage,
	'show_all' => false,
	'type' => 'plain',
	'prev_text'    => __('Prev', 'domain-themefit-hybrid'),
    'next_text'    => __('Next', 'domain-themefit-hybrid')
	);

if( $wp_rewrite->using_permalinks() )
	$pagination['base'] = user_trailingslashit( trailingslashit( remove_query_arg('s',get_pagenum_link(1) ) ) . 'page/%#%/', 'paged');

if( !empty($wp_query->query_vars['s']) )
	$pagination['add_args'] = array('s'=>str_replace(" ", "+", get_query_var('s')));

echo '<div class="pagination content-container primary-color-text">' . paginate_links($pagination) . '</div>';

?>