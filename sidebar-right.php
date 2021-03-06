<?php
/*
Template Name: Sidebar Right
*/
	get_header(); ?>

	<div id="tf-page-title" class="heavy-border-styles">
		<h1><?php the_title(); ?></h1>
	</div>
		
    <div id="tf-left-column" class="border-styles layout-container">
    
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        
        <div class="content-container">
			<?php the_content(); ?>
			<?php nextpage_paging(array(
						'before' => '<div class="pagination nextpage-pagination content-container primary-color-text">', 
						'after' => '</div>',
						'current_page_before' => '<span class="page-numbers current">',
						'current_page_after' => '</span>')); ?>
			<?php comments_template(); ?>
        </div>
        
        <?php endwhile; endif; ?>
        
	</div>
    
	<div id="tf-right-column" class="border-styles layout-container">
        <?php include (TEMPLATEPATH . '/inc/sidebar-page.php' ); ?>
    </div>

<?php get_footer(); ?>