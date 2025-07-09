<?php

/**
 * Template Name: News
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
list($bst_var_post_id, $bst_fields, $bst_option_fields) = BaseTheme::defaults();

$li_news_temp_kicker_text = $bst_fields['li_news_temp_kicker_text'] ?? null;
$li_news_temp_headline_text = $bst_fields['li_news_temp_headline_text'] ?? null;
$li_news_headline_check  = BaseTheme::headline_check($li_news_temp_headline_text);
$li_news_temp_bg_image = $bst_fields['li_news_temp_bg_image'] ?? $bst_option_fields['li_to_select_default_background_pattern'];
$li_news_temp_logo_list_title = $bst_fields['li_news_temp_logo_list_title'] ?? null;
$li_news_temp_logo_list_repeater = $bst_fields['li_news_temp_logo_list_repeater'] ?? null;

?>

<div id="page-section" class="page-section">
	<?php
	$terms = get_terms([
		'taxonomy'   => 'news-type',
		'hide_empty' => true,
	]);

	$topic_terms = get_terms([
		'taxonomy'   => 'news-topic',
		'hide_empty' => true,
	]);
	?>

	<!-- news list -->

	<section id="hero-section" class="hero-section hero-section-default hero-alongside-standard">
		<!-- hero start -->
		<?php echo !empty($li_news_temp_bg_image) ? '<div class="bg-pattern">' . wp_get_attachment_image($li_news_temp_bg_image, 'thumb_2000') . '</div>' : ''; ?>
		<div class="hero-default has-border-bottom">
			<div class="wrapper">
				<div class="hero-alongside-block">
					<div class="col-left bg-lime-green">
						<div class="hero-content">
							<?php if ($li_news_temp_kicker_text): ?>
								<div class="ui-eyebrow-20-18-regular">
									<?php echo html_entity_decode($li_news_temp_kicker_text); ?>
								</div>
								<div class="gl-s20"></div>
							<?php endif; ?>
							<?php if ($li_news_headline_check): ?>
								<?php echo BaseTheme::headline($li_news_temp_headline_text, 'heading-1 mb-0 block-title'); ?>
								<div class="gl-s96"></div>
							<?php endif; ?>
						</div>
					</div>
					<div class="col-right">
						<?php echo !empty($li_news_temp_bg_image) ? '<div class="bg-pattern">' . wp_get_attachment_image($li_news_temp_bg_image, 'thumb_1600') . '</div>' : ''; ?>
					</div>
				</div>
			</div>
		</div>
	</section>
	<section class="container-1280 bg-lilac">
		<div class="gl-s36"></div>
		<div class="wrapper">
			<div class="logo-list-block">
				<?php echo (!empty($li_news_temp_logo_list_title)) ? '<div class="ui-20-18-bold-uc eybrow-title">' . esc_html($li_news_temp_logo_list_title) . '</div>' : ''; ?>
				<div class="gl-s30"></div>
				<div class="logo-list-row">
					<div class="swiper logolist-wrapp">
						<?php if (!empty($li_news_temp_logo_list_repeater)): ?>
							<div class="swiper-wrapper">
								<?php foreach ($li_news_temp_logo_list_repeater as $li_news_temp_logo_list_rep):
									$li_news_temp_logo = $li_news_temp_logo_list_rep['li_news_temp_logo'] ?? '';
									$li_news_temp_title = $li_news_temp_logo_list_rep['li_news_temp_title'] ?? '';
									$li_news_temp_text = $li_news_temp_logo_list_rep['li_news_temp_text'] ?? '';
									$li_news_temp_link = $li_news_temp_logo_list_rep['li_news_temp_link'] ?? null;

									$url = $li_news_temp_link['url'];

									if (!empty($li_news_temp_logo) || !empty($li_news_temp_title) || !empty($li_news_temp_text) || !empty($li_news_temp_link)): ?>
										<div class="swiper-slide">
											<?php echo !empty($li_news_temp_link) ? '<a href="' . esc_url($url) . '" class="logo-list-col">' : '<div class="logo-list-col">'; ?>
											<?php echo !empty($li_news_temp_logo) ? '<div class="brand-logo-img">' . wp_get_attachment_image($li_news_temp_logo, 'thumb_200') . '</div><div class="gl-s24"></div>' : ''; ?>
											<div class="card-list">
												<div class="card-item link-with-title with-arrow">
													<?php if (!empty($li_news_temp_title) || !empty($li_news_temp_text)): ?>
														<div class="card-item-left">
															<?php echo (!empty($li_news_temp_title)) ? '<div class="card-title ui-18-16-bold">' . esc_html($li_news_temp_title) . '</div>' : ''; ?>
															<?php echo (!empty($li_news_temp_title) && !empty($li_news_temp_text)) ? '<div class="gl-s2"></div>' : ''; ?>
															<?php echo (!empty($li_news_temp_text)) ? '<div class="card-content body-18-16-regular">' . esc_html($li_news_temp_text) . '</div>' : ''; ?>
														</div>
													<?php endif; ?>
													<div class="card-item-right">
														<div class="dot-btn">
															<img src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/src/images/right-circle-arrow.svg" alt="View PDF">
														</div>
													</div>
												</div>
											</div>
											<?php echo !empty($li_news_temp_link) ? '</a>' : '</div>'; ?>
										</div>
									<?php endif; ?>
								<?php endforeach; ?>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
		<div class="gl-s64"></div>
	</section>
	<section class="container-1280 bg-base-cream newsmain">
		<div class="wrapper">
			<div class="full-width-content has-border-bottom">
				<div class="filter-block">
					<div class="filter">
						<div class="filter-title ui-18-16-bold">Filter:</div>
						<div class="filter-mobile-dropdown icon-add ui-18-16-bold">Show Filter</div>
						<div class="filter-dropdown-row">
							<div class="tab-dropdown tab-dropdown-filter">
								<button class="dropdown-toggle" id="types-view" aria-expanded="false"
									aria-haspopup="true" aria-controls="news-type">Post type: All types<div class="arrow-icon"></div>
								</button>
							</div>
							<div class="tab-dropdown tab-dropdown-filter">
								<button class="dropdown-toggle" id="topic-view" aria-expanded="false"
									aria-haspopup="true" aria-controls="news-topic">Topic: All topics<div class="arrow-icon"></div>
								</button>
							</div>
						</div>
					</div>
					<?php
					$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;


					$tax_query = [];

					if (!empty($_GET['type']) && $_GET['type'] !== 'all') {
						$tax_query[] = [
							'taxonomy' => 'news-type',
							'field'    => 'slug',
							'terms'    => sanitize_text_field($_GET['type']),
						];
					}
				
					if (!empty($_GET['topic']) && $_GET['topic'] !== 'all') {
						$tax_query[] = [
							'taxonomy' => 'news-topic',
							'field'    => 'slug',
							'terms'    => sanitize_text_field($_GET['topic']),
						];
					}


					$args = [
						'post_type'      => 'news',
						'posts_per_page' => 6,
						'order'          => 'DESC',
						'paged'          => $paged,
						'post_status'    => 'publish',
					];
					if (!empty($tax_query)) {
						$args['tax_query'] = $tax_query;
					}
					$news = new WP_Query($args);

					if ($news->have_posts()) : ?>
						<div class="filter-content-cards-grid">
							<?php include get_template_directory() . '/partials/content-news-list.php'; ?>
						</div>
						<?php include get_template_directory() . '/partials/content-news-pagination.php'; ?>
					<?php endif; ?>		
				</div>
			</div>
		</div>
	</section>
<div class="news-list-filter">
	<ul id="news-type" class="dropdown-menu" role="menu" aria-labelledby="types-view">
		<li class="active"><a href="javascript:void(0)" data-term="all" data-taxonomy="news-type">All types</a></li>
		<?php if (!empty($terms) && !is_wp_error($terms)) : ?>
			<?php foreach ($terms as $term) : ?>
				<li>
					<a href="javascript:void(0)" data-term="<?php echo esc_attr($term->slug); ?>" data-taxonomy="news-type">
						<?php echo esc_html($term->name); ?>
					</a>
				</li>
			<?php endforeach; ?>
		<?php endif; ?>
	</ul>
	<ul id="news-topic" class="dropdown-menu" role="menu" aria-labelledby="topic-view">
		<li class="active"><a href="javascript:void(0)" data-term="all" data-taxonomy="news-topic">All Topics</a></li>
		<?php if (!empty($topic_terms) && !is_wp_error($topic_terms)) : ?>
			<?php foreach ($topic_terms as $topic_term) : ?>
				<li>
					<a href="javascript:void(0)" data-term="<?php echo esc_attr($topic_term->slug); ?>" data-taxonomy="news-topic">
						<?php echo esc_html($topic_term->name); ?>
					</a>
				</li>
			<?php endforeach; ?>
		<?php endif; ?>
	</ul>
</div>
	<?php

	if (have_posts()) {
		while (have_posts()) {
			the_post();
			// Include specific template for the content.
			get_template_part('partials/content', 'page');
		}
	}
	?>
	<?php
	get_footer(); ?>