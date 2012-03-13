<?php
global $options;
foreach ($options as $value) {
    if (get_settings( $value['id'] ) === FALSE) { $$value['id'] = $value['std']; } else { $$value['id'] = get_settings( $value['id'] ); }
}

$exploded_left_cats = explode(",", $bh_left_cats);

?><div id="left-cats"><?php
foreach ($exploded_left_cats as $value) {

	?>
		<div class="left-cat-box">
			<div class="left-cat-title">
				<h5><?php echo get_the_category_by_ID($value); ?></h5>
			</div>
	<?php
	
			$leftcatquery = new WP_Query( array( 'cat' => $value, 'offset' => 2, 'showposts' => 5) );
				?><ul><?php
					while ($leftcatquery->have_posts() ) : $leftcatquery->the_post();
						?><li>
							<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" alt="<?php the_title_attribute(); ?>"><?php
								the_title();
							?></a>
						</li><?php
					endwhile;
				?></ul>
			
		</div><?php
					
	
	wp_reset_postdata();
	wp_reset_query();

} //end foreach
?></div>

<div id="lower-left-widgets">
	
		<?php if ( !function_exists('dynamic_sidebar')
				|| !dynamic_sidebar('Lower Left Sidebar') ) : ?>
		  
		<?php endif; ?>

</div>
<?php
?>