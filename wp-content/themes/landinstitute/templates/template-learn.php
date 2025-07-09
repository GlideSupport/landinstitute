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
						<?php
						// Set up query
						$paged = get_query_var('paged') ? get_query_var('paged') : 1;
						$args = array(
							'post_type' => 'post',
							'posts_per_page' => 2,
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
						set_query_var('learn_query', $query);
set_query_var('paged_var', $paged);


						?>
						<div class="filter-cards-grid">
							<?php get_template_part('partials/content', 'learn-list'); ?>
						</div>

					<!-- Pagination -->
					<?php get_template_part('partials/content', 'learn-pagination'); ?>

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