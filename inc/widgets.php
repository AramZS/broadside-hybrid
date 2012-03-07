<?php

// picture widget
class tf_picture_widget extends WP_Widget {
	
	function tf_picture_widget() {
		$options = array('classname' => 'tf-widget tf-picture-widget', 'description' => __('Custom text box that displays an image.', 'domain-themefit-hybrid'));
		parent::WP_Widget( 'tf_picture_widget', $name = 'TF '.__('Picture Widget', 'domain-themefit-hybrid'), $options );
	}

	function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );
		$url = apply_filters( 'widget_url', $instance['url'] );
		$float = apply_filters( 'widget_float', $instance['float'] );
		$class = '';
		$text = '';
		if($url){
			$float == 'left' ? $class = "alignleft" : $class = "alignright";
			$text = '<img src="'.$url.'" alt="'.$title.'" class="'.$class.'" />';
		}
		$text .= apply_filters( 'widget_text', $instance['text'] ); 
		echo $before_widget;
		if ( $title )
			echo $before_title . $title . $after_title;
			echo wpautop($text);
			echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['url'] = strip_tags($new_instance['url']);
		$instance['float'] = strip_tags($new_instance['float']);
		if ( current_user_can('unfiltered_html') )
			$instance['text'] =  $new_instance['text'];
		else
			$instance['text'] = stripslashes( wp_filter_post_kses( addslashes($new_instance['text']) ) ); 
		$instance['filter'] = isset($new_instance['filter']);
		return $instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'text' => '' ) );
		$title = esc_attr( $instance[ 'title' ] );
		$url = esc_attr( $instance['url'] );
		$float = $instance['float'];
		$text = format_to_edit($instance['text']);
		
		?>
		<p>
		<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'domain-themefit-hybrid'); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
        
        <p>
		<label for="<?php echo $this->get_field_id('url'); ?>"><?php _e('Image Path (URL):', 'domain-themefit-hybrid'); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id('url'); ?>" name="<?php echo $this->get_field_name('url'); ?>" type="text" value="<?php echo $url; ?>" />
		</p>
        
        <p>
        <label for="<?php echo $this->get_field_id('float'); ?>"><?php _e('Float Image:', 'domain-themefit-hybrid'); ?></label><br />
        <input class="radio" type="radio" name="<?php echo $this->get_field_name('float'); ?>" value="left" <?php checked("left", $float) ?>> <?php _e('Left', 'domain-themefit-hybrid'); ?><br />
		<input class="radio" type="radio" name="<?php echo $this->get_field_name('float'); ?>" value="right" <?php checked("right", $float) ?>> <?php _e('Right', 'domain-themefit-hybrid'); ?><br />
        </p>

		<p><label for="<?php echo $this->get_field_id('text'); ?>"><?php _e('Text:', 'domain-themefit-hybrid'); ?></label>
		<textarea class="widefat" rows="5" cols="10" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>"><?php echo $text; ?></textarea><br /><small style="color:#FF0000"><?php _e('HTML wrapped in paragraph tags.', 'domain-themefit-hybrid'); ?></small>
        </p>
       
		<?php 
	}
}

// recent posts widget
class tf_recent_posts_widget extends WP_Widget {

	function tf_recent_posts_widget() {
		$options = array('classname' => 'tf-recent-posts-widget', 'description' => __('Display recent posts.', 'domain-themefit-hybrid'));
		parent::WP_Widget('tf_recent_posts_widget', $name =  'TF '.__('Recent Posts Widget', 'domain-themefit-hybrid'), $options);
	}

	function widget($args, $instance) {
		extract($args);
		
		$title = apply_filters('widget_title', empty($instance['title']) ? __('Recent Posts', 'domain-themefit-hybrid') : $instance['title']);
		$categories = ''; // get categories of post for display
		
		if ( !$number = (int) $instance['number'] )
			$number = 10;
		else if ( $number < 1 )
			$number = 1;
		else if ( $number > 10 )
			$number = 10;
			
		$rp_cat = $instance['rp_cat']; 
		$recentPosts = new WP_Query(array('cat' => $rp_cat, 'showposts' => $number, 'nopaging' => 0, 'post_status' => 'publish', 'caller_get_posts' => 1));
		
		if ($recentPosts->have_posts()) :
		
		echo $before_widget; 
		
        echo $before_title . $title . $after_title;
		?>		
			<ul>
				<?php  while ($recentPosts->have_posts()) : $recentPosts->the_post(); ?>
				<li>
					<span class="meta"><?php the_time(get_option('date_format')); ?> 
						<?php if($rp_cat == "") : ?> in 
							<?php foreach((get_the_category()) as $category) {
   									$categories .= $category->cat_name . ', ';
							}
                            echo rtrim($categories, ', ');
							$categories = '';
							?>
						<?php endif; ?>
                    </span>
					<a href="<?php the_permalink() ?>" title="<?php echo esc_attr(get_the_title() ? get_the_title() : get_the_ID()); ?>"><?php if ( get_the_title() ) the_title(); else the_ID(); ?> </a>
				</li>
                
				<?php endwhile; ?>
			</ul>
            
			<?php echo $after_widget; ?>
		
		<?php
			wp_reset_query();  
		endif;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['number'] = (int) $new_instance['number'];
		$instance['rp_cat'] = $new_instance['rp_cat'];

		return $instance;
	}

	function form( $instance ) {
		
		$title = isset($instance['title']) ? esc_attr($instance['title']) : __('Recent Posts', 'domain-themefit-hybrid');
		
		if ( !isset($instance['number']) || !$number = (int) $instance['number'] )
			$number = 5;
			
		$rp_cat = $instance['rp_cat'];

		$pn_categories_obj = get_categories('hide_empty=0');
		$pn_categories = array(); ?>

		<p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'domain-themefit-hybrid'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>
		<p>
            <label for="<?php echo $this->get_field_id('rp_cat'); ?>"><?php _e('Category', 'domain-themefit-hybrid'); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id('rp_cat'); ?>" name="<?php echo $this->get_field_name('rp_cat'); ?>">
                <option value=""><?php _e('All', 'domain-themefit-hybrid'); ?></option>
                <?php foreach ($pn_categories_obj as $pn_cat) {				
                    echo '<option value="'.$pn_cat->cat_ID.'" '.selected($pn_cat->cat_ID, $rp_cat).'>'.$pn_cat->cat_name.'</option>';
                } ?>
            </select>
        </p>

		<p>
            <label for="<?php echo $this->get_field_id('number'); ?>"<?php _e('Number of posts:', 'domain-themefit-hybrid'); ?></label>
            <input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" size="3" />
            <br />
            <small><?php _e('at most 10', 'domain-themefit-hybrid'); ?></small>
        </p>
<?php
	}
}



// flickr widget
class tf_flickr_widget extends WP_Widget {
	
	function tf_flickr_widget() {
		$options = array('classname' => 'tf-widget tf-flickr-widget', 'description' => __('Custom text box that displays an image.', 'domain-themefit-hybrid'));
		parent::WP_Widget( 'tf_flickr_widget', $name = 'TF '.__('Flickr Widget', 'domain-themefit-hybrid'), $options );
	}

	function widget( $args, $instance ) {
		if( file_exists( ABSPATH . WPINC . '/rss.php') ) {
			require_once(ABSPATH . WPINC . '/rss.php');
		} else {
			require_once(ABSPATH . WPINC . '/rss-functions.php');
		}
		
		extract( $args );
		
		$title = apply_filters( 'title', $instance['title'] );
		$url = apply_filters( 'url', $instance['url'] );
		$numPics = (int) $instance['numpics'];
		$rss = fetch_rss( $url );
		$count = 0;
		
		if( is_array( $rss->items ) ) {
			$imageString = '';
			$items = array_slice( $rss->items, 0, $numPics);
			$imagePrefixes = array("_m.", "_t.", "_b.");
			$squareImagePrefix = "_s.";
			
			while( list( $key, $image ) = each( $items )) {
				preg_match_all("/<IMG.+?SRC=[\"']([^\"']+)/si",$image[ 'description' ],$match,PREG_SET_ORDER);
				$imageURL = str_replace( $imagePrefixes, $squareImagePrefix, $match[0][1] );
				$imageString .= '<li';
				if(++$count % 3 == 0 ) $imageString .= ' class="break"';
				$imageString .= '>';
				$imageString .= '<a href="'.$image[ 'link' ].'" target="_blank">';
				$imageString .= '<img alt="'.wp_specialchars( $image[ 'title' ], true ).'" title="'.wp_specialchars( $image[ 'title' ], true ).'" src="'.$imageURL.'" border="0">';
				$imageString .= '</a>';
				$imageString .= '</li>';
			}
		}
		?>
        
		<?php echo $before_widget; ?>
		<?php echo $before_title . $title . $after_title; ?>

        <ul id="flickr-wrapper">
			<?php echo $imageString ?>
        </ul>
        
        <?php echo $after_widget; ?>
        
    <?php	
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags(stripslashes($new_instance['title']));
		$instance['url'] = strip_tags(stripslashes($new_instance['url']));
		$instance['numpics'] = (int) $new_instance['numpics'];

		return $instance;
	}

	function form( $instance ) {
		$title = esc_attr( $instance[ 'title' ] );
		$url = esc_attr( $instance['url'] );
		$numPics = (int) $instance['numpics'] ;
		$maxPicsAllowed = 15; // five rows of three
		
		if(!isset($numPics)) $numPics = 1;
		
		?>
		<p>
		<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'domain-themefit-hybrid'); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
        
        <p>
		<label for="<?php echo $this->get_field_id('url'); ?>"><?php _e('Feed URL:', 'domain-themefit-hybrid'); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id('url'); ?>" name="<?php echo $this->get_field_name('url'); ?>" type="text" value="<?php echo $url; ?>" />
		</p>
        
        <p>
        <label for="<?php echo $this->get_field_id('numpics'); ?>"><?php _e('Pictures to Show:', 'domain-themefit-hybrid'); ?></label>
        <select id="<?php echo $this->get_field_id('numpics'); ?>" name="<?php echo $this->get_field_name('numpics'); ?>">
        <?php for ( $i = 1; $i <= $maxPicsAllowed; ++$i ) echo "<option value='$i' ".($numPics==$i ? "selected='selected'" : '').">$i</option>"; ?>
        </select>
        </p>
        
        <p><span style="color:#F00; font-weight:bold;"><?php _e('Note', 'domain-themefit-hybrid'); ?> </span><?php _e('Your RSS feed link should be at the bottom of your Flickr homepage (look for the orange RSS icon).', 'domain-themefit-hybrid'); ?></p>
       
		<?php 
	}
}
?>