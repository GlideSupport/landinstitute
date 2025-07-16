<?php

$query = get_query_var('learn_query');
$paged = get_query_var('paged_var');


if ($query->have_posts()) :
	while ($query->have_posts()) : $query->the_post();

	$terms = get_the_terms( get_the_ID(), 'learn-type' );
	$learn_type = ''; // default fallback value
	if ( ! is_wp_error( $terms ) && ! empty( $terms ) ) {
		$learn_type = $terms[0]->name; // Or use ->slug if you need slug
	}

		//$format = get_post_format() ?: 'Publication';
		?>
		<div class="filter-card-item">
			<a href="<?php the_permalink(); ?>" class="filter-card-link">
				<div class="image">
					<?php if (has_post_thumbnail()) : ?>
						<?php echo wp_get_attachment_image(get_post_thumbnail_id(get_the_ID()), 'thumb_500'); ?>
					<?php else : ?>
						<img src="<?php echo esc_url( wp_get_attachment_image_url( BASETHEME_DEFAULT_IMAGE, 'full' ) ); ?>" alt="Default thumbnail" width="500" height="300" />
						<?php endif; ?>
				</div>
				<div class="filter-card-content">
					<div class="gl-s52"></div>
					<div class="eyebrow ui-eyebrow-16-15-regular"><?php echo esc_html(ucfirst($learn_type)); ?></div>
					<div class="gl-s6"></div>
					<div class="card-title heading-7"><?php the_title(); ?></div>
					<div class="gl-s12"></div>
					<div class="description ui-18-16-regular">
						<?php echo wp_trim_words(get_the_excerpt(), 30); ?>
					</div>
					<div class="gl-s20"></div>
					<div class="read-more-link">
						<div class="border-text-btn">Read more</div>
					</div>
					<div class="gl-s80"></div>
				</div>
			</a>
		</div>
	<?php endwhile;
else : ?>
<div class="not-found-block">
	<div class="not-found">No resources found.</div>
</div>
<?php endif;
wp_reset_postdata();
