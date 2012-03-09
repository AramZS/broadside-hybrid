<div class="meta">
    <?php 
	global $options;
	foreach ($options as $value) {
		if (get_settings( $value['id'] ) === FALSE) { $$value['id'] = $value['std']; } else { $$value['id'] = get_settings( $value['id'] ); }
	}
	$c = 0;
	$catcount = count(get_the_category());
	foreach((get_the_category()) as $category) {
	$c++;
    if ($category->cat_name != $bh_featured_cats) {
    echo '<a href="' . get_category_link( $category->term_id ) . '" title="' . sprintf( __( "View all posts in %s" ), $category->name ) . '" ' . '>' . $category->name.'</a>';
	
	} if ($catcount > 1 && $c < $catcount){ echo ", ";} else { echo " "; }
	}
	
	echo " / "; echo get_the_time('M. j, Y'); ?>
    <?php comments_popup_link(	__('No Comments', 'domain-themefit-hybrid'), 
								__('1 Comment', 'domain-themefit-hybrid'), 
								__('% Comments', 'domain-themefit-hybrid'),
								'comments-link', ''); ?>
</div>
