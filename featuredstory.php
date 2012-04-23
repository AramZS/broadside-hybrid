<?php
if ( is_home() && !is_paged() ) {

	global $options;
	foreach ($options as $value) {
		if (get_settings( $value['id'] ) === FALSE) { $$value['id'] = $value['std']; } else { $$value['id'] = get_settings( $value['id'] ); }
	}
	
	?>
	<div class="featured-box">
	
		<?php 
		
		$k = 1;
		
		global $firstslide;
		//I'm going to need to grab this stories ID and exclude it from every freaking other query on the page... ok... on the to do list.
		$featuredstory = new WP_Query( array( 'cat' => $bh_featured_cats, 'showposts' => 5) );
		
		while ($featuredstory->have_posts() ) : $featuredstory->the_post();
		?>
		
		<div <?php post_class('content-container border-styles'); ?>>
		
				<!--Need to check here if there is a featured image. If not, I need to create a block that provides the appropriate height-->
				<?php 
				
				if (has_post_thumbnail()) {
				
				?>
				<div class="photo-frame"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" alt="<?php the_title_attribute(); ?>" >
					<?php the_post_thumbnail( 'main-thumb' ); ?>
				</a></div>
				
				<?php 
				
				} else {
				
				?>
				
				<div class="photofiller"> </div>
				
				<?php } ?>
					
				<h2 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
				<div class="entry">
					<?php the_excerpt(); ?>
				</div>
				
				<div class="read-more-link">
					<a href="<?php echo get_permalink($post->ID);?>">Read more...</a>
				</div>
			
		</div>
		<?php 
		

					/**This delivers the ID of the first post of each slide (category) to the global variable in a comma seperated list. 
					
					Note: This is built to scale, so no matter how many categories are used to populate the slider, the first item of every category in the slider will be excluded from the post list on the home page **/

					if ($k == 1) {
						$firstslide .= get_the_ID() . ",";

					}
					$k++;
					if ($k > 5) { $k=1; }
					
		endwhile;
		wp_reset_postdata();
		wp_reset_query();
		?>
	</div>
<?php
}
?>