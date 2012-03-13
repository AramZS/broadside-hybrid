<?php
if ( is_home() && !is_paged() ) {

	global $options;
	foreach ($options as $value) {
		if (get_settings( $value['id'] ) === FALSE) { $$value['id'] = $value['std']; } else { $$value['id'] = get_settings( $value['id'] ); }
	}
	
	?>
	<div class="featured-box">
	
		<?php 
		//I'm going to need to grab this stories ID and exclude it from every freaking other query on the page... ok... on the to do list.
		$featuredstory = new WP_Query( array( 'cat' => $bh_featured_cats, 'showposts' => 1) );
		
		while ($featuredstory->have_posts() ) : $featuredstory->the_post();
		?>
		
		<div <?php post_class('content-container border-styles'); ?>>
		
				<div class="photo-frame"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" alt="<?php the_title_attribute(); ?>" >
					<?php the_post_thumbnail( 'main-thumb' ); ?>
				</a></div>
					
				<h2 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
				<div class="entry">
					<?php the_excerpt(); ?>
				</div>
				
				<div class="read-more-link">
					<a href="<?php echo get_permalink($post->ID);?>">Read more...</a>
				</div>
			
		</div>
		<?php 
		endwhile;
		wp_reset_postdata();
		wp_reset_query();
		?>
	</div>
<?php
}
?>