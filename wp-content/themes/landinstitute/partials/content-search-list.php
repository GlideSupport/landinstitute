<?php
// Use custom query if available
$custom_query = isset($search_query) ? $search_query : $wp_query;

if ( $custom_query->have_posts() ) :
	while ( $custom_query->have_posts() ) : $custom_query->the_post();
		?>
		<div class="event-teaser-list-col">
			<a href="<?php the_permalink(); ?>" class="event-teaser-list-card">
				<div class="event-teaser-list-content">
					<div class="gl-s44"></div>
					
					<div class="ui-eyebrow-16-15-regular block-subhead">
						<?php echo esc_html( get_post_type_object( get_post_type() )->labels->singular_name ); ?>
					</div>
					
					<div class="gl-s6"></div>
					
					<h5 class="heading-5 mb-0 block-title">
						<?php the_title(); ?>
					</h5>
					
					<div class="gl-s12"></div>
					
					<div class="block-content body-18-16-regular">
						<?php echo wp_kses_post( wp_trim_words( get_the_excerpt(), 40, '…' ) ); ?>
					</div>
					
					<div class="gl-s20"></div>
					
					<div class="block-btns">
						<div class="border-text-btn" role="button" aria-label="<?php esc_attr_e( 'Read more', 'land_institute' ); ?>">
							<?php esc_html_e( 'Read more', 'land_institute' ); ?>
						</div>
					</div>
					
					<div class="gl-s44"></div>
				</div>
			</a>
		</div>
		<?php
	endwhile;
else :
	?>
	<div class="not-found-block">
		<div class="not-found">No Search results found.</div>
	</div>
<?php endif; ?>
