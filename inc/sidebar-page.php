<ul class="sidebar">
	<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar(__('Page Sidebar Widgets', 'domain-themefit-hybrid')) ) : ?>
    <li class="sidebar-widget-item content-container">
        <h5><?php _e('Page Sidebar Widget Area', 'domain-themefit-hybrid'); ?></h5>
        <p>
            <?php _e('You can add page sidebar widgets to this area from the WordPress admin in "Page Sidebar Widgets."', 'domain-themefit-hybrid'); ?><br />
            <?php echo do_shortcode( '[tf_button link="'. get_bloginfo('url') .'/wp-admin/widgets.php"]' . __('Add Widgets', 'domain-themefit-hybrid') . '[/tf_button]'); ?>
        </p>
    </li>
	<?php endif; ?>
</ul>