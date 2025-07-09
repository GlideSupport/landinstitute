<?php

/**
 * Template Name: Learn
 * Template Post Type: page
 *
 * This template is for displaying News page.
 *
 * @link https://developer.wordpress.org/themes/template-files-section/page-template-files/
 *
 * @package Base Theme Package
 * @since 1.0.0
 */

// Include header.
get_header();
list( $bst_var_post_id, $bst_fields, $bst_option_fields ) = BaseTheme::defaults();

$li_learn_temp_headline_text = $bst_fields['li_learn_temp_headline_text'] ?? null;
$li_learn_headline_check  = BaseTheme::headline_check($li_learn_temp_headline_text);
$li_learn_temp_bg_image = $bst_fields['li_learn_temp_bg_image'] ?? null;

?>

<section id="hero-section" class="hero-section hero-section-default hero-alongside-menu">
	<?php echo !empty($li_learn_temp_bg_image) ? '<div class="bg-pattern">' . wp_get_attachment_image($li_learn_temp_bg_image, 'thumb_900') . '</div>' : ''; ?>
	<div class="hero-default has-border-bottom">
		<div class="wrapper">
			<div class="hero-alongside-block">
				<div class="col-left bg-lime-green">
					<div class="hero-content">
					<?php echo !empty($li_learn_headline_check) ? BaseTheme::headline($li_learn_temp_headline_text, 'heading-1 mb-0 block-title') : ''; ?>
					<div class="gl-s96"></div>
					</div>
				</div>
				<div class="col-right">
					<?php echo !empty($li_learn_temp_bg_image) ? '<div class="bg-pattern">' . wp_get_attachment_image($li_learn_temp_bg_image, 'thumb_1600') . '</div>' : ''; ?>
				</div>
			</div>
		</div>
	</div>
</section>
<section class="container-1280 bg-base-cream">
	<div class="gl-s128"></div>
	<div class="wrapper">
		<div class="resoruce-filter-title full-width-content has-border-bottom">
			<h2 class="heading-2 mb-0 block-title">Resources</h2>
			<div class="gl-s52"></div>
			<div class="filter-block">
					<div class="filter">
						<div class="filter-title ui-18-16-bold">Filter:</div>
						<div class="filter-mobile-dropdown icon-add ui-18-16-bold">Show Filter</div>
						<div class="filter-dropdown-row">
							<div class="tab-dropdown">
								<button class="dropdown-toggle" id="category-view" aria-expanded="false"
									aria-haspopup="true" aria-controls="category-view">Post type: All types<div
										class="arrow-icon"></div>
								</button>
							</div>
							<div class="tab-dropdown">
								<button class="dropdown-toggle" id="category-view" aria-expanded="false"
									aria-haspopup="true" aria-controls="category-view">Topic: All topics<div
										class="arrow-icon"></div>
								</button>
							</div>
							<div class="tab-dropdown">
								<button class="dropdown-toggle" id="category-view" aria-expanded="false"
									aria-haspopup="true" aria-controls="category-view">Crop: All crops<div
										class="arrow-icon"></div>
								</button>
							</div>
						</div>
					</div>

					<!-- PHP Dynamic Loop Start -->
					<div class="filter-cards-grid">
						<?php
						// Set up query
						$paged = get_query_var('paged') ? get_query_var('paged') : 1;
						$args = array(
							'post_type' => 'post',
							'posts_per_page' => 12,
							'paged' => $paged,
						);

						// Taxonomy filters
						$tax_query = array('relation' => 'AND');

						$tax_map = array(
							'learn-type'   => 'learn-type',
							'learn-topic'  => 'learn-topic',
							'learn-crop'   => 'learn-crop',
						);

						foreach ($tax_map as $key => $taxonomy) {
							if (!empty($_GET[$key])) {
								$tax_query[] = array(
									'taxonomy' => $taxonomy,
									'field'    => 'slug',
									'terms'    => sanitize_text_field($_GET[$key]),
								);
							}
						}

						if (count($tax_query) > 1) {
							$args['tax_query'] = $tax_query;
						}

						$query = new WP_Query($args);

						if ($query->have_posts()) :
							while ($query->have_posts()) : $query->the_post();
								$format = get_post_format() ?: 'Publication';
						?>
								<div class="filter-card-item">
									<a href="<?php the_permalink(); ?>" class="filter-card-link">
										<div class="image">
											<?php if (has_post_thumbnail()) : ?>
												<?php echo wp_get_attachment_image(get_post_thumbnail_id($post_id), 'thumb_500'); ?>
											<?php else : ?>
												<img src="<?php echo esc_url(BASETHEME_DEFAULT_IMAGE); ?>" alt="Default thumbnail" width="500" height="300" />
											<?php endif; ?>
										</div>
										<div class="filter-card-content">
											<div class="gl-s52"></div>
											<div class="eyebrow ui-eyebrow-16-15-regular"><?php echo esc_html(ucfirst($format)); ?></div>
											<div class="gl-s6"></div>
											<div class="card-title heading-7"><?php echo get_the_title(); ?></div>
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
							<p>No resources found.</p>
						<?php endif;
						wp_reset_postdata(); ?>
					</div>

					<!-- Pagination -->
					<div class="fillter-bottom">
						<div class="pagination-container">
							<div class="desktop-pages">
								<div class="arrow-btn prev">
									<?php previous_posts_link('<div class="site-btn">Previous</div>', $query->max_num_pages); ?>
								</div>
								<div class="pagination-list">
									<?php
									echo paginate_links(array(
										'total' => $query->max_num_pages,
										'current' => $paged,
										'type' => 'list',
										'before_page_number' => '<button class="page-btn">',
										'after_page_number' => '</button>',
									));
									?>
								</div>
								<div class="arrow-btn next">
									<?php next_posts_link('<div class="site-btn">Next</div>', $query->max_num_pages); ?>
								</div>
							</div>

							<!-- Mobile Pagination -->
							<div class="mobile-pagination">
								<button id="prevBtn" class="arrow-btn"><?php previous_posts_link('<img src="../assets/src/images/right-circle-arrow.svg" />', $query->max_num_pages); ?></button>
								<button id="pageTrigger" class="page-trigger ui-18-16-bold"><?php echo $paged . '/' . $query->max_num_pages; ?></button>
								<button id="nextBtn" class="arrow-btn"><?php next_posts_link('<img src="../assets/src/images/right-circle-arrow.svg" />', $query->max_num_pages); ?></button>
							</div>

							<!-- Mobile Popup -->
							<div id="paginationPopup" class="pagination-popup">
								<div class="popup-body">
									<div id="popupGrid" class="popup-grid">
										<?php for ($i = 1; $i <= $query->max_num_pages; $i++) : ?>
											<a href="<?php echo get_pagenum_link($i); ?>" class="page-btn <?php echo ($paged == $i) ? 'active' : ''; ?>"><?php echo $i; ?></a>
										<?php endfor; ?>
									</div>
									<button id="popupPrev" class="arrow-btn"></button>
									<button id="popupNext" class="arrow-btn"></button>
								</div>
							</div>
						</div>
					</div>
					<!-- End -->
				</div>
		</div>
	</div>
</section>

<?php
		
	if ( have_posts() ) {
		while ( have_posts() ) {
			the_post();
			// Include specific template for the content.
			get_template_part( 'partials/content', 'page' );
		}
	} 
	?>
<?php
get_footer(); ?>