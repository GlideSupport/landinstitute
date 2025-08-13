<?php

/**
 * The template for displaying all posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Base Theme Package
 * @since 1.0.0
 */

// Include header.
get_header();

list($bst_var_post_id, $bst_fields, $bst_option_fields, $bst_queried_object) = BaseTheme::defaults();

$bst_var_learn_bg_pattern = $bst_option_fields['bst_var_learn_bg_pattern'] ?? null;
$bst_var_dl_headline = $bst_option_fields['bst_var_dl_headline'] ?? null;
$bst_var_dl_repeater = $bst_option_fields['bst_var_dl_repeater'] ?? null;
$bst_var_dl_image = $bst_option_fields['bst_var_dl_image'] ?? null;
$bst_var_tf_title = $bst_option_fields['bst_var_tf_title'] ?? null;
$bst_var_tf_kicker = $bst_option_fields['bst_var_tf_kicker'] ?? null;
$bst_var_tf_form_selector = $bst_option_fields['bst_var_tf_form_selector'] ?? null;

// Get visible taxonomies from options
$show_learn_taxonomies_in_the_filter = $bst_option_fields['show_learn_taxonomies_in_the_filter'] ?? [];
$show_news_taxonomies_in_the_filter = $bst_option_fields['show_news_taxonomies_in_the_filter'] ?? [];

// Define all possible taxonomies
$all_learn_taxonomies = ['learn-type', 'learn-topic', 'learn-crop', 'learn-audience'];
$all_news_taxonomies = ['news-type', 'news-topic', 'news-crop', 'news-audience'];

// Filter to only include taxonomies that should be visible
$visible_learn_taxonomies = array_intersect($all_learn_taxonomies, $show_learn_taxonomies_in_the_filter);
$visible_news_taxonomies = array_intersect($all_news_taxonomies, $show_news_taxonomies_in_the_filter);

?>
<main id="main-section" class="main-section">
	<div class="page-section">
		<section id="hero-section" class="hero-section hero-section-default hero-alongside-menu">
			<!-- Hero Start -->
			<?php echo !empty($bst_var_learn_bg_pattern) ? '<div class="bg-pattern">' . wp_get_attachment_image($bst_var_learn_bg_pattern, 'thumb_1600') . '</div>' : ''; ?>
			<div class="hero-default">
				<div class="wrapper">
					<div class="hero-alongside-block">
						<div class="col-left bg-lime-green">
							<div class="hero-content">
								<h1 class="heading-1 mb-0 block-title"><?php single_cat_title(); ?></h1>
								<div class="gl-s30"></div>
								<div class="hero-content body-20-18-regular">
									<?php echo category_description(); ?>
								</div>
								<div class="gl-s96"></div>
							</div>
						</div>
						<div class="col-right">
							<?php echo !empty($bst_var_learn_bg_pattern) ? '<div class="bg-pattern">' . wp_get_attachment_image($bst_var_learn_bg_pattern, 'thumb_1600') . '</div>' : ''; ?>
						</div>
					</div>
				</div>
			</div>
		</section>

		<?php
		// Check if current taxonomy belongs to either visible group
		if (
			in_array($bst_queried_object->taxonomy, $visible_learn_taxonomies) ||
			in_array($bst_queried_object->taxonomy, $visible_news_taxonomies)
		) :

			$is_learn = in_array($bst_queried_object->taxonomy, $visible_learn_taxonomies);
			$prefix = $is_learn ? 'learn' : 'news';
			$base_url = $is_learn ? '/learn/' : '/news/';
			$visible_taxonomies = $is_learn ? $visible_learn_taxonomies : $visible_news_taxonomies;

			// Get all terms for each visible taxonomy, excluding specified terms
			$taxonomy_terms = [];
			foreach ($visible_taxonomies as $tax) {
				$exclude_slugs = get_excluded_term_slugs_by_taxonomy($tax);
				$args = [
					'taxonomy'   => $tax,
					'hide_empty' => true,
				];

				// If we have slugs to exclude, we'll need to get all terms first then filter
				$terms = get_terms($args);

				if (!is_wp_error($terms)) {
					// Filter out excluded terms by slug
					if (!empty($exclude_slugs) && is_array($exclude_slugs)) {
						$terms = array_filter($terms, function ($term) use ($exclude_slugs) {
							return !in_array($term->slug, $exclude_slugs);
						});
					}
					$taxonomy_terms[$tax] = $terms;
				}
			}

			// Set current names for display
			$current_names = [];
			$label_mapping = [
				'type' => 'Types',
				'topic' => 'Topics',
				'crop' => 'Crops',
				'audience' => 'Audience'
			];

			foreach ($visible_taxonomies as $tax) {
				$key = str_replace("$prefix-", '', $tax);
				$current_names[$key] = ($bst_queried_object->taxonomy == $tax) ? $bst_queried_object->name : 'All ' . $label_mapping[$key];
			}
		?>
			<div class="filter-block">
				<div class="filter">
					<div class="filter-title ui-18-16-bold">Filter:</div>
					<div class="md-mobile-filter-main">
						<div class="filter-mobile-dropdown icon-add ui-18-16-bold">Show Filter</div>
						<div class="filter-dropdown-row">
							<?php
							// Generate filter buttons only for visible taxonomies
							foreach ($visible_taxonomies as $tax) :
								$key = str_replace("$prefix-", '', $tax);
							?>
								<div class="tab-dropdown tab-dropdown-filter">
									<button class="dropdown-toggle" id="<?php echo $key; ?>-view" aria-expanded="false"
										aria-haspopup="true" aria-controls="<?php echo $tax; ?>">
										<?php echo $label_mapping[$key]; ?>: <?php echo $current_names[$key]; ?>
										<div class="arrow-icon"></div>
									</button>
								</div>
							<?php endforeach; ?>
						</div>
					</div>
				</div>
			</div>

			<div class="learn-list-filter md-mobile-filter">
				<?php
				// Generate dropdown menus for each visible taxonomy
				foreach ($visible_taxonomies as $tax) :
					$key = str_replace("$prefix-", '', $tax);
				?>
					<ul id="<?php echo $tax; ?>" class="dropdown-menu" role="menu" aria-labelledby="<?php echo $key; ?>-view">
						<li><a href="<?php echo $base_url; ?>" data-taxonomy="<?php echo $tax; ?>">All <?php echo $label_mapping[$key]; ?></a></li>
						<?php if (!empty($taxonomy_terms[$tax])) : ?>
							<?php foreach ($taxonomy_terms[$tax] as $term) : ?>
								<li>
									<a href="<?php echo esc_url(get_term_link((int) $term->term_id, $term->taxonomy)); ?>"
										data-taxonomy="<?php echo esc_attr($term->taxonomy); ?>">
										<?php echo esc_html($term->name); ?>
									</a>
								</li>
							<?php endforeach; ?>
						<?php endif; ?>
					</ul>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

		<section class="container-1280 bg-base-cream">
			<div class="wrapper">
				<div class="resoruce-filter-title full-width-content has-border-bottom">
					<div class="filter-block fixed-category">
						<!-- Dynamic Post Cards Start -->
						<div class="filter-cards-grid">
							<?php if (have_posts()) : ?>
								<?php while (have_posts()) : the_post();
									$youtube_url = get_field('li_ldo_youtube_url', get_the_ID()); ?>
									<div class="filter-card-item">
										<a href="<?php the_permalink(); ?>" class="filter-card-link">
											<div class="image">
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
												<div class="eyebrow ui-eyebrow-16-15-regular">
													<?php
													$learn_types = get_the_terms(get_the_ID(), 'learn-type');
													if ($learn_types && !is_wp_error($learn_types)) {
														echo esc_html($learn_types[0]->name);
													}
													?>
												</div>
												<div class="gl-s6"></div>
												<div class="card-title heading-7"><?php echo html_entity_decode(get_the_title()); ?></div>
												<div class="gl-s12"></div>
												<div class="description ui-18-16-regular"><?php echo wp_trim_words(get_the_excerpt(), 35); ?></div>
												<div class="gl-s20"></div>
												<div class="read-more-link">
													<div class="border-text-btn">Read more</div>
												</div>
												<div class="gl-s80"></div>
											</div>
										</a>
									</div>
								<?php endwhile; ?>
							<?php else : ?>
							<?php endif; ?>
						</div>
						<?php if (!have_posts()) : ?>
							<div class="not-found-append">
								<div class="not-found-block">
									<div class="not-found">
										<?php
										$term_name = single_term_title('', false);
										?>
										No Resources found in the <span class="category-name"><?php echo esc_html($term_name); ?></span> category.

									</div>
								</div>
							</div>

						<?php endif; ?>



						<!-- Pagination -->
						<div class="fillter-bottom">
							<?php BaseTheme::pagination(); ?>
						</div>

					</div>
				</div>
			</div>
		</section>
		<section class="container-1280 bg-base-cream">
			<div class="wrapper">
				<div class="download-list sticky-lft-block variation-2 has-border-bottom">
					<div class="row-flex">
						<?php echo !empty($bst_var_dl_image) ? '<div class="col-left sticky-img "><div class="sticky-image-stick">' . wp_get_attachment_image($bst_var_dl_image, 'thumb_1200') . '</div></div>' : ''; ?>
						<div class="cl-right">
							<div class="gl-s156"></div>
							<?php echo !empty($bst_var_dl_headline) ? '<h2 class="heading-2 block-title mb-0">' . esc_html($bst_var_dl_headline) . '</h2>' : ''; ?>
							<?php echo (!empty($bst_var_dl_headline) && !empty($bst_var_dl_repeater)) ? '<div class="gl-s12"></div>' : ''; ?>
							<?php if (!empty($bst_var_dl_repeater)) : ?>
								<div class="card-list">
									<?php foreach ($bst_var_dl_repeater as $bst_var_dl_rep) :
										$title = $bst_var_dl_rep['title'] ?? '';
										$wysiwyg = $bst_var_dl_rep['wysiwyg'] ?? '';
										$link = $bst_var_dl_rep['link'] ?? null;

										$link_url = $link['url'] ?? '';
										$link_title = $link['title'] ?? '';
										$link_target = $link['target'] ?? '_self';

										if (!empty($title) || !empty($wysiwyg) || !empty($link)): ?>
											<?php echo !empty($link_url) ? '<a href="' . esc_url($link_url) . '" target="' . esc_attr($link_target) . '" class="card-item link-with-title with-arrow">' : '<div class="card-item link-with-title with-arrow">'; ?>
											<?php if (!empty($title) || !empty($wysiwyg)): ?>
												<div class="card-item-left">
													<?php echo !empty($title) ? '<div class="card-title ui-24-21-bold" role="heading">' . esc_html($title) . '</div>' : ''; ?>
													<?php echo (!empty($title) && !empty($wysiwyg)) ? '<div class="gl-s4"></div>' : ''; ?>
													<?php echo !empty($wysiwyg) ? '<div class="card-content body-18-16-regular">' . html_entity_decode($wysiwyg) . '</div>' : ''; ?>
												</div>
											<?php endif; ?>
											<?php if (!empty($link_url)) : ?>
												<div class="card-item-right">
													<div class="dot-btn">
														<img src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/src/images/right-circle-arrow.svg" title="right-circle-arrow" alt="right-circle-arrow">
													</div>
												</div>
											<?php endif; ?>
											<?php echo !empty($link) ? '</a>' : '</div>'; ?>
									<?php endif;
									endforeach; ?>
								</div>
							<?php endif; ?>
							<div class="gl-s156"></div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<section class="container-720 bg-butter-yellow">
			<div class="gl-s156"></div>
			<div class="wrapper">
				<div class="newsletter-block">
					<div class="block-row">
						<?php echo !empty($bst_var_tf_kicker) ? '<div class="ui-eyebrow-18-16-regular sub-head">' . esc_html($bst_var_tf_kicker) . '</div>' : ''; ?>
						<?php echo (!empty($bst_var_tf_kicker) && !empty($bst_var_tf_title)) ? '<div class="gl-s12"></div>' : ''; ?>
						<?php echo !empty($bst_var_tf_title) ? '<h2 class="heading-2 mb-0 block-title">' . esc_html($bst_var_tf_title) . '</h2>' : ''; ?>
						<div class="gl-s44"></div>
						<div class="newsletter-form">
							<?php echo !empty($bst_var_tf_form_selector) ? do_shortcode('[gravityform id="' . $bst_var_tf_form_selector . '" title="false" ajax="true" tabindex="0"]') : ''; ?>
						</div>
						<div class="gl-s80"></div>
					</div>
				</div>
			</div>
			<div class="gl-s128"></div>
		</section>
	</div>
</main>

<?php get_footer(); ?>