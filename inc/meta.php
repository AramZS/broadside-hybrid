<div class="meta">
    <?php the_category(', '); echo " / "; echo get_the_time('M. j, Y'); ?>
    <?php comments_popup_link(	__('No Comments', 'domain-themefit-hybrid'), 
								__('1 Comment', 'domain-themefit-hybrid'), 
								__('% Comments', 'domain-themefit-hybrid'),
								'comments-link', ''); ?>
</div>
