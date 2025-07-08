<?php
/**
 * Template part for displaying single post
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Base Theme Package
 * @since 1.0.0
 */

list( $bst_var_post_id, $bst_fields, $bst_option_fields, $bst_queried_object ) = BaseTheme::defaults();

// Post Tags & Categories.
$bst_var_post_categories = get_the_category( $bst_var_post_id );

$bst_var_posttitle = $bst_fields['bst_var_posttitle'] ?? get_the_title();
$li_ldo_author = $bst_fields['li_ldo_author'];
$li_ldo_author_name = $bst_fields['li_ldo_author_name'];
$li_ldo_publication = $bst_fields['li_ldo_publication'];
$li_ldo_publication_link = $bst_fields['li_ldo_publication_link'];
$url = $li_ldo_publication_link['url'];
$title = $li_ldo_publication_link['title'];
$li_ido_read_more = $bst_fields['li_ido_read_more'];
$li_ido_read_more_check = BaseTheme::headline_check($li_ido_read_more);
$li_ido_relatedselected_post = $bst_fields['li_ido_relatedselected_post'] ?? 'recent';
$li_ido_select_posts = $bst_fields['li_ido_select_posts'] ?? null;

$bst_var_title  = $bst_option_fields['bst_var_title'] ?? null;
$bst_var_kicker   = $bst_option_fields['bst_var_kicker'] ?? null;
$bst_var_form_selector = $bst_option_fields['bst_var_form_selector'] ?? null;

$newsletter_form_visible = array_key_exists('li_ldo_newsletter_form_visible', $bst_fields)
    ? (bool) $bst_fields['li_ldo_newsletter_form_visible']
    : true;
$li_ldo_title = $bst_fields['li_ldo_title'] ?? $bst_var_title;
$li_ldo_kicker = $bst_fields['li_ldo_kicker'] ?? $bst_var_kicker;
$form_selector = $bst_fields['li_ldo_form_selector'] ?? $bst_var_form_selector;
?>

<section id="hero-section" class="hero-section hero-section-default hero-alongside-menu variation-width variation-details">
	<!-- hero start -->
	<div class="bg-pattern">
		<img src="https://landinstdev.wpenginepowered.com/wp-content/uploads/2025/05/tli-pattern-successionpink-large.png"
			width="" height="" alt="" />
	</div>
	<div class="hero-default has-border-bottom">
		<div class="wrapper">
			<div class="hero-alongside-block">
				<div class="col-left bg-lime-green">
					<div class="hero-content">
						<?php echo !empty($bst_var_post_categories) ? '<div class="ui-eyebrow-20-18-regular sub-title">' . esc_html($bst_var_post_categories[0]->name) . '</div>' : ''; ?>
						<div class="gl-s20"></div>
						<h3 class="heading-3 mb-0 block-title"><?php echo $bst_var_posttitle ?>
						</h3>
						<div class="gl-s30"></div>
						<div class="ui-eyebrow-16-15-regular eybrow-title"><?php echo $li_ldo_author; ?></div>
						<div class="gl-s6"></div>
						<div class="block-content body-18-16-regular">
							<?php echo !empty($li_ldo_author_name) ? $li_ldo_author_name : get_the_author(); ?>
						</div>
						<div class="gl-s36"></div>
						<div class="ui-eyebrow-16-15-bold eybrow-title"><?php echo $li_ldo_publication; ?></div>
						<div class="gl-s6"></div>
						<div class="text-link">
							<a href="<?php echo esc_url($url); ?>" class="link-with-icon">
								<span class="link-content">
									<?php echo $title; ?><span class="icon">
										<img
											class="" src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/src/images/send-icon.svg" width=""
											height="" alt="" /></span></span>
							</a>
						</div>	
						<div class="gl-s96"></div>
					</div>
				</div>
				<div class="col-right">
					<div class="bg-pattern">
						<img src="https://landinstdev.wpenginepowered.com/wp-content/uploads/2025/05/tli-pattern-successionpink-large.png"
							width="" height="" alt="" />
					</div>
					<?php echo has_post_thumbnail() ? '<div class="block-image-center">' . get_the_post_thumbnail(get_the_ID(), 'thumb_500', ['alt' => get_the_title()]) . '</div>' : ''; ?>
				</div>
			</div>
		</div>
	</div>
</section>

<?php the_content(); ?>

<section class="container-1280 bg-base-cream">
	<div class="gl-s128"></div>
	<div class="wrapper">
		<div class="read-more-block has-border-bottom">
			<?php echo !empty($li_ido_read_more_check) ? BaseTheme::headline($li_ido_read_more, 'heading-2 block-title mb-0') : ''; ?>
			<div class="gl-s52"></div>
			<div class="border-variable-slider">
				<!-- Swiper -->
				<div class="swiper-container read-slide-preview cursor-drag-icon">
					<div class="swiper-wrapper">
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
								$categories = get_the_category($bst_var_post_id);
								if (!empty($categories)) {
									$category_ids = wp_list_pluck($categories, 'term_id');
									$args['category__in'] = $category_ids;
									$args['post__not_in'] = [$bst_var_post_id];
								} else {
									$args['post__in'] = [0]; // fallback: show nothing
								}
								break;
						}

						$posts_query = new WP_Query($args);

						while ($posts_query->have_posts()) : $posts_query->the_post();
							$post_id    = get_the_ID();
							$title      = get_the_title();
							$permalink  = get_permalink();
							$excerpt    = get_the_excerpt($post_id);
							$categories = get_the_category($post_id);
							$cat_name   = !empty($categories) ? esc_html($categories[0]->name) : '';
							?>
							<div class="swiper-slide">
								<div class="image-card-caption">
									<a href="<?php echo esc_url($permalink); ?>" class="caption-card-link">
										<div class="image">
											<?php echo wp_get_attachment_image(get_post_thumbnail_id($post_id), 'thumb_800'); ?>
										</div>
										<div class="caption-card-content">
											<div class="gl-s52"></div>
											<?php echo !empty($cat_name) ? '<div class="eyebrow ui-eyebrow-16-15-regular">' . $cat_name . '</div>' : ''; ?>
											<?php echo (!empty($cat_name) && !empty($title)) ? '<div class="gl-s6"></div>' : ''; ?>
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