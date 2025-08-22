<?php

$query = get_query_var('learn_query');
$paged = get_query_var('paged_var');
$requestdbyajax = get_query_var('requestdbyajax');






if ($query->have_posts()) :
	while ($query->have_posts()) : $query->the_post();
	$youtube_url = get_field('li_ldo_youtube_url', get_the_ID());
	$li_ido_date = get_field('li_ido_date', get_the_ID());
	$short_Desc    = apply_filters('the_content', get_the_content());
    $short_content = wp_trim_words($short_Desc, 25, '...');
	$terms = get_the_terms( get_the_ID(), 'learn-type' );
	$learn_type = ''; // default fallback value
	if ( ! is_wp_error( $terms ) && ! empty( $terms ) ) {
		$learn_type = $terms[0]->name; // Or use ->slug if you need slug
	}

		//$format = get_post_format() ?: 'Publication';
		?>
		<div class="filter-card-item">
			<a href="<?php the_permalink(); ?>" class="filter-card-link">
				<div class="image tag-show">
					<?php if ( ! empty( $li_ido_date ) ) : ?>
						<div class="tag-date"><div class="block-content eyebrow ui-eyebrow-16-15-regular"><?php echo esc_html( $li_ido_date ); ?></div></div>
					<?php endif; ?>
					<?php
					if (has_post_thumbnail()) {
						// Featured image
						echo wp_get_attachment_image(get_post_thumbnail_id(get_the_ID()), 'thumb_500');
					} elseif (!empty($youtube_url)) {
						// Extract YouTube video ID
						preg_match(
							'%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i',
							$youtube_url,
							$matches
						);
						if (!empty($matches[1])) {
							$video_id = $matches[1];
							echo '<img src="' . esc_url('https://img.youtube.com/vi/' . $video_id . '/maxresdefault.jpg') . '" alt="' . esc_attr(get_the_title()) . '" width="500" height="300" />';
						} else {
							// Fallback default
							echo '<img src="' . esc_url(wp_get_attachment_image_url(BASETHEME_DEFAULT_IMAGE, 'full')) . '" alt="Default thumbnail" width="500" height="300" />';
						}
					} else {
						// Fallback default
						echo '<img src="' . esc_url(wp_get_attachment_image_url(BASETHEME_DEFAULT_IMAGE, 'full')) . '" alt="Default thumbnail" width="500" height="300" />';
					}
					?>
				</div>

				<div class="filter-card-content">
					<div class="gl-s52"></div>
					<div class="eyebrow ui-eyebrow-16-15-regular"><?php echo esc_html(ucfirst($learn_type)); ?></div>
					<div class="gl-s6"></div>
					<div class="card-title heading-7"><?php echo html_entity_decode(get_the_title()); ?></div>
					<div class="gl-s12"></div>
					<div class="description ui-18-16-regular">
						<?php echo html_entity_decode($short_content); ?>
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
else : 
if($requestdbyajax){
?>
<div class="not-found-block">
	<div class="not-found">No resources found.</div>
</div>
<?php } endif;
wp_reset_postdata();
