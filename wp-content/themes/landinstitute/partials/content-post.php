<?php

/**
 * Template part for displaying single post
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Base Theme Package
 * @since 1.0.0
 */

list($bst_var_post_id, $bst_fields, $bst_option_fields, $bst_queried_object) = BaseTheme::defaults();

// Post Tags & Categories.
$learn_type_terms = get_the_terms($bst_var_post_id, 'learn-type');
$learn_type_name = !empty($learn_type_terms) && !is_wp_error($learn_type_terms) ? esc_html($learn_type_terms[0]->name) : '';
$bst_var_theme_default_image = $bst_option_fields['bst_var_theme_default_image'] ?? null;
$featured_image_id = get_post_thumbnail_id();
$featured_image_id = $featured_image_id ? $featured_image_id : $bst_var_theme_default_image;
$featured_image_html = wp_get_attachment_image($featured_image_id, 'thumb_500', false, ['alt' => esc_attr(get_the_title())]);

$bst_var_posttitle = $bst_fields['bst_var_posttitle'] ?? get_the_title();
$li_ldo_authors = $bst_fields['li_ldo_authors'];
$li_ldo_publication = $bst_fields['li_ldo_publication'];

$select_type = $bst_fields['select_type'] ?? 'audio';
$li_ldo_youtube_url = $bst_fields['li_ldo_youtube_url'];
$li_ldo_soundcloud_url = $bst_fields['li_ldo_soundcloud_url'];

$li_ido_pdf_uploadpdf_url = $bst_fields['li_ido_pdf_uploadpdf_url'] ?? 'upload';
$li_ldo_upload = $bst_fields['li_ldo_pdf'];
$li_ldo_url = $bst_fields['li_ldo_url'];
$link = ($li_ido_pdf_uploadpdf_url === 'upload' && !empty($li_ldo_upload)) ? $li_ldo_upload : (($li_ido_pdf_uploadpdf_url === 'url' && !empty($li_ldo_url)) ? $li_ldo_url : '');

$bg_pattern = $bst_fields['li_ldo_background_pattern'] ??  $bst_option_fields['li_learn_detail_page_bg_pattern'];
$li_ido_read_more = $bst_fields['li_ido_read_more'];
$li_ido_read_more_check = BaseTheme::headline_check($li_ido_read_more);
$li_ido_relatedselected_post = $bst_fields['li_ido_relatedselected_post'] ?? 'related';
$li_ido_select_posts = $bst_fields['li_ido_select_posts'] ?? null;

$bst_var_title  = $bst_option_fields['bst_var_title'] ?? null;
$bst_var_kicker   = $bst_option_fields['bst_var_kicker'] ?? null;
$bst_var_form_selector = $bst_option_fields['bst_var_form_selector'] ?? null;

$li_po_bg_image_visible = array_key_exists('li_po_bg_image_visible', $bst_fields) ? (bool) $bst_fields['li_po_bg_image_visible'] : true;
$li_po_bg_image = $bst_fields['li_po_bg_image'] ?? $bst_option_fields['li_to_select_default_background_pattern'];

$newsletter_form_visible = array_key_exists('li_ldo_newsletter_form_visible', $bst_fields) ? (bool) $bst_fields['li_ldo_newsletter_form_visible'] : true;
$li_ldo_title = $bst_fields['li_ldo_title'] ?? $bst_var_title;
$li_ldo_kicker = $bst_fields['li_ldo_kicker'] ?? $bst_var_kicker;
$form_selector = $bst_fields['li_ldo_form_selector'] ?? $bst_var_form_selector;

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
							<?php echo !empty($learn_type_name) ? '<div class="ui-eyebrow-20-18-regular sub-title">' . $learn_type_name . '</div>' : ''; ?>
							<div class="gl-s20"></div>
							<h3 class="heading-3 mb-0 block-title"><?php echo esc_html($bst_var_posttitle); ?></h3>
							<?php echo (!empty($li_ldo_authors) || !empty($li_ldo_publication)) ? '<div class="gl-s44"></div>' : ''; ?>
						</div>
						<div class="col-content-row d-flex">
							<div class="column-content">
								<?php echo !empty($li_ldo_authors) ? '<div class="ui-eyebrow-16-15-bold eybrow-title">Author</div>' : ''; ?>
								<?php echo !empty($li_ldo_authors) ? '<div class="gl-s6"></div>' : ''; ?>
								<?php echo !empty($li_ldo_authors) ? '<div class="block-content body-18-16-regular">' . $li_ldo_authors . '</div>' : ''; ?>
							</div>
							<div class="column-content">
								<?php echo !empty($li_ldo_publication) ? '<div class="ui-eyebrow-16-15-bold eybrow-title">Publication</div>' : ''; ?>
								<?php echo !empty($li_ldo_publication) ? '<div class="gl-s6"></div>' : ''; ?>
								<?php if (!empty($link)) : ?>
									<a href="<?php echo esc_url($link); ?>" class="link-with-icon" target="_blank" rel="noopener">
										<span class="link-content">
											<?php echo esc_html($li_ldo_publication); ?>
											<span class="icon">
												<img src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/src/images/send-icon.svg" alt="" />
											</span>
										</span>
									</a>
								<?php elseif (!empty($li_ldo_publication)) : ?>
									<div class="body-18-16-regular block-content">
										<?php echo esc_html($li_ldo_publication); ?>
									</div>
								<?php endif; ?>
							</div>
						</div>
						<div class="gl-s96"></div>
					</div>
				<?php else : ?>
					<div class="col-left bg-lime-green">
						<div class="hero-content">
							<?php echo !empty($learn_type_name) ? '<div class="ui-eyebrow-20-18-regular sub-title">' . $learn_type_name . '</div>' : ''; ?>
							<div class="gl-s20"></div>
							<h3 class="heading-3 mb-0 block-title"><?php echo esc_html($bst_var_posttitle); ?></h3>
							<?php echo (!empty($li_ldo_authors) || !empty($li_ldo_publication)) ? '<div class="gl-s30"></div>' : ''; ?>
							<?php echo !empty($li_ldo_authors) ? '<div class="ui-eyebrow-16-15-bold eybrow-title">Author</div>' : ''; ?>
							<?php echo !empty($li_ldo_authors) ? '<div class="gl-s6"></div>' : ''; ?>
							<?php echo !empty($li_ldo_authors) ? '<div class="block-content body-18-16-regular">' . $li_ldo_authors . '</div>' : ''; ?>
							<div class="gl-s36"></div>
							<?php echo !empty($li_ldo_publication) ? '<div class="ui-eyebrow-16-15-bold eybrow-title">Publications (DOI)</div>' : ''; ?>
							<?php echo !empty($li_ldo_publication) ? '<div class="gl-s6"></div>' : ''; ?>
							<?php if (!empty($link)) : ?>
								<a href="<?php echo esc_url($link); ?>" class="link-with-icon" target="_blank" rel="noopener">
									<span class="link-content">
										<?php echo esc_html($li_ldo_publication); ?>
										<span class="icon">
											<img src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/src/images/send-icon.svg" alt="" />
										</span>
									</span>
								</a>
							<?php elseif (!empty($li_ldo_publication)) : ?>
								<div class="body-18-16-regular block-content">
									<?php echo esc_html($li_ldo_publication); ?>
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
			$type            = $bst_fields['select_type'] ?? '';
			$youtube_url     = $bst_fields['li_ldo_youtube_url'] ?? '';
			$soundcloud_url  = $bst_fields['li_ldo_soundcloud_url'] ?? '';

			echo '<div class="single-audio-video-embed">';

			if ($type === 'video' && !empty($youtube_url)) {
				echo '<div class="gl-s64"></div>';
				echo '<div itemscope itemtype="http://schema.org/VideoObject">';
				echo wp_oembed_get(esc_url($youtube_url));
				echo '<meta itemprop="uploadDate" content="' . esc_attr(get_the_date('Y-m-d', $bst_var_post_id)) . '" />';
				echo '<meta itemprop="embedURL" content="' . esc_url($youtube_url) . '" />';
				echo '</div>'; // Closing VideoObject div
			} elseif ($type === 'audio' && !empty($soundcloud_url)) {
				echo '<div class="gl-s64"></div>';
				echo wp_oembed_get(esc_url($soundcloud_url));
			}

			echo '</div>'; // Closing single-hero
			?>

			<div class="gl-s64"></div>

			<?php the_content(); ?>

			<div class="gl-s64"></div>
		</div>
	</section>
</section>


<?php if ($li_po_bg_image_visible): ?>
	<section class="container-1280 ">
		<div class="wrapper">
			<div class="bg-pattern-fixed has-border-bottom">
				<?php echo !empty($li_po_bg_image) ? ' <div class="bg-pattern-fixed">' . wp_get_attachment_image($li_po_bg_image, 'thumb_2000') . '</div>' : ''; ?>
			</div>
		</div>
	</section>
<?php endif; ?>

<?php
$args = [
	'post_type'   => 'post',
	'post_status' => 'publish',
];

switch ($li_ido_relatedselected_post) {
	case 'selected':
		if (!empty($li_ido_select_posts)) {
			$args['post__in']  = $li_ido_select_posts;
			$args['orderby']   = 'post__in';
		}
		break;

	case 'related':
		$terms = get_the_terms($bst_var_post_id, 'learn-type');
		if (!empty($terms) && !is_wp_error($terms)) {
			$term_ids = wp_list_pluck($terms, 'term_id');
			$args['tax_query'] = [
				[
					'taxonomy' => 'learn-type',
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

$posts_query = new WP_Query($args);

if ($posts_query->have_posts()) : ?>
	<section class="container-1280 bg-base-cream">
		<div class="gl-s128"></div>
		<div class="wrapper">
			<div class="read-more-block">
				<?php echo !empty($li_ido_read_more_check) ? BaseTheme::headline($li_ido_read_more, 'heading-2 block-title mb-0') : '<h2 class="heading-2 block-title mb-0">Read more</h2>'; ?>
				<div class="gl-s52"></div>
				<div class="border-variable-slider">
					<div class="swiper-container read-slide-preview cursor-drag-icon">
						<div class="swiper-wrapper">
							<?php
							while ($posts_query->have_posts()) : $posts_query->the_post();
								$post_id    = get_the_ID();
								$title      = get_the_title();
								$permalink  = get_permalink();
								$excerpt    = get_the_excerpt($post_id);
								$terms      = get_the_terms($post_id, 'learn-type');
								$term_name  = (!empty($terms) && !is_wp_error($terms)) ? esc_html($terms[0]->name) : '';
								$thumbnail_id = get_post_thumbnail_id($post_id) ?: $bst_var_theme_default_image;
							?>
								<div class="swiper-slide">
									<div class="image-card-caption">
										<a href="<?php echo esc_url($permalink); ?>" class="caption-card-link">
											<div class="image">
												<?php echo wp_get_attachment_image($thumbnail_id, 'thumb_800'); ?>
											</div>
											<div class="caption-card-content">
												<div class="gl-s52"></div>
												<?php echo !empty($term_name) ? '<div class="eyebrow ui-eyebrow-16-15-regular">' . $term_name . '</div>' : ''; ?>
												<?php echo (!empty($term_name) && !empty($title)) ? '<div class="gl-s6"></div>' : ''; ?>
												<?php echo !empty($title) ? '<div class="card-title heading-7">' . esc_html($title) . '</div>' : ''; ?>
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
							<?php endwhile; ?>
							<?php wp_reset_postdata(); ?>
						</div>
					</div>
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
					<?php echo !empty($li_ldo_kicker) ? '<div class="ui-eyebrow-18-16-regular sub-head">' . esc_html($li_ldo_kicker) . '</div>' : ''; ?>
					<?php echo (!empty($li_ldo_kicker) && !empty($li_ldo_title)) ? '<div class="gl-s12"></div>' : ''; ?>
					<?php echo !empty($li_ldo_title) ? '<h2 class="heading-2 mb-0 block-title">' . esc_html($li_ldo_title) . '</h2>' : ''; ?>
					<?php echo (!empty($li_ldo_title) && !empty($form_selector)) ? '<div class="gl-s44"></div>' : ''; ?>
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