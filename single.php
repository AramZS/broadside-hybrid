<?php get_header(); ?>
	
	<div id="more-left-column" class="border-styles layout-container">
	
		<?php include ('sidebar-left.php'); ?>
	
	</div>
    
	<div id="tf-left-column" class="border-styles layout-container">
    
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    
        <div class="content-container">
        
        	<!-- content-container class not applied directly to post. It needs to wrap comments too. -->
            
            <div <?php post_class() ?> id="post-<?php the_ID(); ?>">
                
				<?php include (STYLESHEETPATH . '/inc/meta.php' ); ?>
				
                <h2><?php the_title(); ?></h2>
                
				<?php
				
					if (has_post_thumbnail() ) {
					
						echo '<div class="single-post-thumb">';
					
							$post_thumbnail_id = get_post_thumbnail_id( $post_id );
						
							the_post_thumbnail( 'main-thumb' );
							
							echo '<div class="thumb-caption">';
								
								echo get_the_excerpt_here($post_thumbnail_id);
							
							echo '</div>';
							
							echo '<div class="single-post-thumb-credit">';
							
								echo 'Photo by: ';
								echo get_post_meta($post_thumbnail_id, '_photocredit', true);
								
							echo '</div>';
					
						echo '</div>';
					}
				?>
				<?php
					$authorTitle = get_the_author_meta('authortitle');
					$authorTitleMeta = str_word_count($authorTitle);
					
				?>
				
               <div class="author-area">By: <a href="<?php get_site_url(); ?>/author/<?php the_author_meta('user_login'); ?>/" rel="author" alt="<?php the_author(); ?>" title="<?php the_author(); ?>"><?php the_author(); ?></a>
			   
					<?php
						if ( $authorTitleMeta > 0) {
							echo " / ";
							echo $authorTitle;
						}
					?>
			   </div> 
			   
				<?php include (STYLESHEETPATH . '/inc/socialbuttons.php' ); ?>
        
                <div class="entry">
                    
                    <?php the_content(); ?>
                    <?php nextpage_paging(array(
						'before' => '<div class="pagination nextpage-pagination content-container primary-color-text">', 
						'after' => '</div>',
						'current_page_before' => '<span class="page-numbers current">',
						'current_page_after' => '</span>')); ?>
                </div>
                
                <?php edit_post_link(__('Edit this entry', 'domain-themefit-hybrid'),'','.'); ?>
                
            </div>

			<?php comments_template( ); ?>
        
		</div>

	<?php endwhile; endif; ?>
    
    </div>
    
	<div id="tf-right-column" class="border-styles layout-container">
        <?php include (TEMPLATEPATH . '/inc/sidebar-post.php' ); ?>
    </div>
    
<?php get_footer(); ?>