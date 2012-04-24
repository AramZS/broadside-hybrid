<?php get_header(); ?>

<?php if (have_posts()) : ?>
	<div id="more-left-column" class="border-styles layout-container">
	
		<?php include ('sidebar-left.php'); ?>
	
	</div>
	<div id="tf-left-column" class="border-styles layout-container">
	
		<?php include ('featuredstory.php'); 
		  $args = array(
			/**Here post__not_in expects an array. You'd think you could put a comma seperated
			string here and that would be fine, but you can't. Instead you have to explode the comma seperated list into an array**/
			'post__not_in' => explode(",", $firstslide),
			'posts_per_page' => get_option( 'posts_per_page' ),
			'paged' => get_query_var('paged')
			);	
			query_posts($args);
		?>
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
							<?php the_excerpt(); ?>
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