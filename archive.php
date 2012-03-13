<?php get_header(); ?>

		<?php if (have_posts()) : ?>
			
            <div id="tf-page-title" class="heavy-border-styles">
 			<?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>

			<?php /* If this is a category archive */ if (is_category()) { ?>
				<h1><?php single_cat_title(); ?></h1>

			<?php /* If this is a tag archive */ } elseif( is_tag() ) { ?>
				<h1><?php single_tag_title(); ?></h1>

			<?php /* If this is a daily archive */ } elseif (is_day()) { ?>
				<h1><?php the_time('F jS, Y'); ?></h1>

			<?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
				<h1><?php the_time('F, Y'); ?></h1>

			<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
				<h1><?php the_time('Y'); ?></h1>

			<?php /* If this is an author archive */ } elseif (is_author()) { ?>
				<h1><?php _e('Author Archive', 'domain-themefit-hybrid'); ?></h1>

			<?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
				<h1><?php _e('Blog', 'domain-themefit-hybrid'); ?></h1>
			
			<?php } ?>
            </div>

			<div id="more-left-column" class="border-styles layout-container">
	
				<?php include ('sidebar-left.php'); ?>
			
			</div>
			
            <div id="tf-left-column" class="border-styles layout-container">

			<?php while (have_posts()) : the_post(); ?>
			
				<div <?php post_class('content-container border-styles'); ?>>
                	
                    <div class="showhide">
                        
                        <div class="persistent-content">
							<?php include (STYLESHEETPATH . '/inc/meta.php' ); ?>
						   <h2 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
                            
                        </div>
                        
                        <a class="toggle-button accent-color-background"></a>
                        
                        <!-- force ie8 to toogle smoothly -->
                        <p class="ie8-toggle-fix">&nbsp;</p>
                        
                        <div class="toggle-content">
                            <div class="entry">
                                <?php the_content(); ?>
                            </div>
                        </div>
                        
                    </div>
                    
				</div>
                
			<?php endwhile; ?>

			<?php include (TEMPLATEPATH . '/inc/pagination.php' ); ?>
            
		</div>
        
		<?php else : ?>
        
			<div id="tf-page-title" class="heavy-border-styles">
				<h1><?php _e('Nothing found', 'domain-themefit-hybrid'); ?></h1>
			</div>
            
            <div id="tf-left-column" class="border-styles layout-container">
             	 <p><?php _e("Didn't find any posts that matched your search. Try something else.", 'domain-themefit-hybrid'); ?></p>
            </div>
            
		<?php endif; ?>
    
        <div id="tf-right-column" class="border-styles layout-container">
            <?php include (TEMPLATEPATH . '/inc/sidebar-post.php' ); ?>
        </div>

<?php get_footer(); ?>