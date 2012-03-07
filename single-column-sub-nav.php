<?php 
/*
Template Name: Single Column with Sub Nav
*/

global $post;
$postID = $post->ID;
$menuName = 'main';
$menuList = '';
$currentMenuItemID = 0;

if ( ( $locations = get_nav_menu_locations() ) && isset( $locations[ $menuName ] ) ) {
	
	$menu = wp_get_nav_menu_object( $locations[ $menuName ] );
	$menuItems = wp_get_nav_menu_items($menu->term_id);
	
	$menuList = '<ul id="tf-sub-page-nav">';
	
	// find current menu item based on page/post id
	foreach ( (array) $menuItems as $key => $menuItem ) {
		if($menuItem->object_id == $postID) {
			$currentMenuItemID = $menuItem->ID;
			break;
		}
	}
	
	// display children of current menu item
	foreach ( (array) $menuItems as $key => $menuItem ) {
		if($menuItem->menu_item_parent == $currentMenuItemID) {
			$title = $menuItem->title;
			$url = $menuItem->url;
			$menuList .= '<li><a href="' . $url . '">' . $title . '</a></li>';
		}
	}
	
	$menuList .= '</ul>';
	
    } else { 
		// menu is not defined
		$menuList = '<ul id="tf-sub-page-nav"><li>Menu "' . $menuName . '" not defined.</li></ul>';
 }	
		
get_header(); ?>
	
    <div id="tf-page-title" class="heavy-border-styles">
        <h1><?php the_title(); ?></h1>
    </div>
        
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    
    	<div class="layout-container">
			<?php echo $menuList; ?>
            <?php the_content(); ?>
            <?php nextpage_paging(array(
						'before' => '<div class="pagination nextpage-pagination content-container primary-color-text">', 
						'after' => '</div>',
						'current_page_before' => '<span class="page-numbers current">',
						'current_page_after' => '</span>')); ?>
            <?php comments_template( ); ?>
       </div>
                    
	<?php endwhile; endif; ?>

<?php get_footer(); ?>