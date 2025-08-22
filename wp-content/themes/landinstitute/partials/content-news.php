<?php
/**
 * Template part for displaying single news
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Base Theme Package
 * @since 1.0.0
 */

list( $bst_var_post_id, $bst_fields, $bst_option_fields, $bst_queried_object ) = BaseTheme::defaults();

// Post Tags & Categories.
$news_type_terms = get_the_terms($bst_var_post_id, 'news-type');
$news_type_name = !empty($news_type_terms) && !is_wp_error($news_type_terms) ? esc_html($news_type_terms[0]->name) : '';
$bst_var_theme_default_image = $bst_option_fields['bst_var_theme_default_image'] ?? null;
$featured_image_id = get_post_thumbnail_id();
$featured_image_id = $featured_image_id ? $featured_image_id : $bst_var_theme_default_image;
$featured_image_html = wp_get_attachment_image($featured_image_id, 'thumb_1000', false, ['alt' => esc_attr(get_the_title())]);

$bst_var_posttitle = $bst_fields['bst_var_posttitle'] ?? get_the_title();
$li_nwd_authors = $bst_fields['li_nwd_authors'] ?? '';
$li_nwd_publication = $bst_fields['li_nwd_publication'] ?? '';
$bg_pattern = $bst_fields['li_nwd_background_pattern'] ??  $bst_option_fields['li_news_list_detail_page_bg_pattern'];

$li_ldo_url = $bst_fields['li_nwd_pdf_url'];
$link = $li_ldo_url ?? '';
$li_nwd_date = $bst_fields['li_nwd_date'];

$li_nwd_read_more = $bst_fields['li_nwd_read_more'] ?? '';
$li_nwd_read_more_check = BaseTheme::headline_check($li_nwd_read_more);
$li_nwd_relatedselected_post = $bst_fields['li_nwd_relatedselected_post'] ?? 'related';
$li_nwd_select_news = $bst_fields['li_nwd_select_news'] ?? null;

$bst_var_title  = $bst_option_fields['bst_var_title'] ?? null;
$bst_var_kicker   = $bst_option_fields['bst_var_kicker'] ?? null;
$bst_var_form_selector = $bst_option_fields['bst_var_form_selector'] ?? null;

$li_no_bg_image_visible = $bst_fields['li_no_bg_image_visible'] ?? 'Show';
$li_no_bg_image = $bst_fields['li_no_bg_image'] ?? $bst_option_fields['li_to_select_default_background_pattern'];

$newsletter_form_visible = $bst_fields['li_nwd_newsletter_form_visible'] ?? 'Show';
$li_nwd_title = $bst_fields['li_nwd_title'] ?? $bst_var_title;
$li_nwd_kicker = $bst_fields['li_nwd_kicker'] ?? $bst_var_kicker;
$form_selector = $bst_fields['li_nwd_form_selector'] ?? $bst_var_form_selector;

$class = has_post_thumbnail($bst_var_post_id) ? 'hero-section hero-section-default hero-alongside-menu variation-width variation-details' : 'hero-section hero-section-default hero-text-only';

?>

<section id="hero-section" class="<?php echo $class; ?>">
	<!-- hero start -->
	<?php echo ($class !== 'hero-section hero-section-default hero-text-only' && !empty($bg_pattern)) ? '<div class="bg-pattern">' . wp_get_attachment_image($bg_pattern, 'thumb_1600') . '</div>' : ''; ?>
	<div class="hero-default has-border-bottom">
		<div class="wrapper">
			<div class="hero-alongside-block">
			<?php if ($class === 'hero-section hero-section-default hero-text-only') : ?>
					<div class="col-content bg-lime-green">
						<div class="hero-content">
							<div class="gl-s128"></div>
							<?php echo !empty($news_type_name) ? '<div class="ui-eyebrow-20-18-regular sub-title">' . $news_type_name . '</div>' : ''; ?>
							<div class="gl-s20"></div>
							<h3 class="heading-3 mb-0 block-title"><?php echo html_entity_decode($bst_var_posttitle); ?></h3>
							<?php echo (!empty($li_nwd_authors) || !empty($li_nwd_publication)) ? '<div class="gl-s44"></div>' : ''; ?>
						</div>
						<div class="col-content-row d-flex">
							<div class="column-content">
								<?php echo !empty($li_nwd_authors) ? '<div class="ui-eyebrow-16-15-bold eybrow-title">Author</div>' : ''; ?>
								<?php echo !empty($li_nwd_authors) ? '<div class="gl-s6"></div>' : ''; ?>
								<?php echo !empty($li_nwd_authors) ? '<div class="block-content body-18-16-regular">' . $li_nwd_authors . '</div>' : ''; ?>
							</div>
							<div class="column-content">
								<?php echo !empty($li_nwd_publication) ? '<div class="ui-eyebrow-16-15-bold eybrow-title">Publication</div>' : ''; ?>
								<?php echo !empty($li_nwd_publication) ? '<div class="gl-s6"></div>' : ''; ?>
								<?php if (!empty($link) && !empty($li_nwd_publication)) : ?>
									<a href="<?php echo esc_url($link); ?>" class="link-with-icon" target="_blank" rel="noopener">
										<span class="link-content">
											<?php echo esc_html($li_nwd_publication); ?>
											<span class="icon">
												<img src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/src/images/send-icon.svg" alt="" />
											</span>
										</span>
									</a>
								<?php elseif (!empty($li_nwd_publication)) : ?>
									<div class="body-18-16-regular block-content">
										<?php echo esc_html($li_nwd_publication); ?>
									</div>
								<?php endif; ?>
							</div>
							<?php if ( ! empty( $li_nwd_date ) ) : ?>
								<div class="column-content">
									<div class="ui-eyebrow-16-15-bold eybrow-title">Publication Date</div>
									<div class="gl-s6"></div>
									<div class="block-content body-18-16-regular">
										<?php echo esc_html( $li_nwd_date ); ?>
									</div>
								</div>
							<?php endif; ?>
						</div>
						<div class="gl-s96"></div>
					</div>
				<?php else : ?>
					<div class="col-left bg-lime-green">
						<div class="hero-content">
						<?php echo !empty($news_type_name) ? '<div class="ui-eyebrow-20-18-regular sub-title">' . $news_type_name . '</div>' : ''; ?>
							<div class="gl-s20"></div>
							<h3 class="heading-3 mb-0 block-title"><?php echo html_entity_decode($bst_var_posttitle); ?></h3>
							<?php echo (!empty($li_nwd_authors) || !empty($li_nwd_publication)) ? '<div class="gl-s30"></div>' : ''; ?>
							<?php echo !empty($li_nwd_authors) ? '<div class="ui-eyebrow-16-15-bold eybrow-title">Author</div>' : ''; ?>
							<?php echo !empty($li_nwd_authors) ? '<div class="gl-s6"></div>' : ''; ?>
							<?php echo !empty($li_nwd_authors) ? '<div class="block-content body-18-16-regular">' . $li_nwd_authors . '</div>' : ''; ?>
							<?php echo !empty($li_nwd_publication) ? '<div class="gl-s36"></div><div class="ui-eyebrow-16-15-bold eybrow-title">Publications (DOI)</div>' : ''; ?>
							<?php echo !empty($li_nwd_publication) ? '<div class="gl-s6"></div>' : ''; ?>
							<?php if (!empty($link) && !empty($li_nwd_publication)) : ?>
								<a href="<?php echo esc_url($link); ?>" class="link-with-icon" target="_blank" rel="noopener">
									<span class="link-content">
										<?php echo esc_html($li_nwd_publication); ?>
										<span class="icon">
											<img src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/src/images/send-icon.svg" alt="" />
										</span>
									</span>
								</a>
							<?php elseif (!empty($li_nwd_publication)) : ?>
								<div class="body-18-16-regular block-content">
									<?php echo esc_html($li_nwd_publication); ?>
								</div>
							<?php endif; ?>
							<?php if ( ! empty( $li_nwd_date ) ) : ?>
								<div class="gl-s36"></div>
								<div class="ui-eyebrow-16-15-bold eybrow-title">Publication Date</div>
								<div class="block-content body-18-16-regular">
									<?php echo esc_html( $li_nwd_date ); ?>
								</div>
							<?php endif; ?>
							<div class="gl-s96"></div>
						</div>
					</div>
				<?php endif; ?>
				<?php if ($class !== 'hero-section hero-section-default hero-text-only') : ?>
					<div class="col-right">
						<?php echo !empty($bg_pattern) ? '<div class="bg-pattern">' . wp_get_attachment_image($bg_pattern, 'thumb_1600') . '</div>' : ''; ?>
						<?php echo !empty($featured_image_html) ? '<div class="block-image-center">' . $featured_image_html . '</div>' : ''; ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>

<section id="page-section" class="page-section">
	<section class="container-720 bg-base-cream">
		<div class="wrapper">

			<?php
			$li_nwd_video_url     = $bst_fields['li_nwd_video_url'] ?? '';

			if (!empty($li_nwd_video_url)) {
				echo '<div class="single-audio-video-embed">';
				echo '<div class="gl-s64"></div>';
				echo '<div itemscope itemtype="http://schema.org/VideoObject">';
				echo wp_oembed_get(esc_url($li_nwd_video_url));
				echo '<meta itemprop="uploadDate" content="' . esc_attr(get_the_date('Y-m-d', $bst_var_post_id)) . '" />';
				echo '<meta itemprop="embedURL" content="' . esc_url($li_nwd_video_url) . '" />';
				echo '</div>'; // Closing VideoObject div
				echo '</div>'; // Closing single-hero
			}
			?>
					
			<div class="gl-s96"></div>
				<?php the_content(); ?>
			<div class="gl-s64"></div>
		</div>
	</section>
</section>

<?php if ($li_no_bg_image_visible): ?>
	<section class="container-1280">
		<div class="wrapper">
			<div class="bg-pattern-fixed has-border-bottom">
				<?php echo !empty($li_no_bg_image) ? '<div class="bg-pattern-fixed">' . wp_get_attachment_image($li_no_bg_image, 'thumb_2000', false, ['class' => 'desktop-img']) . '</div>' : ''; ?>
			</div>
		</div>
	</section>
<?php endif; ?>

<?php
	$args = [
		'post_type'   => 'news',
		'post_status' => 'publish',
	];

	switch ($li_nwd_relatedselected_post) {
		case 'selected':
			if (!empty($li_nwd_select_news)) {
				$args['post__in']  = $li_nwd_select_news;
				$args['orderby']   = 'post__in';
			}
			break;

		case 'related':
			$terms = get_the_terms($bst_var_post_id, 'news-type');
			if (!empty($terms) && !is_wp_error($terms)) {
				$term_ids = wp_list_pluck($terms, 'term_id');
				$args['tax_query'] = [
					[
						'taxonomy' => 'news-type',
						'field'    => 'term_id',
						'terms'    => $term_ids,
					],
				];
				$args['post__not_in'] = [$bst_var_post_id];
			} else {
				$args['post__in'] = [0]; // fallback: show nothing
			}
			break;
	}

	$news_query = new WP_Query($args);

	if ($news_query->have_posts()) :
	?>
	<section class="container-1280 bg-base-cream">
		<div class="gl-s128"></div>
		<div class="wrapper has-border-bottom">
			<div class="read-more-block">
				<?php echo !empty($li_nwd_read_more_check)
					? BaseTheme::headline($li_nwd_read_more, 'heading-2 block-title mb-0')
					: '<h2 class="heading-2 block-title mb-0">Read more</h2>'; ?>
				<div class="gl-s52"></div>
				<div class="border-variable-slider">
					<!-- Swiper -->
					<?php
						$total_posts = $news_query->found_posts;
					?>

					<div class="swiper-container read-slide-preview">
						<div class="swiper-wrapper">
							<?php
							while ($news_query->have_posts()) : $news_query->the_post();
								$post_id    = get_the_ID();
								$title      = html_entity_decode(get_the_title());
								$permalink  = get_permalink();
								$short_Desc = ! empty( get_the_excerpt() )  ? get_the_excerpt() : apply_filters( 'the_content', get_the_content() );
   								$excerpt = wp_trim_words($short_Desc, 25, '...');
								$terms      = get_the_terms($post_id, 'learn-type');
								$term_name  = (!empty($terms) && !is_wp_error($terms)) ? esc_html($terms[0]->name) : '';
								$thumbnail_id = get_post_thumbnail_id($post_id) ?: $bst_var_theme_default_image;
								$youtube_url = get_field('li_nwd_video_url', $post_id);
								$li_nwd_date = get_field('li_nwd_date', $post_id);
							?>
								<div class="swiper-slide">
									<div class="image-card-caption">
										<a href="<?php echo esc_url($permalink); ?>" class="caption-card-link">
											<div class="image tag-show">
												<?php if ( ! empty( $li_nwd_date ) ) : ?>
													<div class="tag-date"><div class="block-content eyebrow ui-eyebrow-16-15-regular"><?php echo esc_html( $li_nwd_date ); ?></div></div>
												<?php endif; ?>
												<?php
												if (has_post_thumbnail($post_id)) {
													echo wp_get_attachment_image(get_post_thumbnail_id($post_id), 'thumb_800');
												} elseif (!empty($youtube_url)) {
													preg_match(
														'%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i',
														$youtube_url,
														$matches
													);
													if (!empty($matches[1])) {
														$video_id = $matches[1];
														echo '<img src="' . esc_url('https://img.youtube.com/vi/' . $video_id . '/maxresdefault.jpg') . '" alt="' . esc_attr($title) . '" width="800" height="800" />';
													} else {
														echo '<img src="' . esc_url(wp_get_attachment_image_url(BASETHEME_DEFAULT_IMAGE, 'full')) . '" alt="Default thumbnail" width="800" height="800" />';
													}
												} else {
													echo '<img src="' . esc_url(wp_get_attachment_image_url(BASETHEME_DEFAULT_IMAGE, 'full')) . '" alt="Default thumbnail" width="800" height="800" />';
												}
												?>
											</div>
											<div class="caption-card-content">
												<div class="gl-s52"></div>
												<?php echo !empty($term_name) ? '<div class="eyebrow ui-eyebrow-16-15-regular">' . $term_name . '</div>' : ''; ?>
												<?php echo (!empty($term_name) && !empty($title)) ? '<div class="gl-s6"></div>' : ''; ?>
												<?php echo !empty($title) ? '<div class="card-title heading-7">' . $title . '</div>' : ''; ?>
												<?php echo (!empty($title) && !empty($excerpt)) ? '<div class="gl-s12"></div>' : ''; ?>
												<?php echo !empty($excerpt) ? '<div class="description ui-18-16-regular">' . html_entity_decode($excerpt) . '</div>' : ''; ?>
												<?php echo !empty($excerpt) ? '<div class="gl-s20"></div>' : ''; ?>
												<div class="read-more-link">
													<div class="border-text-btn">Read more</div>
												</div>
												<div class="gl-s80"></div>
											</div>
										</a>
									</div>
								</div>
							<?php endwhile; wp_reset_postdata(); ?>
						</div>
					</div>
					<?php if($total_posts > 3): ?>
						<div class="gl-s44"></div>
						<div class="slider-btn">
							<div class="swiper-button-prev" role="button" tabindex="0" aria-label="Previous slide"></div>
							<div class="swiper-button-next" role="button" tabindex="0" aria-label="Next slide"></div>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</section>
<?php endif; ?>

<?php if ($newsletter_form_visible): ?>
	<section class="container-720 bg-butter-yellow">
		<div class="gl-s156"></div>
		<div class="wrapper">
			<div class="newsletter-block">
				<div class="block-row">
					<?php echo !empty($li_nwd_kicker) ? '<div class="ui-eyebrow-18-16-regular sub-head">' . esc_html($li_nwd_kicker) . '</div>' : ''; ?>	
					<?php echo (!empty($li_nwd_kicker) && !empty($li_nwd_title)) ? '<div class="gl-s12"></div>' : ''; ?>
					<?php echo !empty($li_nwd_title) ? '<h2 class="heading-2 mb-0 block-title">' . esc_html($li_nwd_title) . '</h2>' : ''; ?>	
					<?php echo (!empty($li_nwd_title) && !empty($form_selector)) ? '<div class="gl-s44"></div>' : ''; ?>
					<div class="newsletter-form">
						<?php echo !empty($form_selector) ? do_shortcode('[gravityform id="' . $form_selector . '" title="false" ajax="true" tabindex="0"]') : ''; ?>
					</div>
					<div class="gl-s80"></div>
				</div>
			</div>
		</div>
		<div class="gl-s128"></div>
	</section>
<?php endif; ?>

<?php get_footer(); ?>