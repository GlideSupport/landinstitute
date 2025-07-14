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
$featured_image_html = wp_get_attachment_image($featured_image_id, 'thumb_500', false, ['alt' => esc_attr(get_the_title())]);

$bst_var_posttitle = $bst_fields['bst_var_posttitle'] ?? get_the_title();
$li_nwd_authors = $bst_fields['li_nwd_authors'] ?? '';
$li_nwd_publication = $bst_fields['li_nwd_publication'] ?? '';
$bg_pattern = $bst_fields['li_nwd_background_pattern'] ??  $bst_option_fields['li_news_list_detail_page_bg_pattern'];
$li_nwd_read_more = $bst_fields['li_nwd_read_more'] ?? '';
$li_nwd_read_more_check = BaseTheme::headline_check($li_nwd_read_more);
$li_nwd_relatedselected_post = $bst_fields['li_nwd_relatedselected_post'] ?? 'related';
$li_nwd_select_news = $bst_fields['li_nwd_select_news'] ?? null;

$bst_var_title  = $bst_option_fields['bst_var_title'] ?? null;
$bst_var_kicker   = $bst_option_fields['bst_var_kicker'] ?? null;
$bst_var_form_selector = $bst_option_fields['bst_var_form_selector'] ?? null;

$li_no_bg_image_visible = is_array($bst_fields) && array_key_exists('li_no_bg_image_visible', $bst_fields) ? (bool) $bst_fields['li_no_bg_image_visible'] : true;
$li_no_bg_image = $bst_fields['li_no_bg_image'] ?? $bst_option_fields['li_to_select_default_background_pattern'];

$newsletter_form_visible = array_key_exists('li_nwd_newsletter_form_visible', $bst_fields) ? (bool) $bst_fields['li_nwd_newsletter_form_visible'] : true;
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
							<h3 class="heading-3 mb-0 block-title"><?php echo esc_html($bst_var_posttitle); ?></h3>
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
								<?php echo !empty($li_nwd_publication) ? '<div class="body-18-16-regular block-content">' . esc_html($li_nwd_publication) . '</div>' : ''; ?>
							</div>
						</div>
						<div class="gl-s96"></div>
					</div>
				<?php else : ?>
					<div class="col-left bg-lime-green">
						<div class="hero-content">
						<?php echo !empty($news_type_name) ? '<div class="ui-eyebrow-20-18-regular sub-title">' . $news_type_name . '</div>' : ''; ?>
							<div class="gl-s20"></div>
							<h3 class="heading-3 mb-0 block-title"><?php echo esc_html($bst_var_posttitle); ?></h3>
							<?php echo (!empty($li_nwd_authors) || !empty($li_nwd_publication)) ? '<div class="gl-s30"></div>' : ''; ?>
							<?php echo !empty($li_nwd_authors) ? '<div class="ui-eyebrow-16-15-bold eybrow-title">Author</div>' : ''; ?>
							<?php echo !empty($li_nwd_authors) ? '<div class="gl-s6"></div>' : ''; ?>
							<?php echo !empty($li_nwd_authors) ? '<div class="block-content body-18-16-regular">' . $li_nwd_authors . '</div>' : ''; ?>
							<div class="gl-s36"></div>
							<?php echo !empty($li_nwd_publication) ? '<div class="ui-eyebrow-16-15-bold eybrow-title">Publications (DOI)</div>' : ''; ?>
							<?php echo !empty($li_nwd_publication) ? '<div class="gl-s6"></div>' : ''; ?>
								<?php echo !empty($li_nwd_publication) ? '<div class="body-18-16-regular block-content">' . esc_html($li_nwd_publication) . '</div>' : ''; ?>
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

<section class="container-720 bg-base-cream">
	<div class="wrapper">
		<div class="gl-s96"></div>
			<?php the_content(); ?>
		<div class="gl-s64"></div>
	</div>
</section>	

<?php if ($li_no_bg_image_visible): ?>
	<section class="container-1280 ">
		<div class="wrapper">
			<div class="bg-pattern-fixed has-border-bottom">
				<?php echo !empty($li_no_bg_image) ? ' <div class="bg-pattern-fixed">' . wp_get_attachment_image($li_no_bg_image, 'thumb_2000') . '</div>' : ''; ?>
			</div>
		</div>
	</section>
<?php endif; ?>

<section class="container-1280 bg-base-cream">
	<div class="gl-s128"></div>
	<div class="wrapper">
		<div class="read-more-block">
			<?php echo !empty($li_nwd_read_more_check) ? BaseTheme::headline($li_nwd_read_more, 'heading-2 block-title mb-0') : '<h2 class="heading-2 block-title mb-0">Read more</h2>'; ?>
			<div class="gl-s52"></div>
			<div class="border-variable-slider">
				<!-- Swiper -->
				<div class="swiper-container read-slide-preview cursor-drag-icon">
					<div class="swiper-wrapper">
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

						while ($news_query->have_posts()) : $news_query->the_post();
							$post_id    = get_the_ID();
							$title      = get_the_title();
							$permalink  = get_permalink();
							$excerpt    = get_the_excerpt($post_id);
							$terms = get_the_terms($post_id, 'learn-type');
							$term_name = (!empty($terms) && !is_wp_error($terms)) ? esc_html($terms[0]->name) : '';
							$thumbnail_id = get_post_thumbnail_id($post_id);
							$thumbnail_id = $thumbnail_id ? $thumbnail_id : $bst_var_theme_default_image;
							?>
							<div class="swiper-slide">
								<div class="image-card-caption">
									<a href="<?php echo esc_url($permalink); ?>" class="caption-card-link">
										<div class="image">
											<?php echo wp_get_attachment_image($thumbnail_id, 'thumb_800');	?>						
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
						<?php endwhile; wp_reset_postdata(); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>


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