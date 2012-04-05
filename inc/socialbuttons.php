			<div class="social-buttons">
				<div class="social-buttons-fb social-button">
					<div class="social-button-fb-large">
						<div id="fb-root"></div>
						<div class="fb-like" data-href="<?php the_permalink(); ?>" data-send="false" data-width="450" data-show-faces="true" data-action="recommend"></div>
					</div>
					<div class="social-button-fb-small">
						<div class="fb-like" data-href="<?php the_permalink(); ?>" data-send="false" data-width="295" data-show-faces="true" data-action="recommend"></div>
					</div>
				</div>
								
				<div class="social-buttons-g social-button"><g:plusone size="medium" href="<?php the_permalink(); ?>"></g:plusone></div>

				<div class="social-buttons-twit social-button"><a href="http://twitter.com/share" class="twitter-share-button" data-url="<?php the_permalink(); ?>" data-text="<?php the_title(); ?>" data-count="horizontal" data-via="MasonBroadside">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script></div>
				
				<div class="social-buttons-su social-button"><su:badge layout="2" location="<?php the_permalink(); ?>"></su:badge></div>
			</div>