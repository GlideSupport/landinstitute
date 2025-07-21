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
<div id="page-section" class="page-section">
<?php

	$learn_terms = get_terms([
		'taxonomy'   => 'learn-type',
		'hide_empty' => true,
	]);

	$topic_terms = get_terms([
		'taxonomy'   => 'learn-topic',
		'hide_empty' => true,
	]);
	
	$crop_terms_main = get_terms([
		'taxonomy'   => 'learn-crop',
		'hide_empty' => true,
	]);

	$audience_terms_main = get_terms([
		'taxonomy'   => 'learn-audience',
		'hide_empty' => true,
	]);

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
	<section class="container-1280 bg-base-cream mainlearn">
		<div class="gl-s128"></div>
		<div class="wrapper">
			<div class="resoruce-filter-title full-width-content has-border-bottom">
				<h2 class="heading-2 mb-0 block-title">Resources</h2>
				<div class="gl-s52"></div>
				<div class="filter-block">
					<?php 
						$current_learntype = isset($_GET['learn-type']) ? sanitize_text_field($_GET['learn-type']) : 'all';
						$current_learn_topic_slug = isset($_GET['learn-topic']) ? sanitize_text_field($_GET['learn-topic']) : 'all';
						$current_learn_crop_slug = isset($_GET['learn-crop']) ? sanitize_text_field($_GET['learn-crop']) : 'all';		
						$current_learn_audience_slug = isset($_GET['learn-audience']) ? sanitize_text_field($_GET['learn-audience']) : 'all';		


						// Set default display values
						$current_type_name  = 'All types';
						$current_topic_name = 'All topics';
						$current_crop_name = 'All Crops';
						$current_audience_name = 'All Audience';


						// Try to get the term objects if slugs are not "all"
						if ($current_learntype !== 'all') {
							$type_term = get_term_by('slug', $current_learntype, 'learn-type'); // 'type' is your taxonomy name
							if ($type_term && !is_wp_error($type_term)) {
								$current_type_name = $type_term->name;
							}
						}

						if ($current_learn_topic_slug !== 'all') {
							$topic_term = get_term_by('slug', $current_learn_topic_slug, 'learn-topic'); // 'topic' is your taxonomy name
							if ($topic_term && !is_wp_error($topic_term)) {
								$current_topic_name = $topic_term->name;
							}
						}

						if ($current_learn_crop_slug !== 'all') {
							$crop_terms = get_term_by('slug', $current_learn_crop_slug, 'learn-crop'); // 'topic' is your taxonomy name
							if ($crop_terms && !is_wp_error($crop_terms)) {
								$current_crop_name = $crop_terms->name;
							}
						}
						

						if ($current_learn_audience_slug !== 'all') {
							$learn_audience_terms = get_term_by('slug', $current_learn_audience_slug, 'learn-crop'); // 'topic' is your taxonomy name
							if ($learn_audience_terms && !is_wp_error($learn_audience_terms)) {
								$current_audience_name = $learn_audience_terms->name;
							}
						}



					?>
						<div class="filter">
							<div class="filter-title ui-18-16-bold">Filter:</div>
							<div class="filter-mobile-dropdown icon-add ui-18-16-bold">Show Filter</div>
							<div class="filter-dropdown-row">
								<?php if($bst_fields['li_learn_filters']['enable_learn_type']){ ?>
								<div class="tab-dropdown tab-dropdown-filter">
									<button class="dropdown-toggle" id="type-view" aria-expanded="false"
										aria-haspopup="true" aria-controls="learn-type">Type: <?php echo $current_type_name; ?><div class="arrow-icon"></div>
									</button>
								</div>
								<?php } ?>
								<?php if($bst_fields['li_learn_filters']['enable_learn_topic']){ ?>

								<div class="tab-dropdown tab-dropdown-filter">
									<button class="dropdown-toggle" id="topic-view" aria-expanded="false"
										aria-haspopup="true" aria-controls="learn-topic">Topic: <?php echo $current_topic_name; ?><div class="arrow-icon"></div>
									</button>
								</div>
								<?php } ?>
								<?php if($bst_fields['li_learn_filters']['enable_learn_crop']){ ?>

								<div class="tab-dropdown tab-dropdown-filter">
									<button class="dropdown-toggle" id="category-view" aria-expanded="false"
										aria-haspopup="true" aria-controls="learn-crops">Crop: <?php echo $current_crop_name; ?><div class="arrow-icon"></div>
									</button>
								</div>

								<?php } ?>
								<?php if($bst_fields['li_learn_filters']['enable_learn_audience']){ ?>
									<div class="tab-dropdown tab-dropdown-filter">
									<button class="dropdown-toggle" id="audience-view" aria-expanded="false"
										aria-haspopup="true" aria-controls="audience-view">Audience: <?php echo $current_crop_name; ?><div class="arrow-icon"></div>
									</button>
								</div>
								<?php } ?>
							</div>
						</div>

						<!-- PHP Dynamic Loop Start -->
							<?php
							// Set up query
							$paged = get_query_var('paged') ? get_query_var('paged') : 1;
							$args = [
								'post_type'      => 'post',
								'posts_per_page' => 12,
								'paged'          => $paged,
							];

							// Start building tax_query
							$tax_query = ['relation' => 'AND'];

							// Learn Type
							if (!empty($bst_fields['li_learn_filters']['enable_learn_type'])) {
								if (!empty($_GET['learn-type']) && $_GET['learn-type'] !== 'all') {
									$tax_query[] = [
										'taxonomy' => 'learn-type',
										'field'    => 'slug',
										'terms'    => sanitize_text_field($_GET['learn-type']),
									];
								}
							} else {
								$tax_query = array_merge($tax_query, get_taxonomy_exclusion_query('learn-type'));
							}

							// Learn Topic
							if (!empty($bst_fields['li_learn_filters']['enable_learn_topic'])) {
								if (!empty($_GET['learn-topic']) && $_GET['learn-topic'] !== 'all') {
									$tax_query[] = [
										'taxonomy' => 'learn-topic',
										'field'    => 'slug',
										'terms'    => sanitize_text_field($_GET['learn-topic']),
									];
								}
							} else {
								$tax_query = array_merge($tax_query, get_taxonomy_exclusion_query('learn-topic'));
							}

							// Learn Crop
							if (!empty($bst_fields['li_learn_filters']['enable_learn_crop'])) {
								if (!empty($_GET['learn-crop']) && $_GET['learn-crop'] !== 'all') {
									$tax_query[] = [
										'taxonomy' => 'learn-crop',
										'field'    => 'slug',
										'terms'    => sanitize_text_field($_GET['learn-crop']),
									];
								}
							} else {
								$tax_query = array_merge($tax_query, get_taxonomy_exclusion_query('learn-crop'));
							}

							// Apply tax_query if needed
							if (count($tax_query) > 1) {
								$args['tax_query'] = $tax_query;
							}

							echo '<pre>';
							print_r($args);
							echo '</pre>';

							$query = new WP_Query($args);

							// Store query and state for later use
							set_query_var('learn_query', $query);
							set_query_var('paged_var', $paged);
							$datafoundn = $query->have_posts() ? 'yes' : 'no';


							?>
						<?php $class = $query->have_posts() ? '' : ''; ?>
						<div class="filter-cards-grid <?php echo $class; ?>">
							<?php get_template_part('partials/content', 'learn-list'); ?>
						</div>
						<div class="not-found-append">
							<?php if($datafoundn == "no"){ ?>
							<div class="not-found-block">
								<div class="not-found">No resources found.</div>
							</div>
							<?php } ?>
						</div>

						<!-- Pagination -->
						<div class="fillter-bottom">
							<?php get_template_part('partials/content', 'learn-pagination'); ?>
						</div>
						<!-- End -->
					</div>
			</div>
		</div>
	</section>

	<?php
	
	// Learn Type
$taxonomy_learn_type = 'learn-type';
$learn_terms = get_terms(['taxonomy' => $taxonomy_learn_type, 'hide_empty' => true]);
$excluded_learn_type_slugs = get_excluded_term_slugs_by_taxonomy($taxonomy_learn_type);
$learn_terms = array_filter($learn_terms, fn($term) => !in_array($term->slug, $excluded_learn_type_slugs));

// Learn Topic
$taxonomy_learn_topic = 'learn-topic';
$topic_terms = get_terms(['taxonomy' => $taxonomy_learn_topic, 'hide_empty' => true]);
$excluded_learn_topic_slugs = get_excluded_term_slugs_by_taxonomy($taxonomy_learn_topic);
$topic_terms = array_filter($topic_terms, fn($term) => !in_array($term->slug, $excluded_learn_topic_slugs));

// Learn Crop
$taxonomy_learn_crop = 'learn-crop';
$crop_terms_main = get_terms(['taxonomy' => $taxonomy_learn_crop, 'hide_empty' => true]);
$excluded_learn_crop_slugs = get_excluded_term_slugs_by_taxonomy($taxonomy_learn_crop);
$crop_terms_main = array_filter($crop_terms_main, fn($term) => !in_array($term->slug, $excluded_learn_crop_slugs));


// Learn Audience
$taxonomy_learn_audience = 'learn-audience';
$audience_terms_main = get_terms(['taxonomy' => $taxonomy_learn_audience, 'hide_empty' => true]);
$excluded_learn_audience_slugs = get_excluded_term_slugs_by_taxonomy($taxonomy_learn_audience);
$audience_terms_main = array_filter($audience_terms_main, fn($term) => !in_array($term->slug, $excluded_learn_audience_slugs));



	?>
	<div class="learn-list-filter">
		<ul id="learn-type" class="dropdown-menu" role="menu" aria-labelledby="types-view">
			<li class="active"><a href="javascript:void(0)" data-term="all" data-taxonomy="learn-type">All types</a></li>
			<?php if (!empty($learn_terms)) : ?>
				<?php foreach ($learn_terms as $term) : ?>
					<li>
						<a href="javascript:void(0)" data-term="<?php echo esc_attr($term->slug); ?>" data-taxonomy="learn-type">
							<?php echo esc_html($term->name); ?>
						</a>
					</li>
				<?php endforeach; ?>
			<?php endif; ?>
		</ul>

		<ul id="learn-topic" class="dropdown-menu" role="menu" aria-labelledby="topic-view">
			<li class="active"><a href="javascript:void(0)" data-term="all" data-taxonomy="learn-topic">All Topics</a></li>
			<?php if (!empty($topic_terms)) : ?>
				<?php foreach ($topic_terms as $topic_term) : ?>
					<li>
						<a href="javascript:void(0)" data-term="<?php echo esc_attr($topic_term->slug); ?>" data-taxonomy="learn-topic">
							<?php echo esc_html($topic_term->name); ?>
						</a>
					</li>
				<?php endforeach; ?>
			<?php endif; ?>
		</ul>

		<ul id="learn-crops" class="dropdown-menu" role="menu" aria-labelledby="category-view">
			<li class="active"><a href="javascript:void(0)" data-term="all" data-taxonomy="learn-crop">All Crops</a></li>
			<?php if (!empty($crop_terms_main)) : ?>
				<?php foreach ($crop_terms_main as $crop_term) : ?>
					<li>
						<a href="javascript:void(0)" data-term="<?php echo esc_attr($crop_term->slug); ?>" data-taxonomy="learn-crop">
							<?php echo esc_html($crop_term->name); ?>
						</a>
					</li>
				<?php endforeach; ?>
			<?php endif; ?>
		</ul>

		<ul id="learn-audience" class="dropdown-menu" role="menu" aria-labelledby="audience-view">
			<li class="active"><a href="javascript:void(0)" data-term="all" data-taxonomy="learn-audience">All Audiences</a></li>
			<?php if (!empty($audience_terms_main)) : ?>
				<?php foreach ($audience_terms_main as $audience_term) : ?>
					<li>
						<a href="javascript:void(0)" data-term="<?php echo esc_attr($audience_term->slug); ?>" data-taxonomy="learn-audience">
							<?php echo esc_html($audience_term->name); ?>
						</a>
					</li>
				<?php endforeach; ?>
			<?php endif; ?>
		</ul>



	</div>
</div>
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