<div class="meta">
    <?php printf(__('<em>Posted on:</em> <span class="primary-color-text">%s</span> <em>by</em> <span class="primary-color-text">%s</span>', 'domain-themefit-hybrid'), get_the_time('F jS, Y'), get_the_author()); ?>
    <?php comments_popup_link(	__('No Comments', 'domain-themefit-hybrid'), 
								__('1 Comment', 'domain-themefit-hybrid'), 
								__('% Comments', 'domain-themefit-hybrid'),
								'comments-link', ''); ?>
</div>
